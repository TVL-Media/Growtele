#!/usr/bin/env python3
"""Reorder products mega menu, industry dropdown, industry sub-nav, and footer Products links site-wide."""

import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1] / "pages"

PRODUCT_ORDER = ("sms", "email", "cloud-telephony", "whatsapp", "rcs")
INDUSTRY_ORDER = ("banking", "retail", "health", "travelling", "ecommerce", "education", "logistic")


def slug_from_href(href: str) -> str:
    href = (href or "").lower().strip()
    # Longest slugs first so cloud-telephony wins over shorter partial matches.
    for slug in sorted(INDUSTRY_ORDER + PRODUCT_ORDER, key=len, reverse=True):
        if slug in href.replace("_", "-"):
            return slug
    return ""


def sort_anchor_items(inner: str, order: tuple[str, ...]) -> str:
    pattern = re.compile(
        r"<a\b[^>]*\b(?:gt-mega-menu__item|industry-solutions-dropdown-item|industry-nav__item)\b[^>]*>.*?</a>",
        re.DOTALL | re.IGNORECASE,
    )
    items = pattern.findall(inner)
    if len(items) < 2:
        return inner

    def rank(item: str) -> int:
        m = re.search(r'href="([^"]+)"', item, re.I)
        slug = slug_from_href(m.group(1) if m else "")
        try:
            return order.index(slug)
        except ValueError:
            return len(order)

    items.sort(key=rank)
    return "\n".join(items) + "\n"


def sort_footer_products(html: str) -> str:
    def repl(match: re.Match[str]) -> str:
        block = match.group(0)
        li_pat = re.compile(r"<li>\s*<a\b[^>]*>.*?</a>\s*</li>", re.DOTALL | re.I)
        lis = li_pat.findall(block)
        if len(lis) < 2:
            return block

        def rank(li: str) -> int:
            m = re.search(r'href="([^"]+)"', li, re.I)
            slug = slug_from_href(m.group(1) if m else "")
            try:
                return PRODUCT_ORDER.index(slug)
            except ValueError:
                return len(PRODUCT_ORDER)

        lis.sort(key=rank)
        ul_inner = "\n              ".join(lis)
        return re.sub(
            r"(<ul>\s*).*?(</ul>)",
            r"\1" + ul_inner + r"\n            \2",
            block,
            count=1,
            flags=re.DOTALL,
        )

    return re.sub(
        r'<div class="gt-footer__col">\s*<h4>Products</h4>\s*<ul>.*?</ul>\s*</div>',
        repl,
        html,
        flags=re.DOTALL | re.I,
    )


def sort_industry_subnav(html: str) -> str:
    def repl(m: re.Match[str]) -> str:
        sorted_inner = sort_anchor_items(m.group(2), INDUSTRY_ORDER).rstrip()
        return m.group(1) + sorted_inner + m.group(3)

    return re.sub(
        r'(<div class="industry-nav__bar">\s*)(.*?)(\s*</div>)',
        repl,
        html,
        count=1,
        flags=re.DOTALL | re.I,
    )


def process_file(path: Path) -> bool:
    text = path.read_text(encoding="utf-8")
    original = text

    def mega_repl(m: re.Match[str]) -> str:
        return m.group(1) + sort_anchor_items(m.group(2), PRODUCT_ORDER) + m.group(3)

    text = re.sub(
        r'(<div class="gt-mega-menu__links">)(.*?)(</div>\s*<aside class="gt-mega-menu__feature")',
        mega_repl,
        text,
        count=1,
        flags=re.DOTALL | re.I,
    )

    def industry_repl(m: re.Match[str]) -> str:
        return m.group(1) + sort_anchor_items(m.group(2), INDUSTRY_ORDER) + m.group(3)

    text = re.sub(
        r'(<div class="industry-solutions-dropdown-links">)(.*?)(</div>\s*<aside class="industry-solutions-dropdown-feature")',
        industry_repl,
        text,
        count=1,
        flags=re.DOTALL | re.I,
    )

    text = sort_footer_products(text)
    text = sort_industry_subnav(text)

    if text != original:
        path.write_text(text, encoding="utf-8")
        return True
    return False


def main() -> None:
    repo = ROOT.parent
    targets = list(ROOT.rglob("index.html"))
    targets.append(repo / "template-parts" / "header" / "fallback-menu.php")
    changed = 0
    for path in targets:
        if not path.is_file():
            continue
        if process_file(path):
            print(path.relative_to(repo))
            changed += 1
    print(f"Updated {changed} file(s)")


if __name__ == "__main__":
    main()
