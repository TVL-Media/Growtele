#!/usr/bin/env python3
"""Convert theme PNG/JPEG images to WebP and rewrite every local reference.

Each converted original is deleted so only the .webp remains.

Usage (from repo root):
    python3 scripts/convert-images-webp.py --dry-run   # report only
    python3 scripts/convert-images-webp.py             # convert + rewrite

Encoding rules (quality first):
- Opaque images:          lossy WebP q=85, method=6
- Images with real alpha: lossy WebP q=90, alpha_quality=100
- If the result is below TARGET_PSNR vs. the source, step up to q95, then q100.
- Lossless WebP is used instead whenever it is within 15% of the lossy size
  (typical for flat icons/UI), and always for icons up to 128x128 px.
- Images wider than MAX_WIDTH px are downscaled to MAX_WIDTH (retina-safe).
"""

from __future__ import annotations

import argparse
import io
import json
import math
import os
import re
from concurrent.futures import ProcessPoolExecutor
from pathlib import Path
from urllib.parse import unquote

from PIL import Image, ImageChops, ImageStat

ROOT = Path(__file__).resolve().parent.parent
IMAGE_DIRS = ["assets", "pages"]
SRC_EXT = {".png", ".jpg", ".jpeg"}
# WordPress requires the theme thumbnail to stay screenshot.png.
SKIP_BASENAMES = {"screenshot.png"}
TEXT_DIRS = ["", "inc", "template-parts", "page-templates", "pages", "assets", "scripts"]
TEXT_EXT = {".html", ".css", ".js", ".php", ".json"}
SKIP_DIRS = {".git", "node_modules", "wordpress-theme", "dist"}
MAX_WIDTH = 2560
LOSSY_Q = 85
ALPHA_Q = 90
LOSSLESS_SLACK = 1.15
TARGET_PSNR = 40.0  # dB vs. source; ~visually lossless
SMALL_PIXELS = 128 * 128  # icons and tiny UI bits always go lossless

# A local image reference: walk back from ".png"/".jpg" to the nearest quote or
# tag delimiter. Spaces and parentheses are allowed because real filenames use
# them (e.g. "BOX (2).png").
REF_RE = re.compile(r"""[^"'`<>=\n\r\t]*?\.(?:png|jpe?g)(?=[?#"'`)\s,;\\]|$)""", re.IGNORECASE)


def has_real_alpha(im: Image.Image) -> bool:
    if im.mode in ("RGBA", "LA") or (im.mode == "P" and "transparency" in im.info):
        return im.convert("RGBA").getchannel("A").getextrema()[0] < 255
    return False


def save_webp(im: Image.Image, **kwargs) -> bytes:
    buf = io.BytesIO()
    im.save(buf, "WEBP", **kwargs)
    return buf.getvalue()


def visible_psnr(a: Image.Image, b: Image.Image) -> float:
    """PSNR of two images as seen on a white page (alpha composited)."""
    white = Image.new("RGBA", a.size, (255, 255, 255, 255))
    a = Image.alpha_composite(white, a.convert("RGBA")).convert("RGB")
    b = Image.alpha_composite(white, b.convert("RGBA")).convert("RGB")
    mse = sum(v * v for v in ImageStat.Stat(ImageChops.difference(a, b)).rms) / 3
    return 99.0 if mse == 0 else 10 * math.log10(255 * 255 / mse)


