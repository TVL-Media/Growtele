# Growtele Static Deployment Notes

Use this checklist when zipping the site and uploading to XAMPP, cPanel, or similar PHP/static hosting.

## Zip upload stuck / loading forever?

The full theme is **~280 MB** (PNG + MP4 assets). That is too large for **WordPress → Appearance → Themes → Upload Theme** on most hosts (limit is often **2–64 MB**). The browser will spin for many minutes and never finish.

**Do this instead:**

1. **Do not** include old zip files in a new zip (delete `wwe.zip` from the project first).
2. Create a clean zip: `powershell -ExecutionPolicy Bypass -File scripts/create-deploy-zip.ps1`
3. **Upload via FTP/SFTP** or **cPanel File Manager** (not WP theme uploader):
   - Extract into `wp-content/themes/growtele/` (or your theme folder name)
4. If you only changed JS/CSS/HTML, upload just those files — no need to re-upload the whole 280 MB zip.

**Optional:** Ask hosting to raise `upload_max_filesize` and `post_max_size` in PHP — still prefer FTP for files this large.

## Folder layout

Upload the **entire project root**, preserving this structure:

```text
/
  index.html              -> redirects to pages/index.html
  assets/                 -> shared CSS, JS, images
  pages/
    index.html            -> main landing page
    retail/
      index.html
      assets/             -> page-specific images/videos
    sms/
    ...
```

Do **not** upload only `pages/` without the root `assets/` folder. Many pages reference `../../assets/...`.

## What was fixed for live hosting

1. **`assets/js/resolve-asset-url.js`**
   - Resolves all relative image/video paths with the browser URL API.
   - URL-encodes spaces and special characters (important on Linux hosting).
   - Repairs `img`, `source`, and `video` elements on page load.
   - Keeps WordPress `GROWTELE_PAGE_ASSETS` support for theme deployments.

2. **CSS background images**
   - Encoded spaces in `pages/retail/css/style.css` (`BOX%20(2).png`).
   - Pointed education/ecommerce/logistic pages to their own local `*-BOX (2).png` files instead of cross-linking retail assets.

3. **Missing resolver script**
   - Added `resolve-asset-url.js` to: main landing, growtele-io, career, about-us, contact, blogs.

## Before creating the zip

1. Run asset verification:

   ```bash
   node scripts/verify-assets.js
   ```

   Fix any reported missing files before uploading.

2. Include **all** of these folders in the zip:
   - `/assets`
   - `/pages/**/assets`
   - `/pages/**/css`
   - `/pages/**/js`

3. Preserve filename case exactly. Linux servers are case-sensitive:
   - `ReTail X SMS.png` is different from `retail-x-sms.png`
   - `Health x Whatsapp.png` is different from `Health X Whatsapp.png`

## Subdirectory deployment

If the site is hosted at `https://example.com/growtelemob/` instead of the domain root:

- Keep the full folder structure intact under that subdirectory.
- Use relative links already present in HTML (`../assets/...`, `assets/...`).
- Do **not** change paths to start with `/assets/...`; that breaks subdirectory installs.

## External images

Many nav/hero sections load images from `https://listings.selectvia.com/...`.

- These work when the hosting server and visitor browser can reach that domain.
- If external images fail, mirror those files into local `assets/` and update the URLs, or host them on your own CDN.

## Pages most sensitive to asset issues

| Area | Risk |
|------|------|
| Industry pages (retail, health, banking, travelling) | Filenames with spaces and mixed case |
| Product pages (sms, whatsapp, rcs, email, cloud-telephony) | Prefixed assets like `whatsapp-Card 2.png` |
| Career page | Many `Rectangle 485.png`-style filenames with spaces |
| growtele-io | Local `assets/tab-*.png` tab icons |
| Education / ecommerce / logistic channel tabs | External CDN images in JS |

## Quick smoke test after upload

1. Open `pages/index.html`
2. Open one industry page, e.g. `pages/retail/index.html`
3. Open one product page, e.g. `pages/sms/index.html`
4. Open `pages/career/index.html`
5. In browser DevTools → Network, filter by **Img** and confirm no 404s for local files

## Common 404 causes

| Symptom | Likely cause |
|---------|--------------|
| Some images work locally on Windows but not on Linux | Case mismatch or spaces not encoded |
| Shared nav/footer images missing | Root `assets/` folder not uploaded |
| Channel phone mockups missing | Page `assets/` folder missing for that page |
| Background box behind channel tabs missing | CSS background image path or `BOX (2).png` not uploaded |
| Many hero/nav images missing | External `listings.selectvia.com` blocked or unreachable |
