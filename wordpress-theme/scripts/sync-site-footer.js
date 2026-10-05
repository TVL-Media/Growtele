'use strict';

const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '..');
const sourcePath = path.join(root, 'pages', 'about-us', 'index.html');
const source = fs.readFileSync(sourcePath, 'utf8');

function extractBlock(html, startMarker, endMarker) {
  const start = html.indexOf(startMarker);
  if (start === -1) return '';
  const end = html.indexOf(endMarker, start);
  if (end === -1) return '';
  return html.slice(start, end + endMarker.length);
}

const ctaTemplate = extractBlock(
  source,
  '<section class="gt-cta gt-section" id="cta">',
  '</section>'
);

const footerTemplate = extractBlock(
  source,
  '<footer id="colophon" class="gt-footer">',
  '</footer>'
);

if (!ctaTemplate || !footerTemplate) {
  console.error('Failed to extract CTA/footer template from about-us page.');
  process.exit(1);
}

function buildBlocks(assetPrefix, pagePrefix) {
  const replacePaths = (block) =>
    block
      .replace(/\.\.\/\.\.\/assets/g, assetPrefix)
      .replace(/\.\.\/([a-z0-9-]+)\/index\.html/g, `${pagePrefix}$1/index.html`)
      .replace(/\.\.\/index\.html/g, `${pagePrefix}index.html`);

  return {
    cta: replacePaths(ctaTemplate),
    footer: replacePaths(footerTemplate),
  };
}

const pageConfigs = [
  { file: 'pages/index.html', assets: '../assets', pages: '' },
  { file: 'pages/about-us/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/career/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/contact/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/blogs/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/sms/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/whatsapp/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/email/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/rcs/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/cloud-telephony/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/growinfinity-io/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/banking/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/ecommerce/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/education/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/health/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/logistic/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/retail/index.html', assets: '../../assets', pages: '../' },
  { file: 'pages/travelling/index.html', assets: '../../assets', pages: '../' },
];

function replaceFooter(html, footer) {
  return html
    .replace(/<footer class="footer">[\s\S]*?<\/footer>/, footer)
    .replace(/<footer id="colophon" class="gt-footer">[\s\S]*?<\/footer>/, footer);
}

function replaceOrInsertCta(html, cta) {
  if (/<section class="gt-cta gt-section" id="cta">[\s\S]*?<\/section>/.test(html)) {
    return html.replace(
      /<section class="gt-cta gt-section" id="cta">[\s\S]*?<\/section>/,
      cta
    );
  }

  return html.replace(
    /(\s*)<footer id="colophon" class="gt-footer">/,
    `\n${cta}\n$1<footer id="colophon" class="gt-footer">`
  ).replace(
    /(\s*)<footer class="footer">/,
    `\n${cta}\n$1<footer class="footer">`
  );
}

function ensureCssLinks(html, config) {
  let next = html;
  const isLanding = config.file === 'pages/index.html';
  const assetPrefix = config.assets;
  const sharedPrefix = isLanding ? 'shared' : '../shared';

  const footerCss = `<link rel="stylesheet" href="${assetPrefix}/css/footer.css?v=6">`;
  const landingFooterCss = `<link rel="stylesheet" href="${sharedPrefix}/css/landing-footer.css?v=6">`;
  const globalCss = `<link rel="stylesheet" href="${assetPrefix}/css/global.css">`;

  next = next.replace(/<link rel="stylesheet" href="(?:\.\.\/)*shared\/css\/footer\.css[^"]*">\s*/g, '');
  next = next.replace(/<link rel="stylesheet" href="(?:\.\.\/)*assets\/css\/footer\.css[^"]*">\s*/g, '');
  next = next.replace(/<link rel="stylesheet" href="(?:\.\.\/)*shared\/css\/landing-footer\.css[^"]*">\s*/g, '');

  if (!isLanding && !next.includes(`${assetPrefix}/css/global.css`)) {
    next = next.replace('</head>', `  ${globalCss}\n</head>`);
  }

  if (!next.includes(`${assetPrefix}/css/footer.css?v=6`)) {
    next = next.replace('</head>', `  ${footerCss}\n</head>`);
  } else {
    next = next.replace(/href="[^"]*\/css\/footer\.css[^"]*"/, `href="${assetPrefix}/css/footer.css?v=6"`);
  }

  if (!next.includes('landing-footer.css?v=6')) {
    next = next.replace('</head>', `  ${landingFooterCss}\n</head>`);
  } else {
    next = next.replace(/href="[^"]*landing-footer\.css[^"]*"/, `href="${sharedPrefix}/css/landing-footer.css?v=6"`);
  }

  return next;
}

pageConfigs.forEach((config) => {
  const filePath = path.join(root, config.file);
  let html = fs.readFileSync(filePath, 'utf8');
  const { cta, footer } = buildBlocks(config.assets, config.pages);

  html = replaceFooter(html, footer);
  html = replaceOrInsertCta(html, cta);
  html = ensureCssLinks(html, config);

  fs.writeFileSync(filePath, html, 'utf8');
  console.log('Updated', config.file);
});

console.log('Site footer sync complete.');
