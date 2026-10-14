# Site content (Markdown)

One file per page with every piece of visible copy, in page order: headings, paragraphs, buttons, list items, FAQ Q&A, tab and accordion content, image alt text, form placeholders, and the SEO title/description. Shared navigation and footer copy is in `_shared-header-footer.md`.

The files were extracted from the **live site** (`listings.selectvia.com`, theme v2.11.0) by rendering each page in a browser, so they include copy that JavaScript swaps in on tab clicks and anything saved in the content admin.

- `_wording-review.md` lists every "bulk"-style term with a premium replacement. It also flags a content bug: all the SMS FAQ answers are identical.
- Lines marked _(hidden by default)_ belong to tabs, accordions or mobile-only blocks. Lines marked _(tab/accordion content)_ appear after a click.

## Rewriting with an agent
1. Give the agent one page file plus your brief (tone, words to avoid, …).
2. Ask it to keep every `##` section heading, every `**Label:**` and the order unchanged, and to keep text lengths close to the original so the layout doesn't shift.
3. Paste the new copy back:
   - **Static pages:** `pages/<page>/index.html` (path in each file's `theme_source`).
   - **CMS defaults:** product, industry, company, home and navigation copy also lives in `inc/content/defaults/*.php` (path in `cms_defaults`). The theme's content admin finds text by exact match, so **the HTML and the PHP default must be identical**. Change both.
   - **Home page:** the live home is built in **Elementor**, so edit it in WordPress → Pages → Home → Edit with Elementor.

## Re-exporting
```bash
npm i -D playwright          # once
node scripts/export-content-md.js https://listings.selectvia.com docs/content
```
`docs/` is left out of the theme zips.
