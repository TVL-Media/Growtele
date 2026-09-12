const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '..');
const pages = [
  'pages/sms/index.html',
  'pages/whatsapp/index.html',
  'pages/email/index.html',
  'pages/rcs/index.html',
  'pages/cloud-telephony/index.html',
  'pages/banking/index.html',
  'pages/ecommerce/index.html',
  'pages/education/index.html',
  'pages/health/index.html',
  'pages/logistic/index.html',
  'pages/retail/index.html',
  'pages/travelling/index.html',
  'pages/growtele-io/index.html',
];

function removeOldFooterCard(html) {
  let updated = html;
  updated = updated.replace(/\s*<!--[^>]*TRUST[^>]*-->\s*/gi, '\n');
  updated = updated.replace(/\s*<section class="stats">[\s\S]*?<\/section>\s*/g, '\n');
  updated = updated.replace(/\s*<section class="trust">[\s\S]*?<\/section>\s*/g, '\n');
  updated = updated.replace(/\s*<!-- SECTION 13: FOOTER -->\s*/g, '\n');
  return updated;
}

for (const page of pages) {
  const file = path.join(root, page);
  const html = fs.readFileSync(file, 'utf8');
  const updated = removeOldFooterCard(html);
  if (html === updated) {
    console.log('NO CHANGE:', page);
  } else {
    fs.writeFileSync(file, updated);
    console.log('UPDATED:', page);
  }
}
