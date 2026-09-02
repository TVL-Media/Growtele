/**
 * Page UI scale helper —
 * Keeps ScrollTrigger/Lenis in sync when the desktop canvas is zoomed,
 * and sets --gt-page-height for the transform-scale fallback.
 */
(function () {
	'use strict';

	var DESIGN_WIDTH = 1280;
	var mq = window.matchMedia('(max-width: 1024px)');

	function pageEl() {
		return document.getElementById('page');
	}

	function applyScaleMeta() {
		var page = pageEl();
		if (!page) return;

		var scale = mq.matches ? Math.min(1, window.innerWidth / DESIGN_WIDTH) : 1;
		document.documentElement.style.setProperty('--gt-ui-scale', String(scale));

		/* Unscaled layout height for transform fallback margin compensation */
		var height = page.scrollHeight || page.offsetHeight || window.innerHeight;
		document.documentElement.style.setProperty('--gt-page-height', height + 'px');
	}

	function refreshScrollSystems() {
		applyScaleMeta();

		var lenis = window.growteleLenis;
		if (lenis && typeof lenis.resize === 'function') {
			lenis.resize();
		}

		if (typeof ScrollTrigger !== 'undefined') {
			ScrollTrigger.refresh();
		}
	}

	function boot() {
		applyScaleMeta();

		window.addEventListener(
			'resize',
			function () {
				refreshScrollSystems();
			},
			{ passive: true }
		);

		window.addEventListener('load', function () {
			refreshScrollSystems();
		});

		window.addEventListener('growtele:industries-scroll-ready', function () {
			setTimeout(refreshScrollSystems, 100);
		});

		window.addEventListener('growtele:smooth-scroll-ready', function () {
			setTimeout(refreshScrollSystems, 100);
		});

		/* Fonts / late images can change height */
		setTimeout(refreshScrollSystems, 800);
		setTimeout(refreshScrollSystems, 2000);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
