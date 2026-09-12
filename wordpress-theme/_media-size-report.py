from pathlib import Path
import os
from collections import defaultdict

ROOT = Path(__file__).resolve().parent
IMG_EXT = {".png", ".jpg", ".jpeg", ".gif", ".webp", ".svg", ".ico", ".bmp", ".avif"}
VID_EXT = {".mp4", ".webm", ".mov", ".avi", ".mkv", ".m4v"}


def scan(root, skip_git=True, skip_wordpress_theme=False):
    img_total = vid_total = 0
    img_count = vid_count = 0
    by_ext_img = defaultdict(lambda: [0, 0])
    by_ext_vid = defaultdict(lambda: [0, 0])
    by_top = defaultdict(lambda: {"img": 0, "vid": 0, "img_n": 0, "vid_n": 0})

    for dp, dns, fns in os.walk(root):
        parts = Path(dp).parts
        if skip_git and ".git" in parts:
            dns[:] = []
            continue
        if skip_wordpress_theme and "wordpress-theme" in parts:
            dns[:] = []
            continue
        rel_top = Path(dp).relative_to(root).parts[0] if Path(dp) != root else "(root)"
        for f in fns:
            p = Path(dp) / f
            ext = p.suffix.lower()
            try:
                sz = p.stat().st_size
            except OSError:
                continue
            if ext in IMG_EXT:
                img_total += sz
                img_count += 1
                by_ext_img[ext][0] += sz
                by_ext_img[ext][1] += 1
                by_top[rel_top]["img"] += sz
                by_top[rel_top]["img_n"] += 1
            elif ext in VID_EXT:
                vid_total += sz
                vid_count += 1
                by_ext_vid[ext][0] += sz
                by_ext_vid[ext][1] += 1
                by_top[rel_top]["vid"] += sz
                by_top[rel_top]["vid_n"] += 1
    return img_total, vid_total, img_count, vid_count, by_ext_img, by_ext_vid, by_top


def mb(b):
    return b / 1024 / 1024


for label, skip_wt in [
    ("MAIN PROJECT (no .git, no wordpress-theme duplicate)", True),
    ("WHOLE PROJECT (no .git, includes wordpress-theme)", False),
]:
    img, vid, ic, vc, ei, ev, bt = scan(ROOT, skip_git=True, skip_wordpress_theme=skip_wt)
    print(f"=== {label} ===")
    print(f"Images: {ic:,} files = {mb(img):.1f} MB")
    print(f"Videos: {vc:,} files = {mb(vid):.1f} MB")
    print(f"Combined: {ic + vc:,} files = {mb(img + vid):.1f} MB")
    print()
    print("  Images by type:")
    for ext, (sz, n) in sorted(ei.items(), key=lambda x: -x[1][0]):
        print(f"    {ext:6} {n:5} files  {mb(sz):7.1f} MB")
    print("  Videos by type:")
    for ext, (sz, n) in sorted(ev.items(), key=lambda x: -x[1][0]):
        print(f"    {ext:6} {n:5} files  {mb(sz):7.1f} MB")
    print("  By top folder:")
    for name, d in sorted(bt.items(), key=lambda x: -(x[1]["img"] + x[1]["vid"])):
        t = d["img"] + d["vid"]
        if t > 100_000:
            print(
                f"    {name:20} img {mb(d['img']):7.1f} MB ({d['img_n']})  "
                f"vid {mb(d['vid']):7.1f} MB ({d['vid_n']})  total {mb(t):7.1f} MB"
            )
    print()
