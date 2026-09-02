from pathlib import Path
import os
import hashlib
from collections import defaultdict

ROOT = Path(__file__).resolve().parent
IMG_EXT = {".png", ".jpg", ".jpeg", ".gif", ".webp", ".svg", ".ico", ".bmp", ".avif"}


def file_hash(path, chunk=1024 * 1024):
    h = hashlib.md5()
    with open(path, "rb") as f:
        while True:
            block = f.read(chunk)
            if not block:
                break
            h.update(block)
    return h.hexdigest()


def collect_images(root, skip_git=True, skip_wordpress_theme=False):
    files = []
    for dp, dns, fns in os.walk(root):
        parts = Path(dp).parts
        if skip_git and ".git" in parts:
            dns[:] = []
            continue
        if skip_wordpress_theme and "wordpress-theme" in parts:
            dns[:] = []
            continue
        for f in fns:
            p = Path(dp) / f
            if p.suffix.lower() not in IMG_EXT:
                continue
            try:
                sz = p.stat().st_size
            except OSError:
                continue
            files.append((p, sz))
    return files


def analyze(files, root):
    by_hash = defaultdict(list)
    for p, sz in files:
        by_hash[file_hash(p)].append((p, sz))

    dup_groups = []
    total_waste = 0
    total_dup_files = 0
    total_dup_bytes_all_copies = 0

    for h, group in by_hash.items():
        if len(group) < 2:
            continue
        group.sort(key=lambda x: str(x[0]))
        sz = group[0][1]
        copies = len(group)
        waste = sz * (copies - 1)
        total_waste += waste
        total_dup_files += copies - 1
        total_dup_bytes_all_copies += sz * copies
        dup_groups.append(
            {
                "size": sz,
                "copies": copies,
                "waste": waste,
                "paths": [p.relative_to(root) for p, _ in group],
            }
        )

    dup_groups.sort(key=lambda g: (-g["waste"], -g["size"]))
    return dup_groups, total_waste, total_dup_files, total_dup_bytes_all_copies


def mb(b):
    return b / 1024 / 1024


def print_report(label, skip_wt):
    files = collect_images(ROOT, skip_git=True, skip_wordpress_theme=skip_wt)
    total_img_bytes = sum(sz for _, sz in files)
    groups, waste, dup_files, dup_all = analyze(files, ROOT)

    print(f"=== {label} ===")
    print(f"Total images scanned: {len(files):,} ({mb(total_img_bytes):.1f} MB)")
    print(f"Duplicate groups: {len(groups):,}")
    print(f"Extra duplicate files: {dup_files:,}")
    print(f"Wasted space (extra copies only): {mb(waste):.1f} MB")
    print(f"All bytes in duplicate sets: {mb(dup_all):.1f} MB")
    print(f"Duplicate waste as % of all images: {100 * waste / total_img_bytes:.1f}%")
    print()

    print("Top 15 duplicate sets by wasted space:")
    for g in groups[:15]:
        print(
            f"  {mb(g['size']):6.2f} MB x {g['copies']} copies "
            f"= {mb(g['waste']):6.1f} MB wasted"
        )
        for p in g["paths"][:4]:
            print(f"    {p}")
        if len(g["paths"]) > 4:
            print(f"    ... +{len(g['paths']) - 4} more")
        print()

    # waste by top folder of duplicate copies (excluding first kept copy)
    folder_waste = defaultdict(int)
    folder_extra = defaultdict(int)
    for g in groups:
        for i, p in enumerate(g["paths"]):
            if i == 0:
                continue
            top = p.parts[0] if p.parts else "(root)"
            folder_waste[top] += g["size"]
            folder_extra[top] += 1

    print("Wasted duplicate space by folder (extra copies only):")
    for name, sz in sorted(folder_waste.items(), key=lambda x: -x[1]):
        print(f"  {name:20} {mb(sz):7.1f} MB  ({folder_extra[name]} extra files)")
    print()


print_report("MAIN PROJECT (no .git, no wordpress-theme)", skip_wt=True)
print_report("WHOLE PROJECT (no .git, includes wordpress-theme)", skip_wt=False)
