/**
 * Lenis smooth scroll + GSAP ScrollTrigger integration
 * Preserves exact scroll position across refresh.
 *
 * @package Growtele
 */
(function () {
	'use strict';

	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	const MOBILE_MQ = window.matchMedia('(max-width: 1024px)');
	const SCROLL_KEY = 'growtele:scroll-y:' + window.location.pathname + window.location.search;

	if ('scrollRestoration' in history) {
		history.scrollRestoration = 'manual';
	}

	function readSavedScroll() {
		try {
			var raw = sessionStorage.getItem(SCROLL_KEY);
			if (raw == null || raw === '') return null;
			var y = parseFloat(raw);
			return isFinite(y) && y >= 0 ? y : null;
		} catch (err) {
			return null;
		}
	}

	function saveScroll(y) {
		try {
			sessionStorage.setItem(SCROLL_KEY, String(Math.max(0, Number(y) || 0)));
		} catch (err) {
			/* ignore quota / private mode */
		}
	}

	function dispatchScroll(scroll) {
		window.dispatchEvent(new CustomEvent('growtele:scroll', {
			detail: { scroll: scroll },
		}));
	}

	function applyScroll(lenis, y) {
		if (y == null || !isFinite(y) || y < 0) return;
		if (lenis && typeof lenis.scrollTo === 'function') {
			lenis.scrollTo(y, { immediate: true });
		} else {
			window.scrollTo(0, y);
		}
	}

	function initLenis() {
		var savedScroll = readSavedScroll();
		var browserScroll = window.scrollY || window.pageYOffset || 0;
		var forceHeroTop = window.location.hash === '#hero';
		var restoreY = 0;

		if (forceHeroTop) {
			saveScroll(0);
		} else if (savedScroll != null && savedScroll > 20) {
			restoreY = savedScroll;
		} else if (browserScroll > 20) {
			restoreY = browserScroll;
		}

		var userHasScrolled = false;

		function stopRestore() {
			userHasScrolled = true;
		}

		function reapplyRestore(lenis) {
			if (userHasScrolled || restoreY < 1) {
				return;
			}
			applyScroll(lenis || null, restoreY);
			dispatchScroll(restoreY);
		}

		function scheduleScrollTriggerRefresh() {
			if (typeof ScrollTrigger === 'undefined') {
				return;
			}
			requestAnimationFrame(function () {
				ScrollTrigger.refresh();
			});
		}

		if (prefersReducedMotion || typeof Lenis === 'undefined' || MOBILE_MQ.matches) {
			if (forceHeroTop) {
				window.scrollTo(0, 0);
				dispatchScroll(0);
			} else {
				reapplyRestore(null);
				dispatchScroll(window.scrollY || 0);
			}
			window.addEventListener('scroll', function () {
				var y = window.scrollY || 0;
				saveScroll(y);
				dispatchScroll(y);
			}, { passive: true });
			window.addEventListener('pagehide', function () {
				saveScroll(window.scrollY || 0);
			});
			return null;
		}

		const isMobile = MOBILE_MQ.matches;

		const lenis = new Lenis({
			autoRaf: false,
			duration: isMobile ? 0.85 : 0.92,
			easing: function (t) {
				return Math.min(1, 1.001 - Math.pow(2, -10 * t));
			},
			orientation: 'vertical',
			gestureOrientation: 'vertical',
			smoothWheel: true,
			wheelMultiplier: isMobile ? 1.05 : 1.12,
			touchMultiplier: isMobile ? 1.35 : 1.85,
			infinite: false,
		});

		window.growteleLenis = lenis;

		window.addEventListener('wheel', stopRestore, { passive: true, capture: true });
		window.addEventListener('touchmove', stopRestore, { passive: true, capture: true });
		window.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowDown' || event.key === 'ArrowUp' || event.key === 'PageDown' || event.key === 'PageUp' || event.key === ' ' || event.key === 'Home' || event.key === 'End') {
				stopRestore();
			}
		});

		reapplyRestore(lenis);

		if (forceHeroTop) {
			stopRestore();
			applyScroll(lenis, 0);
			dispatchScroll(0);
		}

		lenis.on('scroll', function (e) {
			if (!userHasScrolled && restoreY > 0 && Math.abs(e.scroll - restoreY) > 2) {
				stopRestore();
			}
			saveScroll(e.scroll);
			dispatchScroll(e.scroll);
		});

		window.addEventListener('pagehide', function () {
			saveScroll(typeof lenis.scroll === 'number' ? lenis.scroll : (window.scrollY || 0));
		});

		if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
			gsap.registerPlugin(ScrollTrigger);

			lenis.on('scroll', ScrollTrigger.update);

			ScrollTrigger.scrollerProxy(document.documentElement, {
				scrollTop: function (value) {
					if (arguments.length) {
						lenis.scrollTo(value, { immediate: true });
					}
					return lenis.scroll;
				},
				getBoundingClientRect: function () {
					return {
						top: 0,
						left: 0,
						width: window.innerWidth,
						height: window.innerHeight,
					};
				},
				pinType: document.documentElement.style.transform ? 'transform' : 'fixed',
			});

			ScrollTrigger.addEventListener('refresh', function () {
				lenis.resize();
			});

			gsap.ticker.add(function (time) {
				lenis.raf(time * 1000);
			});
		} else {
			function raf(time) {
				lenis.raf(time);
				requestAnimationFrame(raf);
			}

			requestAnimationFrame(raf);
		}

		window.addEventListener('load', function () {
			lenis.resize();
			scheduleScrollTriggerRefresh();
		});

		window.addEventListener('resize', function () {
			lenis.resize();
			scheduleScrollTriggerRefresh();
		}, { passive: true });

		document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
			anchor.addEventListener('click', function (event) {
				const id = anchor.getAttribute('href');

				if (!id || id === '#') {
					return;
				}

				const target = document.querySelector(id);

				if (!target) {
					return;
				}

				event.preventDefault();
				stopRestore();
				lenis.scrollTo(target, {
					offset: -80,
					duration: 1.1,
				});
			});
		});

		dispatchScroll(lenis.scroll);
		window.dispatchEvent(new CustomEvent('growtele:smooth-scroll-ready', { detail: { lenis: lenis } }));

		return lenis;
	}

	function boot() {
		initLenis();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
