/**
 * Growtele — stat counter animation for static channel pages (.stats section).
 */
(function () {
	'use strict';

	var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function formatCounterValue(value, decimals, suffix) {
		if (decimals > 0) {
			return value.toFixed(decimals) + suffix;
		}
		return Math.round(value) + suffix;
	}

	function animateCounter(el) {
		if (el.dataset.counterDone === 'true') {
			return;
		}

		el.dataset.counterDone = 'true';

		var target = parseFloat(el.dataset.counter);
		var suffix = el.dataset.counterSuffix || '';
		var decimals = parseInt(el.dataset.counterDecimals || '0', 10);
		var duration = 2200;
		var startTime = performance.now();

		function easeOutCubic(t) {
			return 1 - Math.pow(1 - t, 3);
		}

		function update(currentTime) {
			var progress = Math.min((currentTime - startTime) / duration, 1);
			var current = target * easeOutCubic(progress);
			el.textContent = formatCounterValue(current, decimals, suffix);

			if (progress < 1) {
				requestAnimationFrame(update);
			} else {
			 el.textContent = formatCounterValue(target, decimals, suffix);
			}
		}

		requestAnimationFrame(update);
	}

	function initCounters() {
		var counters = document.querySelectorAll('[data-counter]');
		if (!counters.length) {
			return;
		}

		if (prefersReducedMotion) {
			counters.forEach(function (el) {
				var target = parseFloat(el.dataset.counter);
				var suffix = el.dataset.counterSuffix || '';
				var decimals = parseInt(el.dataset.counterDecimals || '0', 10);
				el.textContent = formatCounterValue(target, decimals, suffix);
			});
			return;
		}

		var groups = new Map();

		counters.forEach(function (el) {
			var root = el.closest('.stats, .gt-enterprise, .gt-outcomes, .trust, .testimonial') || el;
			if (!groups.has(root)) {
				groups.set(root, []);
			}
			groups.get(root).push(el);
		});

		var counterObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) {
					return;
				}

				var list = groups.get(entry.target) || [];
				list.forEach(animateCounter);
				counterObserver.unobserve(entry.target);
			});
		}, {
			threshold: 0.2,
			rootMargin: '0px 0px -5% 0px',
		});

		groups.forEach(function (_list, root) {
			counterObserver.observe(root);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCounters);
	} else {
		initCounters();
	}
})();
