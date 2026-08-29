# Growtele WordPress Theme

Self-contained installable WordPress theme with homepage + all product/industry pages.

## Install

1. **Build the theme package** (copies all assets into the theme folder):

   ```powershell
   .\build-theme.ps1
   ```

2. **Zip and upload** the `wordpress-theme/` folder to WordPress:
   - Rename folder to `growtele` (optional)
   - Upload to `wp-content/themes/growtele/`
   - Or zip `wordpress-theme/` and install via **Appearance → Themes → Add New → Upload**

3. **Activate** the theme in WordPress admin.

4. On activation, these pages are created automatically:
   - `/sms/` — SMS Page
   - `/whatsapp/` — WhatsApp Page
   - `/email/` — Email Page
   - `/retail/` — Retail Page
   - `/health/` — Health Page

5. Set **Settings → Reading → Homepage** to a static front page (or use default blog with `front-page.php`).

## Folder structure (after build)

```
wordpress-theme/
├── assets/          ← CSS, JS, images (copied from ../assets/)
├── pages/           ← Static HTML pages (copied, not modified)
│   ├── sms/
│   ├── whatsapp/
│   ├── email/
│   ├── retail/
│   └── health/
├── page-templates/  ← WordPress page templates
├── template-parts/  ← Homepage sections
├── inc/             ← Theme logic
└── style.css        ← Theme header
```

## Re-build after asset changes

Whenever you update CSS/JS/images or static HTML pages in the repo root, re-run:

```powershell
.\build-theme.ps1
```

Then re-upload or redeploy the theme.

## Notes

- HTML/CSS source files are **not modified** — PHP injects `<base href>` and rewrites `../` links at runtime.
- Homepage uses `front-page.php` with section template parts.
- Elementor override supported on front page via `growtele_is_elementor_page()`.
