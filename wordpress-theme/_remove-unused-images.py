#!/usr/bin/env python3
"""Remove image files under ogrowtele that are not referenced by project source files."""

from __future__ import annotations

import os
import re
from pathlib import Path
from urllib.parse import unquote, quote

ROOT = Path(__file__).resolve().parent
IMG_EXT = {".png", ".jpg", ".jpeg", ".gif", ".webp", ".svg", ".ico"}
SKIP_DIRS = {".git", "node_modules", ".cursor", "wordpress-theme", "theme-upload"}
TEXT_EXT = {
    ".html",
    ".css",
    ".js",
    ".php",
    ".json",
    ".md",
    ".xml",
    ".scss",
    ".vue",
    ".tsx",
    ".jsx",
    ".ts",
    ".py",
    ".ps1",
}
# Never delete these even if reference scan misses them.
PROTECT = {
    ROOT / "screenshot.png",
    ROOT / "assets" / "images" / "sections" / "screenshot.png",
}


def collect_images() -> list[Path]:
    images: list[Path] = []
    for dirpath, dirnames, filenames in os.walk(ROOT):
        dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS]
        for name in filenames:
            path = Path(dirpath) / name
            if path.suffix.lower() in IMG_EXT:
                images.append(path)
    return images


def collect_text_blobs() -> str:
    chunks: list[str] = []
    for dirpath, dirnames, filenames in os.walk(ROOT):
        dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS]
        for name in filenames:
            path = Path(dirpath) / name
            if path.suffix.lower() not in TEXT_EXT:
                continue
            if path.name == Path(__file__).name:
                continue
            try:
                chunks.append(path.read_text(encoding="utf-8", errors="ignore"))
            except OSError:
                pass
    return "\n".join(chunks)


def variants(path: Path) -> set[str]:
    rel = path.relative_to(ROOT).as_posix()
    name = path.name
    stem = path.stem
    out = {
        rel,
        rel.lower(),
        name,
        name.lower(),
        unquote(name),
        unquote(name).lower(),
        quote(name, safe=""),
        quote(name, safe="").lower(),
        quote(unquote(name), safe=""),
    }
    # Common relative forms used across pages.
    parts = rel.split("/")
    if len(parts) >= 2:
        out.add("/".join(parts[-2:]))
        out.add("/".join(parts[-3:])) if len(parts) >= 3 else None
        out.add(f"assets/{name}")
        out.add(f"../assets/{name}")
        out.add(f"../../assets/{name}")
    out.discard(None)
    return {v for v in out if v}


def is_referenced(path: Path, blob: str) -> bool:
    if path in PROTECT:
        return True
    blob_lower = blob.lower()
    for token in variants(path):
        if token and token.lower() in blob_lower:
            return True
    # Match filename with spaces encoded in CSS url(...).
    encoded_rel = quote(path.relative_to(ROOT).as_posix(), safe="/")
    if encoded_rel.lower() in blob_lower:
        return True
    return False


def main() -> None:
    images = collect_images()
    blob = collect_text_blobs()

    unused: list[Path] = []
    used = 0
    for img in images:
        if is_referenced(img, blob):
            used += 1
        else:
            unused.append(img)

    unused.sort(key=lambda p: p.stat().st_size, reverse=True)
    total_bytes = sum(p.stat().st_size for p in unused)

    print(f"Images scanned: {len(images)}")
    print(f"Referenced: {used}")
    print(f"Unused: {len(unused)} ({total_bytes / (1024 * 1024):.2f} MB)")

    for p in unused:
        print(f"DELETE\t{p.relative_to(ROOT).as_posix()}")
        p.unlink()

    print(f"Removed {len(unused)} unused image files.")


if __name__ == "__main__":
    main()
