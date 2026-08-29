/**
 * Growtele Animations — Intersection Observer, Counters, Scroll Reveal
 */
(function () {
	'use strict';

	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* Scroll Reveal via Intersection Observer */
	function initScrollReveal() {
		if (prefersReducedMotion) {
			document.querySelectorAll('[data-animate]').forEach(function (el) {
				el.classList.add('is-visible');
			});
			return;
		}

		const observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					const delay = parseInt(entry.target.dataset.animateDelay || '0', 10);
					if (delay > 0) {
						setTimeout(function () {
							entry.target.classList.add('is-visible');
						}, delay);
					} else {
						entry.target.classList.add('is-visible');
					}
					observer.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.08,
			rootMargin: '0px 0px -4% 0px'
		});

		document.querySelectorAll('[data-animate]').forEach(function (el) {
			observer.observe(el);
		});
	}

	/* Counter Animation */
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

		const target = parseFloat(el.dataset.counter);
		const suffix = el.dataset.counterSuffix || '';
		const decimals = parseInt(el.dataset.counterDecimals || '0', 10);
		const state = { value: 0 };

		if (typeof gsap !== 'undefined') {
			gsap.to(state, {
				value: target,
				duration: 2.2,
				ease: 'power1.out',
				overwrite: true,
				onUpdate: function () {
					el.textContent = formatCounterValue(state.value, decimals, suffix);
				},
				onComplete: function () {
					el.textContent = formatCounterValue(target, decimals, suffix);
				},
			});
			return;
		}

		const duration = 2200;
		const startTime = performance.now();

		function easeOutCubic(t) {
			return 1 - Math.pow(1 - t, 3);
		}

		function update(currentTime) {
			const progress = Math.min((currentTime - startTime) / duration, 1);
			const current = target * easeOutCubic(progress);
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
		const counters = document.querySelectorAll('[data-counter]');

		if (!counters.length) {
			return;
		}

		if (prefersReducedMotion) {
			counters.forEach(function (el) {
				const target = parseFloat(el.dataset.counter);
				const suffix = el.dataset.counterSuffix || '';
				const decimals = parseInt(el.dataset.counterDecimals || '0', 10);
				el.textContent = formatCounterValue(target, decimals, suffix);
			});
			return;
		}

		const groups = new Map();

		counters.forEach(function (el) {
			const root = el.closest('.gt-enterprise, .gt-outcomes') || el;
			if (!groups.has(root)) {
				groups.set(root, []);
			}
			groups.get(root).push(el);
		});

		const counterObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) {
					return;
				}

				const list = groups.get(entry.target) || [];
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

	/* Word-by-word scroll reveal (OneXtel-style) */
	function splitWordsInElement(el) {
		if (el.dataset.wordsReady === 'true') {
			return;
		}

		el.dataset.wordsReady = 'true';
		el.classList.add('gt-words');
		el.classList.remove('is-visible');

		function processNode(node) {
			if (node.nodeType === Node.TEXT_NODE) {
				const text = node.textContent;

				if (!text.trim()) {
					return;
				}

				const parts = text.split(/(\s+)/);
				const frag = document.createDocumentFragment();

				parts.forEach(function (part) {
					if (!part) {
						return;
					}

					if (/^\s+$/.test(part)) {
						frag.appendChild(document.createTextNode(part));
						return;
					}

					const span = document.createElement('span');
					span.className = 'gt-word';
					span.textContent = part;
					frag.appendChild(span);
				});

				node.parentNode.replaceChild(frag, node);
				return;
			}

			if (node.nodeType === Node.ELEMENT_NODE && node.tagName !== 'BR') {
				Array.from(node.childNodes).forEach(processNode);
			}
		}

		Array.from(el.childNodes).forEach(processNode);

		el.querySelectorAll('.gt-word').forEach(function (word, index) {
			word.style.transitionDelay = (index * 70) + 'ms';
		});
	}

	function initWordReveal() {
		const selectors = [
			'.gt-hero__title-line',
			'.gt-hero__subtitle',
			'.gt-section-heading__title',
			'.gt-section-heading__desc',
			'.gt-integrations__title',
			'.gt-integrations__desc',
			'.gt-cta__content h2',
			'.gt-cta__content > p',
			/* Product pages */
			'.hero__title',
			'.hero__sub',
			'.hero__desc',
			'.journey__title',
			'.journey__lead',
			'.scale__title',
			'.scale__lead',
			'.benefits__title',
			'.benefits__lead',
			'.why__title',
			'.why__lead',
			'.funnel__title',
			'.funnel__lead',
			'.faq__title',
			'.faq__lead',
			'.faq__intro',
			/* Industry pages */
			'.section-title',
			'.channels__subtitle',
			'.growth__subtitle',
			'.growth-card__title',
			'.growth-card__desc',
			'.touchpoint__title',
			'.touchpoint__intro',
			'.usecases__subtitle',
			'.usecase-card__title',
			'.usecase-card__desc',
			'.testimonial__heading',
			'.testimonial__subheading',
			'.trust__title',
			'.trust__desc',
			'[data-animate-words]'
		];

		const targets = [];

		selectors.forEach(function (selector) {
			document.querySelectorAll(selector).forEach(function (el) {
				if (el.closest('[data-skip-word-reveal]')) {
					return;
				}
				if (targets.indexOf(el) === -1) {
					targets.push(el);
				}
			});
		});

		if (!targets.length) {
			return;
		}

		if (prefersReducedMotion) {
			targets.forEach(function (el) {
				el.classList.add('is-visible');
			});
			return;
		}

		targets.forEach(splitWordsInElement);

		const wordObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					wordObserver.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.2,
			rootMargin: '0px 0px -10% 0px'
		});

		targets.forEach(function (el) {
			const hero = el.closest('.gt-hero, .hero, .hero__content');

			if (hero) {
				requestAnimationFrame(function () {
					el.classList.add('is-visible');
				});
				return;
			}

			wordObserver.observe(el);
		});
	}

	/* Parallax on Hero Background — works with Lenis smooth scroll */
	function initParallax() {
		if (prefersReducedMotion) return;

		const heroBg = document.querySelector('.gt-hero__bg-video') || document.querySelector('.gt-hero__bg-image');
		const heroSection = document.querySelector('.gt-hero');
		if (!heroBg || !heroSection) return;

		let ticking = false;

		function updateParallax(scrollY) {
			if (scrollY < heroSection.offsetHeight && heroBg.classList.contains('is-loaded')) {
				heroBg.style.transform = 'translate3d(0, ' + (scrollY * 0.3) + 'px, 0)';
			}
		}

		function onScroll(scrollY) {
			if (!ticking) {
				requestAnimationFrame(function () {
					updateParallax(scrollY);
					ticking = false;
				});
				ticking = true;
			}
		}

		window.addEventListener('growtele:scroll', function (event) {
			onScroll(event.detail.scroll || 0);
		}, { passive: true });

		window.addEventListener('scroll', function () {
			onScroll(window.scrollY || 0);
		}, { passive: true });

		updateParallax(window.scrollY || 0);
	}

	/* Floating Integration Orbits */
	function initFloatingElements() {
		if (prefersReducedMotion) return;

		document.querySelectorAll('[data-float]').forEach(function (el) {
			el.style.willChange = 'transform';
		});
	}

	/* Channels fan → straight-line open on scroll — replaced by GSAP in channels-cards.js */

	/* Enterprise cards keep HTML stagger delays — no override */

	/* Section Entrance — add visible class to sections */
	function initSectionEntrance() {
		if (prefersReducedMotion) return;

		const sections = document.querySelectorAll('.gt-section');
		const sectionObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in-view');
				}
			});
		}, { threshold: 0.05 });

		sections.forEach(function (section) {
			sectionObserver.observe(section);
		});
	}

	/* Initialize all animations */
	function init() {
		initWordReveal();
		initScrollReveal();
		initCounters();
		initParallax();
		initFloatingElements();
		initSectionEntrance();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
