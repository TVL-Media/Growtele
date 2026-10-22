#!/usr/bin/env python3
"""
Convert theme PNGs to WebP without visible quality loss.

For every PNG under assets/ and pages/ the smallest encoding that still clears
the quality bar is kept (lossy q85 -> lossy q92 -> lossless). Quality is the PSNR
against the original, alpha-composited over a light and a dark background.
PNGs that do not shrink by at least MIN_SAVING stay PNG.

Conversion is decided per basename: a basename is converted only if every PNG
that shares it converts, so reference rewriting (rewrite-image-refs.py) can be a
plain basename swap.

Usage (from the theme root):
    python3 scripts/optimize-images.py            # convert + delete converted PNGs
    python3 scripts/optimize-images.py --dry-run  # report only

Requires Pillow.
"""
import argparse
import io
import json
import math
import os
import sys
from collections import defaultdict
from multiprocessing import Pool

from PIL import Image, ImageChops, ImageStat

ROOTS = ("assets", "pages")
MIN_PSNR = 40.0
MIN_SAVING = 0.10
LOSSY_STEPS = (85, 92)
BACKGROUNDS = ((255, 255, 255, 255), (10, 10, 30, 255))
LOSSLESS_MAX_PIXELS = 12_000_000
MANIFEST = "scripts/image-manifest.json"


def load(path):
    im = Image.open(path)
    im.load()
    if im.mode == "P":
        im = im.convert("RGBA")
    elif im.mode not in ("RGB", "RGBA"):
        im = im.convert("RGBA" if "A" in im.getbands() or "transparency" in im.info else "RGB")
    return im


def composite(im, bg):
    base = Image.new("RGBA", im.size, bg)
    return Image.alpha_composite(base, im.convert("RGBA")).convert("RGB")


def psnr(a, b):
    worst = 99.0
    backgrounds = BACKGROUNDS if "A" in a.getbands() else (None,)
    for bg in backgrounds:
        ca = composite(a, bg) if bg else a
        cb = composite(b, bg) if bg else b
        diff = ImageChops.difference(ca, cb)
        sq = sum(ImageStat.Stat(diff).sum2)
        mse = sq / (ca.size[0] * ca.size[1] * 3)
        worst = min(worst, 99.0 if mse == 0 else 10 * math.log10(255 ** 2 / mse))
    return worst


def encode(im, **kw):
    buf = io.BytesIO()
    im.save(buf, "WEBP", **kw)
    return buf.getvalue()


def convert(path):
    png_size = os.path.getsize(path)
    try:
        im = load(path)
        best = None
        for q in LOSSY_STEPS:
            data = encode(im, quality=q, method=6)
            if psnr(im, Image.open(io.BytesIO(data))) >= MIN_PSNR:
                best = ("lossy-q%d" % q, data)
                break
        if im.size[0] * im.size[1] <= LOSSLESS_MAX_PIXELS and (best is None or png_size < 400_000):
            data = encode(im, lossless=True, quality=100, method=6)
            if best is None or len(data) < len(best[1]):
                best = ("lossless", data)
        if best is None:
            data = encode(im, lossless=True, quality=100, method=4)
            best = ("lossless", data)
        mode, data = best
        if len(data) > png_size * (1 - MIN_SAVING):
            return path, png_size, None, "kept-png", None
        return path, png_size, data, mode, im.size
    except Exception as exc:  # noqa: BLE001 - report and keep the PNG
        return path, png_size, None, "error: %s" % exc, None


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    ap.add_argument("--jobs", type=int, default=os.cpu_count())
    args = ap.parse_args()

    pngs = []
    for root in ROOTS:
        for dirpath, _, files in os.walk(root):
            for name in files:
                if name.lower().endswith(".png"):
                    pngs.append(os.path.join(dirpath, name))
    pngs.sort(key=os.path.getsize, reverse=True)

    with Pool(args.jobs) as pool:
        results = pool.map(convert, pngs, chunksize=1)

    by_name = defaultdict(list)
    for r in results:
        by_name[os.path.basename(r[0])].append(r)

    converted, skipped = [], []
    saved = before = after = 0
    for name, group in sorted(by_name.items()):
        if all(r[2] is not None for r in group):
            converted.append(name)
            for path, png_size, data, mode, _ in group:
                before += png_size
                after += len(data)
                if not args.dry_run:
                    with open(os.path.splitext(path)[0] + ".webp", "wb") as fh:
                        fh.write(data)
                    os.remove(path)
        else:
            skipped.append((name, [r[3] for r in group]))

    print("converted basenames: %d   kept as PNG: %d" % (len(converted), len(skipped)))
    print("converted files: %.1f MB -> %.1f MB" % (before / 1e6, after / 1e6))
    modes = defaultdict(int)
    for group in by_name.values():
        for r in group:
            modes[r[3]] += 1
    print("encodings:", dict(modes))
    for name, why in skipped[:30]:
        print("  kept png:", name, why)

    if not args.dry_run:
        with open(MANIFEST, "w") as fh:
            json.dump({"converted": converted, "kept": [n for n, _ in skipped]}, fh, indent=1)
    return 0


if __name__ == "__main__":
    sys.exit(main())
