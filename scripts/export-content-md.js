#!/usr/bin/env node
'use strict';

/**
 * Export every page's visible copy to Markdown (docs/content/<page>.md) so it can be
 * handed to any writing agent and pasted back.
 *
 * Renders pages in Chromium (so JS-injected tab/card copy and CMS overrides are
 * included), clicks through tabs/accordions to collect swapped-in content, and
 * labels each block (H1, Paragraph, Button, FAQ Q/A, Image alt, ...).
 *
 * Usage:
 *   npm i -D playwright            # once, if not installed globally
 *   node scripts/export-content-md.js [baseUrl] [outDir]
 *   node scripts/export-content-md.js https://listings.selectvia.com docs/content
 */

const fs = require('fs');
const path = require('path');

function loadPlaywright() {
  try {
    return require('playwright');
  } catch (e) {
    return require('/opt/node22/lib/node_modules/playwright');
  }
}

const { chromium } = loadPlaywright();

const BASE = (process.argv[2] || 'https://listings.selectvia.com').replace(/\/$/, '');
const OUT = path.resolve(process.argv[3] || path.join(__dirname, '..', 'docs', 'content'));

// slug => [route, title, theme source HTML, CMS defaults file]
const PAGES = [
  ['home', '/', 'Home', 'pages/index.html + template-parts/sections/*.php (live home is built in Elementor)', 'inc/content/defaults/home-data.php'],
  ['sms', '/sms/', 'SMS', 'pages/sms/index.html', 'inc/content/defaults/products.php'],
  ['whatsapp', '/whatsapp/', 'WhatsApp', 'pages/whatsapp/index.html', 'inc/content/defaults/products.php'],
  ['email', '/email/', 'Email', 'pages/email/index.html', 'inc/content/defaults/products.php'],
  ['rcs', '/rcs/', 'RCS', 'pages/rcs/index.html', 'inc/content/defaults/products.php'],
  ['cloud-telephony', '/cloud-telephony/', 'Voice / Cloud Telephony', 'pages/cloud-telephony/index.html', 'inc/content/defaults/products.php'],
  ['retail', '/retail/', 'Retail', 'pages/retail/index.html', 'inc/content/defaults/industries.php'],
  ['health', '/health/', 'Healthcare', 'pages/health/index.html', 'inc/content/defaults/industries.php'],
  ['banking', '/banking/', 'Banking', 'pages/banking/index.html', 'inc/content/defaults/industries.php'],
  ['travelling', '/travelling/', 'Travel', 'pages/travelling/index.html', 'inc/content/defaults/industries.php'],
  ['ecommerce', '/ecommerce/', 'E-commerce', 'pages/ecommerce/index.html', 'inc/content/defaults/industries.php'],
  ['education', '/education/', 'Education', 'pages/education/index.html', 'inc/content/defaults/industries.php'],
  ['logistic', '/logistic/', 'Logistics', 'pages/logistic/index.html', 'inc/content/defaults/industries.php'],
  ['about-us', '/about-us/', 'About Us', 'pages/about-us/index.html', 'inc/content/defaults/company.php'],
  ['career', '/career/', 'Career', 'pages/career/index.html', 'inc/content/defaults/company.php'],
  ['contact', '/contact/', 'Contact', 'pages/contact/index.html', 'inc/content/defaults/company.php'],
  ['growinfinity-io', '/growinfinity-io/', 'Growinfinity.io', 'pages/growinfinity-io/index.html', '—'],
  ['blogs', '/blogs/', 'Blogs', 'pages/blogs/index.html', '—'],
  ['blog-top-5-advanced-features-scalable-sms', '/blogs/top-5-advanced-features-scalable-sms/', 'Blog: Top 5 Advanced Features of Scalable SMS', 'pages/blogs/top-5-advanced-features-scalable-sms/index.html', '—'],
  ['api-documentation', '/api-documentation/', 'API Documentation', 'pages/api-documentation/index.html', '—'],
  ['privacy-policy', '/privacy-policy/', 'Privacy Policy', 'pages/privacy-policy/index.html (body: pages/shared/legal/)', '—'],
  ['terms-and-condition', '/terms-and-condition/', 'Terms & Conditions', 'pages/terms-and-condition/index.html (body: pages/shared/legal/)', '—'],
  ['security', '/security/', 'Security', 'pages/security/index.html', '—'],
  ['partners-term-of-use', '/partners-term-of-use/', 'Partner Terms of Use', 'pages/partners-term-of-use/index.html (body: pages/shared/legal/)', '—'],
];

