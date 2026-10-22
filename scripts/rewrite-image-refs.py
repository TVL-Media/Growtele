#!/usr/bin/env python3
"""
Point theme source files at the .webp copies made by optimize-images.py.

Reads scripts/image-manifest.json and swaps `<basename>.png` -> `<basename>.webp`
in HTML/CSS/JS/PHP/JSON sources. References to external hosts (CDN URLs) are left
alone. Handles raw and percent-encoded spellings of file names.

Usage (from the theme root):
    python3 scripts/rewrite-image-refs.py [--dry-run]
"""
import argparse
import json
import os
import re
import sys
from urllib.parse import quote

MANIFEST = "scripts/image-manifest.json"
EXTS = {".html", ".css", ".js", ".php", ".json"}
SKIP_DIRS = {".git", "wordpress-theme", "node_modules", "admin"}
# characters that may directly precede a file name inside a URL / string / url()
PREFIX = r"(?<=[/\"'(=>,])"
# the opening delimiter of the string/url() that contains a match
OPENERS = "\"'(`\n"


def variants(name):
    seen = []
    for v in (name, quote(name), quote(name, safe="()"), name.replace(" ", "%20"), name.replace(" ", "+")):
        if v not in seen:
            seen.append(v)
    return seen


def build_pattern(names):
    alts = set()
    for name in names:
        for v in variants(name):
            alts.add(re.escape(v))
    ordered = sorted(alts, key=len, reverse=True)
    return re.compile(PREFIX + "(" + "|".join(ordered) + r")\.png(?![A-Za-z0-9_])")


def is_external(text, start):
    i = start
    while i > 0 and text[i - 1] not in OPENERS:
        i -= 1
    head = text[i:start]
    return "://" in head or head.startswith("//")


def rewrite(text, pattern):
    count = 0

    def sub(m):
        nonlocal count
        if is_external(text, m.start()):
            return m.group(0)
        count += 1
        return m.group(1) + ".webp"

    return pattern.sub(sub, text), count


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    with open(MANIFEST) as fh:
        names = json.load(fh)["converted"]
    names = [n[:-4] for n in names if n.lower().endswith(".png")]
    pattern = build_pattern(names)

    total_files = total_refs = 0
    for dirpath, dirnames, files in os.walk("."):
        dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS and not d.startswith(".tmp")]
        for fname in files:
            if os.path.splitext(fname)[1].lower() not in EXTS:
                continue
            path = os.path.join(dirpath, fname)
            if path.startswith("./scripts/"):
                continue
            with open(path, encoding="utf-8", errors="surrogateescape", newline="") as fh:
                text = fh.read()
            new, n = rewrite(text, pattern)
            if n:
                total_files += 1
                total_refs += n
                if not args.dry_run:
                    with open(path, "w", encoding="utf-8", errors="surrogateescape", newline="") as fh:
                        fh.write(new)
    print("rewrote %d references in %d files%s" % (total_refs, total_files, " (dry run)" if args.dry_run else ""))
    return 0


if __name__ == "__main__":
    sys.exit(main())
