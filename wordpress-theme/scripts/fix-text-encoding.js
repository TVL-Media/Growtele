#!/usr/bin/env node
'use strict';

const fs = require('fs');
const path = require('path');

const ROOT = path.resolve(__dirname, '..');
const EXT = /\.(html|php|js|css)$/i;

const REPLACEMENTS = [
  [/CPaaS \? empowering/g, 'CPaaS — empowering'],
  [/CPaaS — empowering/g, 'CPaaS — empowering'],
  [/Growinfinity\.io�from/g, 'Growinfinity.io — from'],
  [/Growinfinity\.io � from/g, 'Growinfinity.io — from'],
  [/Growinfinity\.io � One/g, 'Growinfinity.io — One'],
  [/APIs — all/g, 'APIs — all'],
  [/APIs — all/g, 'APIs — all'],
  [/APIs \? all/g, 'APIs — all'],
  [/matters most—building/g, 'matters most—building'],
  [/matters most\?building/g, 'matters most—building'],
];

const TITLE_BY_PAGE = {
  'pages/retail/index.html': 'Retail | Growtele',
  'pages/banking/index.html': 'Banking | Growtele',
  'pages/health/index.html': 'Health | Growtele',
  'pages/travelling/index.html': 'Travelling | Growtele',
  'pages/education/index.html': 'Education | Growtele',
  'pages/ecommerce/index.html': 'Ecommerce | Growtele',
  'pages/logistic/index.html': 'Logistic | Growtele',
  'pages/growtele-io/index.html': 'Growinfinity.io — One Intelligent Platform. Unlimited Possibilities.',
};

function walk(dir, files = []) {
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    if (entry.name === 'node_modules' || entry.name === '.git') continue;
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) walk(full, files);
    else if (EXT.test(entry.name)) files.push(full);
  }
  return files;
}

let changed = 0;

walk(ROOT).forEach((file) => {
  let content = fs.readFileSync(file, 'utf8');
  const original = content;

  REPLACEMENTS.forEach(([pattern, value]) => {
    content = content.replace(pattern, value);
  });

  const rel = path.relative(ROOT, file).split(path.sep).join('/');
  if (TITLE_BY_PAGE[rel]) {
    content = content.replace(/<title>[^<]*<\/title>/, '<title>' + TITLE_BY_PAGE[rel] + '</title>');
  }

  if (content !== original) {
    fs.writeFileSync(file, content, 'utf8');
    changed += 1;
    console.log('fixed:', rel);
  }
});

console.log('Done. Files updated:', changed);
