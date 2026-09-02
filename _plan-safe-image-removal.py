from pathlib import Path
import os
import hashlib
import re
from collections import defaultdict

ROOT = Path(__file__).resolve().parent
IMG_EXT = {".png", ".jpg", ".jpeg", ".gif", ".webp", ".svg", ".ico", ".bmp", ".avif"}
SCAN_EXT = {".html", ".css", ".js", ".php", ".json"}
SKIP_DIRS = {".git", "wordpress-theme", "node_modules", ".cursor"}


def file_hash(path):
    h = hashlib.md5()
    with open(path, "rb") as f:
        while block := f.read(1024 * 1024):
            h.update(block)
    return h.hexdigest()


def collect_images():
    by_hash = defaultdict(list)
    for dp, dns, fns in os.walk(ROOT):
        if any(s in Path(dp).parts for s in SKIP_DIRS):
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
            by_hash[file_hash(p)].append((p, sz))
    return {h: g for h, g in by_hash.items() if len(g) > 1}


def collect_references():
    refs = defaultdict(set)  # rel_path -> set of referencing files
    patterns = [
        re.compile(r"url\s*\(\s*['\"]?([^'\"\)]+)['\"]?\s*\)", re.I),
        re.compile(r"(?:src|href|content|data-src)\s*=\s*['\"]([^'\"]+)['\"]", re.I),
        re.compile(r"['\"]([^'\"]+\.(?:png|jpg|jpeg|gif|webp|svg|ico|bmp|avif))['\"]", re.I),
    ]
    for dp, dns, fns in os.walk(ROOT):
        if any(s in Path(dp).parts for s in SKIP_DIRS):
            dns[:] = []
            continue
        for f in fns:
            if Path(f).suffix.lower() not in SCAN_EXT:
                continue
            src = Path(dp) / f
            try:
                text = src.read_text(encoding="utf-8", errors="ignore")
            except OSError:
                continue
            ref_file = src.relative_to(ROOT)
            for pat in patterns:
                for m in pat.finditer(text):
                    raw = m.group(1).split("?")[0].split("#")[0].strip()
                    if not raw or raw.startswith(("http://", "https://", "data:", "//")):
                        continue
                    refs[raw].add(str(ref_file))

    return refs


def resolve_ref(ref, from_file):
    """Try to resolve a reference string to an absolute project path."""
    ref = ref.replace("\\", "/")
    base = (ROOT / from_file).parent
    candidates = []

    if ref.startswith("/"):
        candidates.append(ROOT / ref.lstrip("/"))
    else:
        candidates.append((base / ref).resolve())
        candidates.append((ROOT / ref).resolve())

    for c in candidates:
        try:
            c.relative_to(ROOT)
        except ValueError:
            continue
        if c.exists() and c.is_file():
            return c
    return None


def build_usage_map(refs):
    used = set()
    unresolved = []
    for ref, sources in refs.items():
        for src in sources:
            p = resolve_ref(ref, src)
            if p:
                used.add(p.resolve())
            else:
                unresolved.append((ref, src))
    return used, unresolved


def main():
    dups = collect_images()
    refs = collect_references()
    used, unresolved = build_usage_map(refs)

    safe_delete = []
    needs_update = []
    keep_both = []

    for h, group in dups.items():
        group_paths = [p.resolve() for p, _ in group]
        referenced = [p for p in group_paths if p in used]
        unreferenced = [p for p in group_paths if p not in used]

        if len(referenced) <= 1 and unreferenced:
            # Keep the one referenced file (or first if none referenced)
            keeper = referenced[0] if referenced else group_paths[0]
            for p in group_paths:
                if p != keeper:
                    safe_delete.append((p, keeper, sum(sz for pp, sz in group if pp.resolve() == p)))
        elif len(referenced) > 1:
            # Multiple referenced copies - need to consolidate references
            keeper = min(referenced, key=lambda p: len(str(p)))
            for p in group_paths:
                if p != keeper and p in used:
                    needs_update.append((p, keeper))
                elif p != keeper:
                    safe_delete.append((p, keeper, next(sz for pp, sz in group if pp.resolve() == p)))

    print("=== SAFE REMOVAL PLAN (main project only) ===")
    print(f"Duplicate groups: {len(dups)}")
    print(f"Files safe to delete (unreferenced duplicates): {len(safe_delete)}")
    print(f"Wasted bytes removable: {sum(x[2] for x in safe_delete)/1024/1024:.1f} MB")
    print(f"Referenced duplicates needing path updates: {len(needs_update)}")
    print()

    print("Top deletions (unreferenced copies):")
    for p, keeper, sz in sorted(safe_delete, key=lambda x: -x[2])[:20]:
        print(f"  DELETE {p.relative_to(ROOT)} ({sz/1024/1024:.2f} MB)")
        print(f"    keep {keeper.relative_to(ROOT)}")
    print()

    if needs_update:
        print("Referenced duplicates (would update refs, then delete):")
        for p, keeper in needs_update[:15]:
            print(f"  UPDATE refs: {p.relative_to(ROOT)} -> {keeper.relative_to(ROOT)}")
        if len(needs_update) > 15:
            print(f"  ... +{len(needs_update)-15} more")
    print()

    # Also check wordpress-theme - recommend delete whole folder instead
    wt = ROOT / "wordpress-theme"
    if wt.exists():
        wt_imgs = sum(f.stat().st_size for f in wt.rglob("*") if f.is_file() and f.suffix.lower() in IMG_EXT)
        print(f"wordpress-theme/ has {wt_imgs/1024/1024:.1f} MB images (stale build output - recommend rebuild, not patch)")

    print(f"\nUnresolved refs (won't touch): {len(unresolved)}")


if __name__ == "__main__":
    main()
