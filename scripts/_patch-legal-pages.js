'use strict';

const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '..');
const maps = [
	['privacy-policy', 'privacy-policy-body.html'],
	['terms-and-condition', 'terms-and-condition-body.html'],
	['security', 'security-body.html'],
	['partners-term-of-use', 'partners-term-of-use-body.html'],
];

const oldBlock =
	'      <section class="coming-soon">\n' +
	'        <video class="coming-soon__video" src="https://listings.selectvia.com/wp-content/uploads/2026/09/Construction_vehicle_placing_sign_20260919121848.mp4" autoplay muted playsinline aria-label="Page under construction"></video>\n' +
	"        <p class=\"coming-soon__text\">We're currently working on this page. Please check back soon for updates.</p>\n" +
	'      </section>';

for (const [slug, file] of maps) {
	const idx = path.join(root, 'pages', slug, 'index.html');
	let html = fs.readFileSync(idx, 'utf8');
	const body = fs.readFileSync(path.join(root, 'pages/shared/legal', file), 'utf8').trimEnd();

	if (!html.includes(oldBlock)) {
		throw new Error('missing coming-soon block: ' + slug);
	}

	html = html.replace(oldBlock, body);
	html = html.replace('  <link rel="stylesheet" href="../shared/css/coming-soon.css?v=18">\n', '');
	html = html.replace(
		'  <link href="https://fonts.cdnfonts.com/css/tomato-grotesk" rel="stylesheet">',
		'  <link href="https://fonts.cdnfonts.com/css/tomato-grotesk" rel="stylesheet">\n' +
			'  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">'
	);
	html = html.replace('body class="coming-soon-page gt-smooth-scroll"', 'body class="gt-smooth-scroll"');
	html = html.replace(/\n\s*<li><a href="\.\.\/pricing\/">Pricing<\/a><\/li>\n/g, '\n');

	fs.writeFileSync(idx, html);
}

function walk(dir) {
	for (const ent of fs.readdirSync(dir, { withFileTypes: true })) {
		const p = path.join(dir, ent.name);
		if (ent.isDirectory()) {
			walk(p);
		} else if (ent.name === 'index.html') {
			let h = fs.readFileSync(p, 'utf8');
			const n = h.replace(/\n\s*<li><a href="(\.\.\/)*pricing\/">Pricing<\/a><\/li>\n/g, '\n');
			if (n !== h) {
				fs.writeFileSync(p, n);
			}
		}
	}
}

walk(path.join(root, 'pages'));
