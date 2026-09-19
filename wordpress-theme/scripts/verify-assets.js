#!/usr/bin/env node
'use strict';

const fs = require('fs');
const path = require('path');

const ROOT = path.resolve(__dirname, '..');
const EXT_PATTERN = /\.(png|jpe?g|gif|svg|webp|mp4|mov)(\?|$)/i;
const REF_PATTERN = /(?:src|href|poster)\s*=\s*["']([^"']+)["']|url\(\s*["']?([^"')]+)["']?\s*\)/gi;

const skipHosts = /^https?:\/\//i;

function walkFiles(dir, matcher, results = []) {
  if (!fs.existsSync(dir)) {
    return results;
  }

  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const fullPath = path.join(dir, entry.name);

    if (entry.isDirectory()) {
      if (entry.name === 'node_modules' || entry.name === '.git') {
        continue;
      }
      walkFiles(fullPath, matcher, results);
      continue;
    }

    if (matcher(fullPath)) {
      results.push(fullPath);
    }
  }

  return results;
}

function collectReferences(filePath, content) {
  const refs = [];
  let match;

  while ((match = REF_PATTERN.exec(content)) !== null) {
    const value = match[1] || match[2];

    if (!value || skipHosts.test(value) || value.startsWith('data:') || value.startsWith('#')) {
      continue;
    }

    if (!EXT_PATTERN.test(value)) {
      continue;
    }

    refs.push({
      value,
      line: content.slice(0, match.index).split('\n').length,
    });
  }

  return refs;
}

function resolveReference(fromFile, ref) {
  const cleanRef = ref.split('?')[0];
  const absolute = path.normalize(path.resolve(path.dirname(fromFile), cleanRef));
  const relative = path.relative(ROOT, absolute).split(path.sep).join('/');

  return {
    absolute,
    relative,
    exists: fs.existsSync(absolute),
  };
}

function main() {
  const sourceFiles = walkFiles(ROOT, (filePath) => /\.(html|css|js)$/i.test(filePath));
  const missing = [];
  const spaceRefs = [];

  sourceFiles.forEach((filePath) => {
    const content = fs.readFileSync(filePath, 'utf8');
    const refs = collectReferences(filePath, content);

    refs.forEach(({ value, line }) => {
      if (/\s/.test(value) && !/%20/i.test(value)) {
        spaceRefs.push({
          file: path.relative(ROOT, filePath).split(path.sep).join('/'),
          line,
          value,
        });
      }

      const resolved = resolveReference(filePath, value);

      if (!resolved.exists) {
        missing.push({
          file: path.relative(ROOT, filePath).split(path.sep).join('/'),
          line,
          value,
          expected: resolved.relative,
        });
      }
    });
  });

  console.log('Growtele asset verification');
  console.log('Root:', ROOT);
  console.log('');

  if (missing.length) {
    console.log(`Missing local asset references (${missing.length}):`);
    missing.slice(0, 100).forEach((item) => {
      console.log(`- ${item.file}:${item.line}`);
      console.log(`  ref: ${item.value}`);
      console.log(`  expected: ${item.expected}`);
    });

    if (missing.length > 100) {
      console.log(`... and ${missing.length - 100} more`);
    }
    console.log('');
  } else {
    console.log('No missing local asset references found.');
    console.log('');
  }

  if (spaceRefs.length) {
    console.log(`Unencoded spaces in local asset URLs (${spaceRefs.length}):`);
    spaceRefs.slice(0, 50).forEach((item) => {
      console.log(`- ${item.file}:${item.line} -> ${item.value}`);
    });

    if (spaceRefs.length > 50) {
      console.log(`... and ${spaceRefs.length - 50} more`);
    }
    console.log('');
  } else {
    console.log('No unencoded spaces in local asset URLs found.');
    console.log('');
  }

  process.exit(missing.length ? 1 : 0);
}

main();
