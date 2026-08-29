#!/usr/bin/env python3
"""Make each page under pages/copies fully independent."""

from __future__ import annotations

import re
import shutil
from pathlib import Path
from urllib.parse import quote, unquote

ROOT = Path(__file__).resolve().parent
COPIES = ROOT / "pages" / "copies"
SHARED_SRC = COPIES / "_shared"

SMS_COPIES = {
    "email": "email",
    "whatsapp": "whatsapp",
    "rcs": "rcs",
    "cloud telephony": "cloud-telephony",
}

RETAIL_COPIES = {
    "banking": "banking",
    "healthcare": "healthcare",
    "travelling": "travelling",
    "logistic": "logistic",
    "education": "education",
    "ecommerce": "ecommerce",
}


def build_asset_rename_map(assets_dir: Path, slug: str) -> dict[str, str]:
    mapping: dict[str, str] = {}
    prefix = f"{slug}-"
    for path in sorted(assets_dir.iterdir()):
        if not path.is_file():
            continue
        old_name = path.name
        if old_name.startswith(prefix):
            mapping[old_name] = old_name
            continue
        new_name = prefix + old_name
        mapping[old_name] = new_name
    return mapping


def rename_assets(assets_dir: Path, mapping: dict[str, str]) -> None:
    # Rename to temp names first to avoid collisions on case-insensitive FS.
    temp: list[tuple[Path, Path]] = []
    for old_name, new_name in mapping.items():
        if old_name == new_name:
            continue
        src = assets_dir / old_name
        if not src.exists():
            continue
        tmp = assets_dir / f"__tmp__{new_name}"
        src.rename(tmp)
        temp.append((tmp, assets_dir / new_name))
    for tmp, dest in temp:
        tmp.rename(dest)


def replace_asset_refs(text: str, mapping: dict[str, str]) -> str:
    # Longest names first so partial matches do not break longer filenames.
    for old_name, new_name in sorted(mapping.items(), key=lambda item: len(item[0]), reverse=True):
        if old_name == new_name:
            continue
        encoded_old = quote(old_name, safe="")
        encoded_new = quote(new_name, safe="")
        text = text.replace(f"assets/{old_name}", f"assets/{new_name}")
        text = text.replace(f"assets/{encoded_old}", f"assets/{encoded_new}")
        text = text.replace(f"../assets/{old_name}", f"../assets/{new_name}")
        text = text.replace(f"../assets/{encoded_old}", f"../assets/{encoded_new}")
    return text


def copy_local_shared(copy_dir: Path) -> None:
    dest = copy_dir / "shared"
    if dest.exists():
        shutil.rmtree(dest)
    shutil.copytree(SHARED_SRC, dest)


def isolate_copy(folder_name: str, slug: str, is_sms: bool) -> None:
    copy_dir = COPIES / folder_name
    if not copy_dir.is_dir():
        raise SystemExit(f"Missing copy folder: {copy_dir}")

    assets_dir = copy_dir / "assets"
    css_dir = copy_dir / "css"
    js_dir = copy_dir / "js"
    index_file = copy_dir / "index.html"

    mapping = build_asset_rename_map(assets_dir, slug)
    rename_assets(assets_dir, mapping)
    copy_local_shared(copy_dir)

    if is_sms:
        css_main_src = css_dir / "styles.css"
        css_nav_src = css_dir / "sms-nav.css"
        js_src = js_dir / "main.js"
        css_main_dest = css_dir / f"{slug}-styles.css"
        css_nav_dest = css_dir / f"{slug}-nav.css"
        js_dest = js_dir / f"{slug}-main.js"
    else:
        css_main_src = css_dir / "style.css"
        css_nav_src = css_dir / "sms-nav.css"
        js_src = js_dir / "script.js"
        css_main_dest = css_dir / f"{slug}-style.css"
        css_nav_dest = css_dir / f"{slug}-nav.css"
        js_dest = js_dir / f"{slug}-script.js"

    for src, dest in (
        (css_main_src, css_main_dest),
        (css_nav_src, css_nav_dest),
        (js_src, js_dest),
    ):
        if src.exists() and src != dest:
            if dest.exists():
                dest.unlink()
            src.rename(dest)

    files_to_update = [index_file, css_main_dest, css_nav_dest, js_dest]
    for path in files_to_update:
        if not path.exists():
            continue
        text = path.read_text(encoding="utf-8")
        text = replace_asset_refs(text, mapping)
        text = text.replace("../_shared/", "shared/")
        text = text.replace('href="css/styles.css', f'href="css/{slug}-styles.css')
        text = text.replace('href="css/style.css', f'href="css/{slug}-style.css')
        text = text.replace('href="css/sms-nav.css', f'href="css/{slug}-nav.css')
        text = text.replace('src="js/main.js', f'src="js/{slug}-main.js')
        text = text.replace('src="js/script.js', f'src="js/{slug}-script.js')
        path.write_text(text, encoding="utf-8")

    print(f"Isolated {folder_name} -> slug '{slug}'")


def main() -> None:
    if not SHARED_SRC.is_dir():
        raise SystemExit(f"Missing shared folder: {SHARED_SRC}")

    for folder, slug in SMS_COPIES.items():
        isolate_copy(folder, slug, is_sms=True)

    for folder, slug in RETAIL_COPIES.items():
        isolate_copy(folder, slug, is_sms=False)

    print("All copies are now independent.")


if __name__ == "__main__":
    main()
