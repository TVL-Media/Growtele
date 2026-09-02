#!/usr/bin/env python3
"""Sync retail layout CSS/JS/structure to banking, health, travelling main pages."""

from __future__ import annotations

import re
from pathlib import Path

ROOT = Path(__file__).resolve().parent / "pages"
RETAIL = ROOT / "retail"
TARGETS = ("banking", "health", "travelling")

CSS_EXTRA = """

/* Keep per-page usecase image class names working with retail sizing rules */
.usecase-card__image1,
.usecase-card__image2,
.usecase-card__image3,
.usecase-card__image4 {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
"""


def extract_channel_data(js_text: str) -> str | None:
    match = re.search(r"var channelData = \{.*?\n  \};", js_text, re.DOTALL)
    return match.group(0) if match else None


def patch_html(html: str) -> str:
    html = html.replace(
        '    <section class="channels">\n      <div class="container">\n        <div class="channels__header">',
        '    <section class="channels">\n      <div class="channels__scroll-stage">\n        <div class="container channels__sticky">\n          <div class="channels__header">',
        1,
    )

    html = html.replace(
        '        </div>\n      </div>\n      <img src="assets/bg-pattern.png" alt="" class="channels__bg-pattern" aria-hidden="true">',
        '        </div>\n      </div>\n      </div>\n      <img src="assets/bg-pattern.png" alt="" class="channels__bg-pattern" aria-hidden="true">',
        1,
    )

    html = html.replace(
        '        <div class="growth__cards">',
        '        <div class="growth__cards" data-skip-word-reveal>',
        1,
    )

    html = html.replace(
        '        <div class="usecases__cards">',
        '        <div class="usecases__viewport" data-usecases-carousel>\n          <div class="usecases__cards" data-skip-word-reveal>',
        1,
    )

    html = html.replace(
        '        </div>\n        <div class="usecases__dots"',
        '          </div>\n        </div>\n        <div class="usecases__dots"',
        1,
    )

    html = re.sub(
        r'(<span class="usecases__dot(?: usecases__dot--active)?")',
        r'\1 data-usecases-dot',
        html,
    )

    html = re.sub(
        r'href="css/style\.css\?[^"]+"',
        'href="css/style.css?v=retail-sync"',
        html,
    )
    html = html.replace('href="css/style.css?v=btn-arrow2"', 'href="css/style.css?v=retail-sync"')
    html = html.replace('href="css/style.css"', 'href="css/style.css?v=retail-sync"')

    html = re.sub(
        r'src="js/script\.js(?:\?[^"]*)?"',
        'src="js/script.js?v=retail-sync"',
        html,
    )

    return html


def main() -> None:
    retail_css = (RETAIL / "css/style.css").read_text(encoding="utf-8") + CSS_EXTRA
    retail_js = (RETAIL / "js/script.js").read_text(encoding="utf-8")

    for slug in TARGETS:
        target = ROOT / slug
        (target / "css/style.css").write_text(retail_css, encoding="utf-8")

        existing_js = (target / "js/script.js").read_text(encoding="utf-8")
        channel_data = extract_channel_data(existing_js)
        if not channel_data:
            raise SystemExit(f"Could not extract channelData from {slug}/js/script.js")

        merged_js = re.sub(
            r"var channelData = \{.*?\n  \};",
            channel_data,
            retail_js,
            count=1,
            flags=re.DOTALL,
        )
        (target / "js/script.js").write_text(merged_js, encoding="utf-8")

        html_path = target / "index.html"
        html_path.write_text(patch_html(html_path.read_text(encoding="utf-8")), encoding="utf-8")
        print(f"Synced {slug}")


if __name__ == "__main__":
    main()