const TAB_SELECTOR = [
  '[role="tab"]', '[data-tab]', '[data-channel]', '[data-funnel]', '.tab', '.tabs button',
  '.gt-industries__tab', '.channel-tab', '.channels__tab', '.funnel__tab', '.journey__tab',
  '.platform-tabs button', '.faq-item__header', '.faq-item button', 'summary', '.accordion button',
].join(', ');

/* Runs in the page: returns [{zone, section, label, text, hidden}] in DOM order. */
function collectBlocks() {
  const SKIP = new Set(['SCRIPT', 'STYLE', 'NOSCRIPT', 'SVG', 'TEMPLATE', 'IFRAME']);
  const out = [];

  const zoneOf = (el) => {
    if (el.closest('footer, .gt-footer, .site-footer, .footer')) return 'footer';
    if (el.closest('header, nav, .gt-header, .site-header, .nav, .header, .mobile-nav, [class*="mega-menu"], [class*="megamenu"], [class*="dropdown"]')) return 'header';
    return 'main';
  };

  const sectionOf = (el) => {
    // Nearest real section container: <section>, Elementor containers, or a class token
    // that IS a section (".hero-section", "section-faq") — not ".gt-section-heading__title".
    let sec = el.parentElement;
    const isSection = (n) => n.tagName === 'SECTION' || (n.matches && n.matches('.elementor-section, .e-con.e-parent')) ||
      (typeof n.className === 'string' && n.className.split(/\s+/).some((c) => /(^|-)section$|^section(-|$)/.test(c)));
    while (sec && sec !== document.body && !isSection(sec)) sec = sec.parentElement;
    if (sec === document.body) sec = null;
    if (!sec) return 'Page';
    const heading = sec.querySelector('h1, h2, h3');
    const cls = (sec.id ? '#' + sec.id : '') || (typeof sec.className === 'string' ? '.' + sec.className.trim().split(/\s+/)[0] : '');
    const title = heading ? heading.innerHTML.replace(/<br\b[^>]*>/gi, ' ').replace(/<[^>]+>/g, '').replace(/&amp;/g, '&').replace(/\s+/g, ' ').trim().slice(0, 80) : '';
    return (title || '(untitled)') + (cls ? '  `' + cls + '`' : '');
  };

  const labelOf = (el) => {
    const tag = el.tagName;
    const cls = typeof el.className === 'string' ? el.className.toLowerCase() : '';
    const inFaq = !!el.closest('[class*="faq"]');
    if (/^H[1-3]$/.test(tag)) return tag;
    if (inFaq && (el.closest('button, summary, [class*="question"], [class*="header"], [class*="title"]'))) return 'FAQ Q';
    if (inFaq && el.closest('[class*="body"], [class*="answer"], [class*="content"], p')) return 'FAQ A';
    if (/^H[1-6]$/.test(tag)) return tag;
    if (tag === 'BUTTON' || el.closest('button') || /\bbtn\b|button|cta/.test(cls)) return 'Button';
    if (tag === 'A' || el.closest('a')) return 'Link';
    if (tag === 'LI' || el.closest('li')) return 'List item';
    if (tag === 'LABEL') return 'Form label';
    if (tag === 'BLOCKQUOTE' || el.closest('blockquote')) return 'Quote';
    if (/badge|eyebrow|tag|pill|kicker|label/.test(cls)) return 'Eyebrow/Badge';
    if (/stat|counter|metric|number/.test(cls)) return 'Stat';
    if (tag === 'P') return 'Paragraph';
    return 'Text';
  };

  const isHidden = (el) => {
    const r = el.getBoundingClientRect();
    const cs = getComputedStyle(el);
    return !r.width || !r.height || cs.visibility === 'hidden' || cs.display === 'none' || parseFloat(cs.opacity) === 0;
  };

  const BLOCK = /^(H[1-6]|P|LI|BUTTON|A|LABEL|BLOCKQUOTE|FIGCAPTION|SUMMARY|DT|DD|TD|TH)$/;
  const INLINE = /^(STRONG|B|EM|I|SPAN|BR|A|SMALL|SUP|SUB|MARK|U|IMG|svg|SVG)$/;
  const clean = (t) => (t || '').replace(/\s+/g, ' ').trim();
  const decoder = document.createElement('textarea');
  // Text with every <br> read as a space (mobile-only <br>s otherwise glue words together).
  const fullText = (el) => {
    decoder.innerHTML = el.innerHTML
      .replace(/<(i|span)\b[^>]*class="[^"]*(toggle|icon|arrow)[^"]*"[^>]*>[\s\S]*?<\/\1>/gi, '')
      .replace(/<br\b[^>]*>/gi, ' ').replace(/<(script|style)[^>]*>[\s\S]*?<\/\1>/gi, '').replace(/<[^>]+>/g, '');
    return clean(decoder.value);
  };
  const push = (el, text) => {
    if (text.length > 1 && /[A-Za-z0-9]/.test(text)) {
      out.push({ zone: zoneOf(el), section: sectionOf(el), label: labelOf(el), text, hidden: isHidden(el) });
    }
  };

  const walk = (el) => {
    if (SKIP.has(el.tagName)) return;
    const inlineOnly = [...el.children].every((c) => INLINE.test(c.tagName));
    if (inlineOnly && (BLOCK.test(el.tagName) || clean(el.textContent))) {
      // Whole text run of a block (headings animated word-by-word stay one line).
      const text = fullText(el);
      if (text) {
        push(el, text);
        el.querySelectorAll('img[alt]').forEach((img) => walk(img));
        return;
      }
    }
    const own = clean([...el.childNodes].filter((n) => n.nodeType === 3).map((n) => n.textContent).join(' '));
    if (own) push(el, own);
    if (el.tagName === 'IMG' && (el.getAttribute('alt') || '').trim()) {
      out.push({ zone: zoneOf(el), section: sectionOf(el), label: 'Image alt', text: el.getAttribute('alt').trim(), hidden: isHidden(el) });
    }
    if ((el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') && (el.getAttribute('placeholder') || '').trim()) {
      out.push({ zone: zoneOf(el), section: sectionOf(el), label: 'Placeholder', text: el.getAttribute('placeholder').trim(), hidden: isHidden(el) });
    }
    for (const c of el.children) walk(c);
  };

  walk(document.body);
  return out;
}

async function capturePage(browser, route) {
  const ctx = await browser.newContext({ viewport: { width: 1440, height: 900 } });
  const page = await ctx.newPage();
  await page.goto(BASE + route, { waitUntil: 'load', timeout: 90000 });
  const height = await page.evaluate(() => document.documentElement.scrollHeight);
  for (let y = 0; y < height; y += 600) {
    await page.evaluate((v) => window.scrollTo(0, v), y);
    await page.waitForTimeout(120);
  }
  await page.waitForTimeout(1200);

  const meta = await page.evaluate(() => ({
    title: document.title,
    description: (document.querySelector('meta[name="description"]') || {}).content || '',
    ogTitle: (document.querySelector('meta[property="og:title"]') || {}).content || '',
    ogDescription: (document.querySelector('meta[property="og:description"]') || {}).content || '',
  }));

  const seen = new Set();
  const blocks = [];
  const keyOf = (b) => b.zone + '|' + b.section + '|' + b.label + '|' + b.text;
  // First pass keeps repeats (repeated copy is content too, e.g. duplicated FAQ answers);
  // later passes after tab clicks only add copy that was not on the page before.
  const add = (list, extra) => {
    for (const b of list) {
      if (extra && seen.has(keyOf(b))) continue;
      seen.add(keyOf(b));
      blocks.push(Object.assign({}, b, extra || {}));
    }
  };
  add(await page.evaluate(collectBlocks));

  // Click through tabs/accordions so JS-swapped copy is captured too.
  const count = await page.locator(TAB_SELECTOR).count();
  for (let i = 0; i < Math.min(count, 120); i++) {
    const el = page.locator(TAB_SELECTOR).nth(i);
    try {
      if (!(await el.isVisible())) continue;
      await el.scrollIntoViewIfNeeded({ timeout: 1000 });
      await el.click({ timeout: 1000, noWaitAfter: true });
      await page.waitForTimeout(250);
      add(await page.evaluate(collectBlocks), { swapped: true });
    } catch (e) {
      /* ignore non-interactive matches */
    }
  }

  await ctx.close();
  return { meta, blocks };
}

function mdEscape(text) {
  return text.replace(/\|/g, '\\|');
}

function renderBlocks(blocks) {
  // Keep tab/accordion copy under the section it belongs to (first-appearance order).
  const order = new Map();
  blocks.forEach((b) => { if (!order.has(b.section)) order.set(b.section, order.size); });
  blocks = blocks.map((b, i) => [b, i]).sort((x, y) => order.get(x[0].section) - order.get(y[0].section) || x[1] - y[1]).map((x) => x[0]);
  const lines = [];
  let section = null;
  for (const b of blocks) {
    if (b.section !== section) {
      section = b.section;
      lines.push('', '## ' + section, '');
    }
    const notes = [];
    if (b.swapped) notes.push('tab/accordion content');
    else if (b.hidden) notes.push('hidden by default');
    lines.push('- **' + b.label + ':** ' + mdEscape(b.text) + (notes.length ? '  _(' + notes.join(', ') + ')_' : ''));
  }
  return lines.join('\n');
}

const AGENT_NOTE = [
  '> **For the editing agent:** rewrite the copy only. Keep every heading (`##`), every label',
  '> (`**H2:**`, `**Paragraph:**` …) and the order unchanged, so each line can be pasted back',
  '> into the same place. Keep text lengths close to the original so layouts do not shift.',
  '> Product, industry and company copy also lives in the CMS defaults file listed above —',
  '> when pasting back, the HTML and the CMS default must stay identical.',
].join('\n');

(async () => {
  fs.mkdirSync(OUT, { recursive: true });
  const browser = await chromium.launch({ executablePath: process.env.CHROMIUM_PATH || undefined }).catch(() =>
    chromium.launch({ executablePath: '/opt/pw-browsers/chromium' })
  );
  const stamp = new Date().toISOString().slice(0, 10);
  let shared = null;

  for (const [slug, route, title, source, cms] of PAGES) {
    process.stdout.write('Exporting ' + route + ' ... ');
    try {
      const { meta, blocks } = await capturePage(browser, route);
      const main = blocks.filter((b) => b.zone === 'main');
      if (!shared) shared = blocks.filter((b) => b.zone !== 'main');

      const md = [
        '---',
        'page: ' + title,
        'url: ' + BASE + route,
        'theme_source: ' + source,
        'cms_defaults: ' + cms,
        'extracted: ' + stamp,
        '---',
        '',
        '# ' + title + ' — page content',
        '',
        AGENT_NOTE,
        '',
        '## Meta (SEO)',
        '',
        '- **Title tag:** ' + mdEscape(meta.title),
        '- **Meta description:** ' + mdEscape(meta.description || '(none)'),
        meta.ogTitle ? '- **OG title:** ' + mdEscape(meta.ogTitle) : '',
        meta.ogDescription ? '- **OG description:** ' + mdEscape(meta.ogDescription) : '',
        renderBlocks(main),
        '',
      ].filter((l) => l !== '').join('\n').replace(/\n## /g, '\n\n## ') + '\n';

      fs.writeFileSync(path.join(OUT, slug + '.md'), md);
      console.log(main.length + ' blocks');
    } catch (e) {
      console.log('FAILED: ' + e.message);
    }
  }

  if (shared) {
    const md = [
      '---',
      'page: Shared header, navigation and footer',
      'url: ' + BASE + '/sms/ (same on every page)',
      'theme_source: template-parts/header/*.php, template-parts/footer/*.php, and the header/footer markup inside each pages/*/index.html',
      'cms_defaults: inc/content/defaults/global.php, inc/content/defaults/footer.php',
      'extracted: ' + stamp,
      '---',
      '',
      '# Shared header, navigation & footer — content',
      '',
      AGENT_NOTE,
      renderBlocks(shared),
      '',
    ].join('\n');
    fs.writeFileSync(path.join(OUT, '_shared-header-footer.md'), md);
  }

  await browser.close();
})();