def encode(path: Path) -> tuple[bytes, dict]:
    im = Image.open(path)
    icc = im.info.get("icc_profile")
    alpha = has_real_alpha(im)
    im = im.convert("RGBA" if alpha else "RGB")
    resized = None
    if im.width > MAX_WIDTH:
        h = round(im.height * MAX_WIDTH / im.width)
        resized = (im.width, im.height, MAX_WIDTH, h)
        im = im.resize((MAX_WIDTH, h), Image.Resampling.LANCZOS)

    extra = {"icc_profile": icc} if icc else {}
    lossless = save_webp(im, lossless=True, quality=100, method=4, exact=alpha, **extra)
    if im.width * im.height <= SMALL_PIXELS:
        return lossless, {"mode": "lossless", "resized": resized, "psnr": None}

    # Quality ladder: first lossy setting that is visually transparent wins.
    lossy = b""
    psnr = 0.0
    for q in (ALPHA_Q if alpha else LOSSY_Q, 95, 100):
        if alpha:
            lossy = save_webp(im, quality=q, alpha_quality=100, method=6, **extra)
        else:
            lossy = save_webp(im, quality=q, method=6, **extra)
        if len(lossless) <= len(lossy) * LOSSLESS_SLACK:
            return lossless, {"mode": "lossless", "resized": resized, "psnr": None}
        psnr = visible_psnr(im, Image.open(io.BytesIO(lossy)))
        if psnr >= TARGET_PSNR:
            break
    else:
        if len(lossless) <= len(lossy) * 2:
            return lossless, {"mode": "lossless", "resized": resized, "psnr": None}
    data, mode = lossy, f"lossy-q{q}" + ("-alpha" if alpha else "")
    return data, {"mode": mode, "resized": resized, "psnr": round(psnr, 1)}


def collect_images() -> list[Path]:
    out: list[Path] = []
    for d in IMAGE_DIRS:
        for dirpath, dirnames, filenames in os.walk(ROOT / d):
            dirnames[:] = [x for x in dirnames if x not in SKIP_DIRS]
            for name in filenames:
                p = Path(dirpath) / name
                if p.suffix.lower() in SRC_EXT and name not in SKIP_BASENAMES:
                    out.append(p)
    return sorted(out)


def collect_text_files() -> list[Path]:
    out: list[Path] = []
    for d in TEXT_DIRS:
        base = ROOT / d
        if d == "":
            out += [p for p in base.iterdir() if p.is_file() and p.suffix.lower() in TEXT_EXT]
            continue
        for dirpath, dirnames, filenames in os.walk(base):
            dirnames[:] = [x for x in dirnames if x not in SKIP_DIRS]
            out += [Path(dirpath) / n for n in filenames if Path(n).suffix.lower() in TEXT_EXT]
    return sorted(set(out))


def rewrite_text(text: str, converted: set[str]) -> tuple[str, int]:
    count = 0

    def repl(m: re.Match) -> str:
        nonlocal count
        ref = m.group(0)
        bare = ref.strip()
        if bare.lower().startswith("url("):
            bare = bare[4:].strip()
        if re.match(r"(?i)^(https?:)?//|^data:", bare):
            return ref
        base = unquote(bare.replace("\\/", "/")).rsplit("/", 1)[-1]
        if base not in converted:
            return ref
        count += 1
        return re.sub(r"(?i)\.(png|jpe?g)$", ".webp", ref)

    return REF_RE.sub(repl, text), count


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    images = collect_images()
    converted: set[str] = set()
    manifest = []
    before = after = 0
    with ProcessPoolExecutor() as pool:
        results = list(pool.map(encode, images, chunksize=4))
    for p, (data, info) in zip(images, results):
        target = p.with_suffix(".webp")
        size = p.stat().st_size
        before += size
        after += len(data)
        manifest.append({"from": str(p.relative_to(ROOT)), "to": str(target.relative_to(ROOT)),
                         "bytes_before": size, "bytes_after": len(data), **info})
        converted.add(p.name)
        if not args.dry_run:
            target.write_bytes(data)
            p.unlink()

    edits = 0
    for f in collect_text_files():
        text = f.read_text(encoding="utf-8", errors="surrogateescape")
        new, n = rewrite_text(text, converted)
        if n:
            edits += n
            print(f"  {n:4d} refs  {f.relative_to(ROOT)}")
            if not args.dry_run:
                f.write_text(new, encoding="utf-8", errors="surrogateescape")

    print(f"Images: {len(images)}  {before / 2**20:.1f} MB -> {after / 2**20:.1f} MB")
    print(f"References rewritten: {edits}")
    if not args.dry_run:
        (ROOT / "dist").mkdir(exist_ok=True)
        (ROOT / "dist" / "webp-manifest.json").write_text(json.dumps(manifest, indent=1))


if __name__ == "__main__":
    main()
