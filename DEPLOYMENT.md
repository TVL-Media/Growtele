# Growtele Static Deployment Notes

Use this checklist when zipping the site and uploading to XAMPP, cPanel, or similar PHP/static hosting.

## Theme size

The theme is about **51 MB**, and the install zip is about **46 MB**. Images are WebP and videos are 1080p H.264 without audio. That fits **WordPress → Appearance → Themes → Upload Theme** on hosts that allow 64 MB. If your host's limit is lower, upload via FTP/SFTP or cPanel File Manager to `wp-content/themes/growtele/`.

1. **Do not** include old zip files in a new zip (delete `wwe.zip` from the project first).
2. Create a clean install zip: `powershell -ExecutionPolicy Bypass -File scripts/create-theme-install-zip.ps1`
3. If you only changed JS/CSS/HTML, upload just those files.

### Keeping it small

- **Images:** add new images as PNG/JPEG, then run `python3 scripts/convert-images-webp.py`. It converts them to WebP, picking the quality setting by measurement so they stay visually lossless, and it deletes the source files. It then rewrites every local reference in HTML/CSS/JS/PHP. `--dry-run` reports what it would do without changing anything. Only the root `screenshot.png` stays PNG, because WordPress requires it.
- **Videos:** encode background videos the same way as the existing ones:
  `ffmpeg -i in.mp4 -an -vf "scale='min(1920,iw)':-2" -c:v libx264 -preset slow -crf 23 -pix_fmt yuv420p -movflags +faststart out.mp4`
- `wordpress-theme/` is a build output of `build-theme.ps1` and is git-ignored. Don't commit it.

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
   - Encoded spaces in `pages/retail/css/style.css` (`BOX%20(2).webp`).
   - Pointed education/ecommerce/logistic pages to their own local `*-BOX (2).webp` files instead of cross-linking retail assets.

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
   - `ReTail X SMS.webp` is different from `retail-x-sms.webp`
   - `Health x Whatsapp.webp` is different from `Health X Whatsapp.webp`

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
| Product pages (sms, whatsapp, rcs, email, cloud-telephony) | Prefixed assets like `whatsapp-Card 2.webp` |
| Career page | Many `Rectangle 485.webp`-style filenames with spaces |
| growtele-io | Local `assets/tab-*.webp` tab icons |
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
| Background box behind channel tabs missing | CSS background image path or `BOX (2).webp` not uploaded |
| Many hero/nav images missing | External `listings.selectvia.com` blocked or unreachable |
