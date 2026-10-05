(function () {
	'use strict';

	var PRODUCT_SLUGS = ['sms', 'whatsapp', 'email', 'rcs', 'cloud-telephony'];
	var INDUSTRY_SLUGS = ['retail', 'health', 'healthcare', 'banking', 'travelling', 'ecommerce', 'education', 'logistic'];
	var COMPANY_SLUGS = ['about-us', 'career', 'careers', 'contact', 'blogs', 'growinfinity-io', 'growtele-io', 'growinfinity'];

	function normalizePath(path) {
		var normalized = (path || '/').replace(/\\/g, '/').toLowerCase();
		normalized = normalized.replace(/\/index\.html$/i, '/');
		if (normalized.length > 1 && normalized.slice(-1) !== '/') {
			normalized += '/';
		}
		return normalized;
	}

	function getPageSlug() {
		var parts = normalizePath(window.location.pathname).split('/').filter(Boolean);
		if (!parts.length) {
			return 'home';
		}

		var last = parts[parts.length - 1];
		if (last === 'growtele' || last === 'pages') {
			return 'home';
		}

		return last.replace(/\.html$/i, '');
	}

	function getNavSection(slug) {
		if (slug === 'home') {
			return 'home';
		}
		if (PRODUCT_SLUGS.indexOf(slug) !== -1) {
			return 'products';
		}
		if (INDUSTRY_SLUGS.indexOf(slug) !== -1) {
			return 'industry';
		}
		if (COMPANY_SLUGS.indexOf(slug) !== -1) {
			return 'company';
		}
		return '';
	}

	function extractNavLabel(link) {
		var label = '';
		link.childNodes.forEach(function (node) {
			if (node.nodeType === 3) {
				label += node.textContent;
			}
		});
		return label.replace(/\s+/g, ' ').trim();
	}

	function applyNavLabels(menu) {
		menu.querySelectorAll(':scope > .menu-item > a').forEach(function (link) {
			var label = extractNavLabel(link);
			if (label) {
				link.setAttribute('data-nav-label', label);
			}
		});
	}

	function reserveNavLinkWidths(menu) {
		menu.querySelectorAll(':scope > .menu-item > a').forEach(function (link) {
			link.style.fontWeight = '700';
			link.style.minWidth = link.offsetWidth + 'px';
			link.style.fontWeight = '';
		});
	}

	function applyNavCurrent(menu) {
		var section = getNavSection(getPageSlug());
		var items = menu.querySelectorAll(':scope > .menu-item[data-nav-item]');
		var target = null;

		items.forEach(function (item) {
			item.classList.remove('is-nav-current', 'current-menu-item');
		});

		if (section === 'home') {
			items.forEach(function (item) {
				if (
					item.hasAttribute('data-mega-parent') ||
					item.hasAttribute('data-industry-solutions-parent') ||
					item.hasAttribute('data-company-parent')
				) {
					return;
				}
				if (!target) {
					target = item;
				}
			});
		} else if (section === 'products') {
			target = menu.querySelector('[data-mega-parent]');
		} else if (section === 'industry') {
			target = menu.querySelector('[data-industry-solutions-parent]');
		} else if (section === 'company') {
			target = menu.querySelector('[data-company-parent]');
		}

		if (target) {
			target.classList.add('is-nav-current', 'current-menu-item');
		}
	}

	function initNavCurrent() {
		document.querySelectorAll('[data-nav-menu]').forEach(function (menu) {
			applyNavLabels(menu);
			reserveNavLinkWidths(menu);
			applyNavCurrent(menu);
		});
	}

	window.growteleInitNavCurrent = initNavCurrent;

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initNavCurrent);
	} else {
		initNavCurrent();
	}
})();
