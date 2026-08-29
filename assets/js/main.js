/**
 * Growtele Main JavaScript
 */
(function () {
	'use strict';

	const header = document.querySelector('[data-header]');
	const navToggle = document.querySelector('[data-nav-toggle]');
	const nav = document.querySelector('.gt-header__nav');

	function getScrollStorageKey() {
		return 'growtele:scroll-y:' + window.location.pathname + window.location.search;
	}

	function clearSavedScroll() {
		try {
			sessionStorage.setItem(getScrollStorageKey(), '0');
		} catch (err) {
			/* ignore */
		}
	}

	function scrollToTop() {
		const hero = document.getElementById('hero');
		const masthead = document.getElementById('masthead');
		const target = hero || masthead || document.documentElement;
		const lenis = window.growteleLenis;

		clearSavedScroll();

		if (header) {
			header.classList.remove('is-hidden');
		}
		document.body.classList.remove('is-past-hero');

		if (lenis && typeof lenis.scrollTo === 'function') {
			lenis.scrollTo(target, {
				offset: 0,
				duration: 1.1,
				force: true,
				onComplete: function () {
					if (lenis.scroll > 2) {
						lenis.scrollTo(0, { immediate: true, force: true });
					}
					clearSavedScroll();
					if (typeof ScrollTrigger !== 'undefined') {
						ScrollTrigger.refresh();
					}
					window.dispatchEvent(new CustomEvent('growtele:scroll', { detail: { scroll: 0 } }));
				},
			});
			return;
		}

		if (hero) {
			hero.scrollIntoView({ behavior: 'smooth', block: 'start' });
		} else {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		}
	}

	function isLandingPage() {
		const path = window.location.pathname.replace(/\\/g, '/').toLowerCase();
		return path.endsWith('/') || path.endsWith('/index.html') || path.endsWith('/bomb') || path.endsWith('/bomb/index.html');
	}

	function isHomePage() {
		if (document.body.classList.contains('home') || document.body.classList.contains('front-page')) {
			return true;
		}
		return isLandingPage() || !!document.getElementById('hero');
	}

	const homeLogo = document.querySelector('[data-home-logo]') || document.querySelector('.gt-header__logo a[rel="home"]');
	if (homeLogo) {
		homeLogo.addEventListener('click', function (event) {
			if (!isHomePage()) return;
			event.preventDefault();
			event.stopPropagation();
			scrollToTop();
		}, true);
	}

	/* Auto-hide header — show on scroll up, hide on scroll down */
	let lastScrollY = window.scrollY || 0;
	const scrollThreshold = 80;
	const scrollDelta = 8;

	function isNavOpen() {
		return nav && nav.classList.contains('is-open');
	}

	function handleScroll(scrollY) {
		if (!header) return;

		const scrolled = scrollY > scrollThreshold;
		header.classList.toggle('is-scrolled', scrolled);
		header.classList.toggle('is-solid', scrolled);
		document.body.classList.toggle('is-past-hero', scrolled);

		if (isNavOpen() || scrollY <= scrollThreshold) {
			header.classList.remove('is-hidden');
			lastScrollY = scrollY;
			return;
		}

		if (scrollY - lastScrollY > scrollDelta) {
			header.classList.add('is-hidden');
		} else if (lastScrollY - scrollY > scrollDelta) {
			header.classList.remove('is-hidden');
		}

		lastScrollY = scrollY;
	}

	window.addEventListener('growtele:scroll', function (event) {
		handleScroll(event.detail.scroll || 0);
	}, { passive: true });

	window.addEventListener('scroll', function () {
		handleScroll(window.scrollY || 0);
	}, { passive: true });

	handleScroll(window.scrollY || 0);

	/* Background videos — chunked fetch into blob, play only when fully buffered (no decode blocks) */
	function showVideoFrame(video) {
		return new Promise(function (resolve) {
			if (typeof video.requestVideoFrameCallback === 'function') {
				video.requestVideoFrameCallback(function () {
					resolve();
				});
				return;
			}

			requestAnimationFrame(function () {
				requestAnimationFrame(resolve);
			});
		});
	}

	function waitForCanPlayThrough(video) {
		return new Promise(function (resolve, reject) {
			if (video.readyState >= 4) {
				resolve();
				return;
			}

			video.addEventListener('canplaythrough', resolve, { once: true });
			video.addEventListener('error', reject, { once: true });
		});
	}

	function revealVideo(video) {
		video.classList.add('is-loaded');
		video.dataset.videoReady = 'true';
	}

	function playVideoDirect(video, url) {
		const source = video.querySelector('source');

		if (source) {
			source.src = url;
		} else {
			video.src = url;
		}

		video.load();

		return waitForCanPlayThrough(video).then(function () {
			return video.play();
		}).then(function () {
			return showVideoFrame(video);
		}).then(function () {
			revealVideo(video);
		});
	}

	function fetchVideoInChunks(url) {
		return fetch(url, {
			mode: 'cors',
			credentials: 'omit',
			cache: 'force-cache',
		}).then(function (response) {
			if (!response.ok) {
				throw new Error('Video fetch failed');
			}

			if (!response.body || typeof response.body.getReader !== 'function') {
				return response.blob();
			}

			const reader = response.body.getReader();
			const chunks = [];

			function readNext() {
				return reader.read().then(function (result) {
					if (result.done) {
						return new Blob(chunks, { type: 'video/mp4' });
					}

					chunks.push(result.value);
					return readNext();
				});
			}

			return readNext();
		});
	}

	function initChunkedVideo(video) {
		if (video.dataset.chunkLoader === 'true') {
			return;
		}

		video.dataset.chunkLoader = 'true';

		const source = video.querySelector('source');
		const url = source ? (source.getAttribute('data-src') || source.getAttribute('src')) : video.getAttribute('data-src');

		if (!url) {
			return;
		}

		if (source) {
			source.removeAttribute('src');
		}

		video.removeAttribute('src');
		video.preload = 'none';

		fetchVideoInChunks(url).then(function (blob) {
			const blobUrl = URL.createObjectURL(blob);

			if (source) {
				source.src = blobUrl;
			} else {
				video.src = blobUrl;
			}

			video.load();

			return waitForCanPlayThrough(video);
		}).then(function () {
			return video.play();
		}).then(function () {
			return showVideoFrame(video);
		}).then(function () {
			revealVideo(video);
		}).catch(function () {
			return playVideoDirect(video, url);
		});
	}

	function initBackgroundVideo(video) {
		if (video.dataset.videoReady === 'true' || video.classList.contains('is-loaded')) {
			return;
		}

		if (video.classList.contains('gt-hero__bg-video') || video.classList.contains('gt-outcomes__reach-video')) {
			const source = video.querySelector('source');
			const url = source ? (source.getAttribute('src') || source.getAttribute('data-src')) : video.getAttribute('src');

			if (url) {
				return playVideoDirect(video, url);
			}
		}

		initChunkedVideo(video);
	}

	document.querySelectorAll('.gt-hero__bg-video, .gt-outcomes__reach-video').forEach(initBackgroundVideo);

	/* Mobile Navigation */
	if (navToggle && nav) {
		navToggle.addEventListener('click', function () {
			const isOpen = nav.classList.toggle('is-open');
			navToggle.classList.toggle('is-active', isOpen);
			navToggle.setAttribute('aria-expanded', isOpen);
			document.body.style.overflow = isOpen ? 'hidden' : '';
		});

		nav.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				if (
					link.hasAttribute('data-mega-trigger') ||
					link.hasAttribute('data-industry-solutions-trigger') ||
					link.hasAttribute('data-company-trigger')
				) {
					return;
				}
				nav.classList.remove('is-open');
				navToggle.classList.remove('is-active');
				navToggle.setAttribute('aria-expanded', 'false');
				document.body.style.overflow = '';
			});
		});
	}

	function canHoverNavDropdowns() {
		return window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	}

	function bindNavDropdownHover(parent, panel, openFn, closeFn) {
		let hideTimer = 0;

		function cancelHide() {
			window.clearTimeout(hideTimer);
			hideTimer = 0;
		}

		function show() {
			if (!canHoverNavDropdowns()) return;
			cancelHide();
			openFn();
		}

		function hide() {
			if (!canHoverNavDropdowns()) return;
			cancelHide();
			hideTimer = window.setTimeout(closeFn, 140);
		}

		if (parent) {
			parent.addEventListener('mouseenter', show);
			parent.addEventListener('mouseleave', hide);
		}
		if (panel) {
			panel.addEventListener('mouseenter', show);
			panel.addEventListener('mouseleave', hide);
		}
	}

	/* Products mega menu + bold active nav tab */
	(function initMegaMenu() {
		const menu = document.querySelector('[data-nav-menu]');
		const headerInner = document.querySelector('.gt-header__inner');
		if (!menu) return;

		const navItems = menu.querySelectorAll('[data-nav-item]');
		const megaParent = menu.querySelector('[data-mega-parent]');
		const megaTrigger = menu.querySelector('[data-mega-trigger]');
		const megaMenu = menu.querySelector('[data-mega-menu]');
		const megaLinks = menu.querySelectorAll('[data-mega-link]');

		if (megaMenu && megaMenu.parentElement !== document.body) {
			document.body.appendChild(megaMenu);
		}

		function setActiveNavItem(activeItem) {
			navItems.forEach(function (item) {
				const isActive = item === activeItem;
				item.classList.toggle('is-active', isActive);
				if (isActive) {
					item.classList.add('current-menu-item');
				} else {
					item.classList.remove('current-menu-item');
				}
			});
		}

		function positionMegaMenu() {
			if (!megaMenu || !headerInner) return;
			const rect = headerInner.getBoundingClientRect();
			megaMenu.style.top = Math.round(rect.bottom) + 'px';
		}

		function closeMegaMenu() {
			if (!megaParent || !megaTrigger || !megaMenu) return;
			megaParent.classList.remove('is-open');
			megaMenu.classList.remove('is-open');
			megaTrigger.setAttribute('aria-expanded', 'false');
			megaMenu.setAttribute('hidden', '');
		}

		function openMegaMenu() {
			if (!megaParent || !megaTrigger || !megaMenu) return;
			positionMegaMenu();
			megaParent.classList.add('is-open');
			megaMenu.classList.add('is-open');
			megaTrigger.setAttribute('aria-expanded', 'true');
			megaMenu.removeAttribute('hidden');
			setActiveNavItem(megaParent);
			document.dispatchEvent(new CustomEvent('growtele:nav-dropdown', { detail: 'products' }));
		}

		if (megaTrigger && megaParent && megaMenu) {
			megaTrigger.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				if (canHoverNavDropdowns()) {
					if (!megaParent.classList.contains('is-open')) {
						openMegaMenu();
					}
					return;
				}
				if (megaParent.classList.contains('is-open')) {
					closeMegaMenu();
					return;
				}
				openMegaMenu();
			});
			bindNavDropdownHover(megaParent, megaMenu, openMegaMenu, closeMegaMenu);
		}

		document.addEventListener('growtele:nav-dropdown', function (event) {
			if (event.detail !== 'products') {
				closeMegaMenu();
			}
		});

		navItems.forEach(function (item) {
			const link = item.querySelector(':scope > a');
			if (!link || link.hasAttribute('data-mega-trigger')) return;

			link.addEventListener('click', function () {
				closeMegaMenu();
				setActiveNavItem(item);
			});
		});

		megaLinks.forEach(function (link) {
			link.addEventListener('click', function (event) {
				const href = link.getAttribute('href');
				const hasDestination = href && href !== '#' && href.trim() !== '';
				if (!hasDestination) {
					event.preventDefault();
				}
				megaLinks.forEach(function (other) {
					other.classList.toggle('is-active', other === link);
				});
				setActiveNavItem(megaParent);
			});
		});

		document.addEventListener('click', function (event) {
			if (!megaParent || !megaParent.classList.contains('is-open')) return;
			if (megaParent.contains(event.target) || (megaMenu && megaMenu.contains(event.target))) return;
			closeMegaMenu();
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				closeMegaMenu();
			}
		});

		window.addEventListener('resize', function () {
			if (megaParent && megaParent.classList.contains('is-open')) {
				positionMegaMenu();
			}
		}, { passive: true });

		window.addEventListener('scroll', function () {
			if (megaParent && megaParent.classList.contains('is-open')) {
				positionMegaMenu();
			}
		}, { passive: true });

		window.addEventListener('growtele:scroll', function () {
			if (megaParent && megaParent.classList.contains('is-open')) {
				positionMegaMenu();
			}
		}, { passive: true });
	})();

	/* Industry Solutions + Company dropdowns (Products logic mirrored; Products IIFE untouched) */
	(function initIndustryCompanyDropdowns() {
		const menu = document.querySelector('[data-nav-menu]');
		const headerInner = document.querySelector('.gt-header__inner');
		if (!menu) return;

		const navItems = menu.querySelectorAll('[data-nav-item]');
		const productsParent = menu.querySelector('[data-mega-parent]');
		const productsTrigger = menu.querySelector('[data-mega-trigger]');
		const productsMenu = document.querySelector('[data-mega-menu]');

		const industryParent = menu.querySelector('[data-industry-solutions-parent]');
		const industryTrigger = menu.querySelector('[data-industry-solutions-trigger]');
		const industryMenu = menu.querySelector('[data-industry-solutions-dropdown]');
		const industryLinks = menu.querySelectorAll('[data-industry-solutions-link]');

		const companyParent = menu.querySelector('[data-company-parent]');
		const companyTrigger = menu.querySelector('[data-company-trigger]');
		const companyMenu = menu.querySelector('[data-company-dropdown]');
		const companyLinks = menu.querySelectorAll('[data-company-link]');

		if (industryMenu && industryMenu.parentElement !== document.body) {
			document.body.appendChild(industryMenu);
		}
		if (companyMenu && companyMenu.parentElement !== document.body) {
			document.body.appendChild(companyMenu);
		}

		function setActiveNavItem(activeItem) {
			navItems.forEach(function (item) {
				const isActive = item === activeItem;
				item.classList.toggle('is-active', isActive);
				if (isActive) {
					item.classList.add('current-menu-item');
				} else {
					item.classList.remove('current-menu-item');
				}
			});
		}

		function positionDropdown(dropdownEl) {
			if (!dropdownEl || !headerInner) return;
			const rect = headerInner.getBoundingClientRect();
			dropdownEl.style.top = Math.round(rect.bottom) + 'px';
		}

		function closeProductsDropdown() {
			if (!productsParent || !productsMenu) return;
			productsParent.classList.remove('is-open');
			productsMenu.classList.remove('is-open');
			if (productsTrigger) productsTrigger.setAttribute('aria-expanded', 'false');
			productsMenu.setAttribute('hidden', '');
		}

		function closeIndustryDropdown() {
			if (!industryParent || !industryTrigger || !industryMenu) return;
			industryParent.classList.remove('is-open');
			industryMenu.classList.remove('is-open');
			industryTrigger.setAttribute('aria-expanded', 'false');
			industryMenu.setAttribute('hidden', '');
		}

		function closeCompanyDropdown() {
			if (!companyParent || !companyTrigger || !companyMenu) return;
			companyParent.classList.remove('is-open');
			companyMenu.classList.remove('is-open');
			companyTrigger.setAttribute('aria-expanded', 'false');
			companyMenu.setAttribute('hidden', '');
		}

		function openIndustryDropdown() {
			if (!industryParent || !industryTrigger || !industryMenu) return;
			closeProductsDropdown();
			closeCompanyDropdown();
			positionDropdown(industryMenu);
			industryParent.classList.add('is-open');
			industryMenu.classList.add('is-open');
			industryTrigger.setAttribute('aria-expanded', 'true');
			industryMenu.removeAttribute('hidden');
			setActiveNavItem(industryParent);
			document.dispatchEvent(new CustomEvent('growtele:nav-dropdown', { detail: 'industry' }));
		}

		function openCompanyDropdown() {
			if (!companyParent || !companyTrigger || !companyMenu) return;
			closeProductsDropdown();
			closeIndustryDropdown();
			positionDropdown(companyMenu);
			companyParent.classList.add('is-open');
			companyMenu.classList.add('is-open');
			companyTrigger.setAttribute('aria-expanded', 'true');
			companyMenu.removeAttribute('hidden');
			setActiveNavItem(companyParent);
			document.dispatchEvent(new CustomEvent('growtele:nav-dropdown', { detail: 'company' }));
		}

		if (productsTrigger) {
			productsTrigger.addEventListener('click', function () {
				closeIndustryDropdown();
				closeCompanyDropdown();
			}, true);
		}

		if (industryTrigger && industryParent && industryMenu) {
			industryTrigger.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				if (canHoverNavDropdowns()) {
					if (!industryParent.classList.contains('is-open')) {
						openIndustryDropdown();
					}
					return;
				}
				if (industryParent.classList.contains('is-open')) {
					closeIndustryDropdown();
					return;
				}
				openIndustryDropdown();
			});
			bindNavDropdownHover(industryParent, industryMenu, openIndustryDropdown, closeIndustryDropdown);
		}

		if (companyTrigger && companyParent && companyMenu) {
			companyTrigger.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				if (canHoverNavDropdowns()) {
					if (!companyParent.classList.contains('is-open')) {
						openCompanyDropdown();
					}
					return;
				}
				if (companyParent.classList.contains('is-open')) {
					closeCompanyDropdown();
					return;
				}
				openCompanyDropdown();
			});
			bindNavDropdownHover(companyParent, companyMenu, openCompanyDropdown, closeCompanyDropdown);
		}

		document.addEventListener('growtele:nav-dropdown', function (event) {
			if (event.detail !== 'industry') {
				closeIndustryDropdown();
			}
			if (event.detail !== 'company') {
				closeCompanyDropdown();
			}
		});

		navItems.forEach(function (item) {
			const link = item.querySelector(':scope > a');
			if (!link) return;
			if (
				link.hasAttribute('data-mega-trigger') ||
				link.hasAttribute('data-industry-solutions-trigger') ||
				link.hasAttribute('data-company-trigger')
			) {
				return;
			}

			link.addEventListener('click', function () {
				closeIndustryDropdown();
				closeCompanyDropdown();
			});
		});

		industryLinks.forEach(function (link) {
			link.addEventListener('click', function (event) {
				const href = link.getAttribute('href');
				const hasDestination = href && href !== '#' && href.trim() !== '';
				if (!hasDestination) {
					event.preventDefault();
				}
				industryLinks.forEach(function (other) {
					other.classList.toggle('is-active', other === link);
				});
				setActiveNavItem(industryParent);
			});
		});

		companyLinks.forEach(function (link) {
			link.addEventListener('click', function (event) {
				event.preventDefault();
				companyLinks.forEach(function (other) {
					other.classList.toggle('is-active', other === link);
				});
				setActiveNavItem(companyParent);
			});
		});

		document.addEventListener('click', function (event) {
			if (industryParent && industryParent.classList.contains('is-open')) {
				if (
					!industryParent.contains(event.target) &&
					!(industryMenu && industryMenu.contains(event.target))
				) {
					closeIndustryDropdown();
				}
			}
			if (companyParent && companyParent.classList.contains('is-open')) {
				if (
					!companyParent.contains(event.target) &&
					!(companyMenu && companyMenu.contains(event.target))
				) {
					closeCompanyDropdown();
				}
			}
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				closeIndustryDropdown();
				closeCompanyDropdown();
			}
		});

		function repositionOpenDropdowns() {
			if (industryParent && industryParent.classList.contains('is-open')) {
				positionDropdown(industryMenu);
			}
			if (companyParent && companyParent.classList.contains('is-open')) {
				positionDropdown(companyMenu);
			}
		}

		window.addEventListener('resize', repositionOpenDropdowns, { passive: true });
		window.addEventListener('scroll', repositionOpenDropdowns, { passive: true });
		window.addEventListener('growtele:scroll', repositionOpenDropdowns, { passive: true });
	})();

	/* Industry tabs + scroll stack live in industries-scroll.js */

	/* Case Study Tabs — card stack */
	const caseContainer = document.querySelector('[data-case-tabs]');
	if (caseContainer) {
		const section = caseContainer.closest('.gt-case-studies');
		const caseTabs = caseContainer.querySelectorAll('[data-case-tab]');
		const casePanels = section.querySelectorAll('[data-case-panel]');
		const stackEl = section.querySelector('[data-case-stack]');
		const progressBar = document.querySelector('[data-case-progress]');
		const progressTrack = document.querySelector('.gt-case-studies__progress');
		const stackOrder = [];
		const maxVisible = 3;

		function updateCaseProgressPosition(activeTab) {
			if (!progressBar || !progressTrack || !activeTab) return;
			const trackRect = progressTrack.getBoundingClientRect();
			const tabRect = activeTab.getBoundingClientRect();
			progressBar.style.left = (tabRect.left - trackRect.left) + 'px';
			progressBar.style.width = tabRect.width + 'px';
		}

		function startCaseProgress(activeTab) {
			updateCaseProgressPosition(activeTab);
			if (!progressBar) return;
			progressBar.classList.remove('is-running');
			void progressBar.offsetWidth;
			progressBar.classList.add('is-running');
		}

		function syncStackHeight() {
			if (!stackEl) return;
			stackEl.style.minHeight = '470px';
			stackEl.style.height = '470px';
		}

		function renderStack(target, animate) {
			const existing = stackOrder.indexOf(target);
			if (existing !== -1) {
				stackOrder.splice(existing, 1);
			}
			stackOrder.push(target);

			const visible = stackOrder.slice(-maxVisible);

			casePanels.forEach(function (panel) {
				const key = panel.dataset.casePanel;
				const idx = visible.indexOf(key);
				const depthFromTop = idx === -1 ? -1 : visible.length - 1 - idx;

				panel.classList.remove('is-active', 'is-stacked', 'is-entering');
				panel.style.removeProperty('--stack-depth');

				if (depthFromTop === -1) {
					panel.setAttribute('aria-hidden', 'true');
					return;
				}

				panel.setAttribute('aria-hidden', depthFromTop === 0 ? 'false' : 'true');
				panel.style.setProperty('--stack-depth', String(depthFromTop));

				if (depthFromTop === 0) {
					panel.classList.add('is-active');
					if (animate) {
						void panel.offsetWidth;
						panel.classList.add('is-entering');
					}
				} else {
					panel.classList.add('is-stacked');
				}
			});

			requestAnimationFrame(syncStackHeight);
		}

		const initial = caseContainer.querySelector('.gt-case-studies__tab.is-active')?.dataset.caseTab
			|| caseTabs[0]?.dataset.caseTab;

		function activateCaseTab(target, animate, isManual) {
			const current = stackOrder[stackOrder.length - 1];
			if (target === current && animate && !isManual) {
				return;
			}

			if (isManual) {
				stackOrder.length = 0;
			}

			caseTabs.forEach(function (t) {
				t.classList.toggle('is-active', t.dataset.caseTab === target);
			});

			renderStack(target, animate && !isManual);

			const tab = caseContainer.querySelector('[data-case-tab="' + target + '"]');
			if (isManual && section.classList.contains('is-case-paused')) {
				updateCaseProgressPosition(tab);
				return;
			}

			startCaseProgress(tab);
		}

		const CASE_AUTO_MS = parseInt(section.getAttribute('data-case-cycle'), 10) || 5000;
		const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		let caseAutoTimer = null;

		function advanceCaseTab() {
			if (section.classList.contains('is-case-paused')) return;
			const current = stackOrder[stackOrder.length - 1] || '0';
			const nextIndex = (parseInt(current, 10) + 1) % caseTabs.length;
			activateCaseTab(String(nextIndex), true);
		}

		function pauseCaseCycle() {
			section.classList.add('is-case-paused');
			if (caseAutoTimer) {
				clearInterval(caseAutoTimer);
				caseAutoTimer = null;
			}
		}

		function resumeCaseCycle() {
			section.classList.remove('is-case-paused');
			const tab = caseContainer.querySelector('.gt-case-studies__tab.is-active');
			const activePanel = section.querySelector('.gt-case-studies__panel.is-active');
			if (activePanel) {
				activePanel.classList.remove('is-entering');
				void activePanel.offsetWidth;
				activePanel.classList.add('is-entering');
			}
			startCaseProgress(tab);
			if (prefersReducedMotion) {
				startCaseFallbackTimer();
			}
		}

		function startCaseFallbackTimer() {
			if (caseAutoTimer) clearInterval(caseAutoTimer);
			caseAutoTimer = setInterval(advanceCaseTab, CASE_AUTO_MS);
		}

		if (initial) {
			activateCaseTab(initial, true);
		}

		/* Advance when progress bar finishes — stays in sync, no interval drift */
		if (!prefersReducedMotion && progressBar) {
			progressBar.addEventListener('animationend', function (event) {
				if (event.animationName !== 'gt-case-progress-fill') return;
				if (event.target !== progressBar) return;
				advanceCaseTab();
			});
		} else {
			startCaseFallbackTimer();
		}

		let userStopped = false;

		caseTabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				const target = tab.dataset.caseTab;

				if (!userStopped) {
					userStopped = true;
					pauseCaseCycle();
					if (progressBar) {
						progressBar.classList.remove('is-running');
						progressBar.style.animationPlayState = 'paused';
					}
					activateCaseTab(target, true, true);
				} else {
					userStopped = false;
					if (progressBar) {
						progressBar.style.animationPlayState = '';
					}
					section.classList.remove('is-case-paused');
					activateCaseTab(target, true, true);
					if (prefersReducedMotion) {
						startCaseFallbackTimer();
					}
				}
			});
		});

		/* Only pause when the browser tab is hidden — not on hover */
		document.addEventListener('visibilitychange', function () {
			if (document.hidden) {
				pauseCaseCycle();
			} else if (section.classList.contains('is-case-paused')) {
				resumeCaseCycle();
			}
		});

		window.addEventListener('resize', function () {
			syncStackHeight();
			updateCaseProgressPosition(caseContainer.querySelector('.gt-case-studies__tab.is-active'));
		}, { passive: true });
		syncStackHeight();
	}

	/* Button Ripple Effect */
	document.querySelectorAll('.gt-btn').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			const rect = btn.getBoundingClientRect();
			const ripple = document.createElement('span');
			ripple.className = 'gt-btn__ripple';
			ripple.style.cssText = 'position:absolute;border-radius:50%;background:rgba(255,255,255,0.4);transform:scale(0);animation:gt-ripple 0.6s ease-out;pointer-events:none;';
			const size = Math.max(rect.width, rect.height);
			ripple.style.width = ripple.style.height = size + 'px';
			ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
			ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
			btn.style.position = 'relative';
			btn.style.overflow = 'hidden';
			btn.appendChild(ripple);
			setTimeout(function () { ripple.remove(); }, 600);
		});
	});

	/* Inject ripple keyframes */
	if (!document.getElementById('gt-ripple-style')) {
		const style = document.createElement('style');
		style.id = 'gt-ripple-style';
		style.textContent = '@keyframes gt-ripple{to{transform:scale(4);opacity:0}}';
		document.head.appendChild(style);
	}
})();
