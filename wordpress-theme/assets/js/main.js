/**
 * Growtele Main JavaScript
 */
(function () {
	'use strict';

	const header = document.querySelector('[data-header]');
	const navToggle = document.querySelector('[data-nav-toggle]');
	const nav = document.querySelector('.gt-header__nav');

	function getScrollStorageKey() {
		var path = (window.location.pathname || '/').replace(/\\/g, '/');
		if (/\/index\.html$/i.test(path)) {
			path = path.replace(/\/index\.html$/i, '/');
		}
		if (path !== '/' && path.slice(-1) !== '/') {
			path += '/';
		}
		return 'growtele:scroll-y:' + path + (window.location.search || '');
	}

	function clearSavedScroll() {
		try {
			sessionStorage.setItem(getScrollStorageKey(), '0');
		} catch (err) {
			/* ignore */
		}
	}

	function closeMobileNavIfOpen() {
		if (!nav || !nav.classList.contains('is-open')) {
			return;
		}

		nav.classList.remove('is-open');

		if (navToggle) {
			navToggle.classList.remove('is-active');
			navToggle.setAttribute('aria-expanded', 'false');
		}

		document.body.classList.remove('gt-nav-open');
		document.body.style.overflow = '';

		const backdrop = document.querySelector('.gt-nav-backdrop');
		if (backdrop) {
			backdrop.classList.remove('is-visible');
		}

		const landingMenu = document.querySelector('[data-nav-menu]');
		if (landingMenu) {
			landingMenu.classList.remove('is-mobile-open');
		}

		if (window.growteleLenis && typeof window.growteleLenis.start === 'function') {
			window.growteleLenis.start();
		}
	}

	function finishScrollToTop() {
		const lenis = window.growteleLenis;

		window.__growteleGoHero = false;
		clearSavedScroll();

		if (lenis && typeof lenis.scrollTo === 'function' && lenis.scroll > 1) {
			lenis.scrollTo(0, { immediate: true, force: true });
		} else if ((window.scrollY || 0) > 1) {
			window.scrollTo(0, 0);
		}

		if (typeof ScrollTrigger !== 'undefined') {
			ScrollTrigger.refresh();
		}

		window.dispatchEvent(new CustomEvent('growtele:scroll', { detail: { scroll: 0 } }));
	}

	function scrollToHero() {
		const lenis = window.growteleLenis;

		window.__growteleGoHero = true;
		clearSavedScroll();
		closeMobileNavIfOpen();

		if (header) {
			header.classList.remove('is-hidden');
		}

		document.body.classList.remove('is-past-hero');
		window.dispatchEvent(new CustomEvent('growtele:go-hero'));

		if (lenis && typeof lenis.scrollTo === 'function') {
			lenis.scrollTo(0, { duration: 1.1, force: true, lock: true, onComplete: finishScrollToTop });
			return;
		}

		window.scrollTo({ top: 0, behavior: 'smooth' });
		window.setTimeout(finishScrollToTop, 450);
	}

	function isLandingPage() {
		if (document.body.classList.contains('home') || document.body.classList.contains('front-page')) {
			return true;
		}

		const path = window.location.pathname.replace(/\\/g, '/').toLowerCase();
		return path.endsWith('/') ||
			path.endsWith('/index.html') ||
			path.endsWith('/pages') ||
			path.endsWith('/pages/') ||
			path.endsWith('/bomb') ||
			path.endsWith('/bomb/index.html');
	}

	const homeLogo = document.querySelector('[data-home-logo]') || document.querySelector('.gt-header__logo a[rel="home"]');
	if (homeLogo) {
		homeLogo.addEventListener('click', function (event) {
			if (!isLandingPage()) {
				return;
			}
			event.preventDefault();
			event.stopImmediatePropagation();
			scrollToHero();
		}, true);
	}

	/* Auto-hide header — show on scroll up, hide on scroll down */
	let lastScrollY = window.scrollY || 0;
	const scrollThreshold = 80;
	const scrollDelta = 8;

	function getMobileHeroThreshold() {
		const hero = document.querySelector('.gt-hero');
		if (!hero) {
			return scrollThreshold;
		}
		return Math.max(0, hero.offsetTop + hero.offsetHeight - 72);
	}

	function isNavOpen() {
		return nav && nav.classList.contains('is-open');
	}

	function handleScroll(scrollY) {
		if (!header) return;

		const isMobileHeader = window.matchMedia('(max-width: 1024px)').matches;

		if (isMobileHeader) {
			const heroThreshold = getMobileHeroThreshold();
			header.classList.remove('is-hidden');
			header.classList.toggle('is-scrolled', scrollY >= heroThreshold);
			header.classList.toggle('is-solid', scrollY >= heroThreshold);
			document.body.classList.toggle('is-past-hero', scrollY >= heroThreshold);
			lastScrollY = scrollY;
			return;
		}

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

	/* Mobile navigation — landing page hamburger (gt-header__toggle) */
	if (navToggle && nav) {
		let landingBackdrop = null;
		let ignoreLandingOutsideClick = false;
		const landingMenu = nav.querySelector('.gt-header__menu');
		let landingMenuParent = null;
		let landingMenuNext = null;

		function isLandingMobileNav() {
			return window.matchMedia('(max-width: 1024px)').matches;
		}

		function mountLandingMenu() {
			if (!isLandingMobileNav() || !landingMenu) {
				return;
			}

			if (landingMenu.parentElement === document.body) {
				return;
			}

			landingMenuParent = landingMenu.parentElement;
			landingMenuNext = landingMenu.nextSibling;
			landingMenu.classList.add('gt-header__menu--portal');
			document.body.appendChild(landingMenu);
		}

		function restoreLandingMenu() {
			if (!landingMenu || !landingMenuParent) {
				return;
			}

			if (landingMenu.parentElement !== document.body) {
				return;
			}

			landingMenu.classList.remove('gt-header__menu--portal');

			if (landingMenuNext) {
				landingMenuParent.insertBefore(landingMenu, landingMenuNext);
			} else {
				landingMenuParent.appendChild(landingMenu);
			}
		}

		function getLandingBackdrop() {
			if (!landingBackdrop) {
				landingBackdrop = document.querySelector('.gt-nav-backdrop');
				if (!landingBackdrop) {
					landingBackdrop = document.createElement('div');
					landingBackdrop.className = 'gt-nav-backdrop';
					landingBackdrop.setAttribute('aria-hidden', 'true');
					document.body.appendChild(landingBackdrop);
				}
				landingBackdrop.addEventListener('click', closeLandingNav);
				landingBackdrop.addEventListener('touchstart', closeLandingNav, { passive: true });
			}
			return landingBackdrop;
		}

		function closeLandingNav() {
			nav.classList.remove('is-open');
			navToggle.classList.remove('is-active');
			navToggle.setAttribute('aria-expanded', 'false');
			if (landingMenu) {
				landingMenu.classList.remove('is-mobile-open');
				window.setTimeout(restoreLandingMenu, MOBILE_DROPDOWN_MS);
			} else {
				restoreLandingMenu();
			}
			document.body.classList.remove('gt-nav-open');
			document.body.style.overflow = '';
			getLandingBackdrop().classList.remove('is-visible');

			if (window.growteleLenis && typeof window.growteleLenis.start === 'function') {
				window.growteleLenis.start();
			}
		}

		function openLandingNav() {
			mountLandingMenu();
			nav.classList.add('is-open');
			navToggle.classList.add('is-active');
			navToggle.setAttribute('aria-expanded', 'true');
			if (landingMenu) {
				landingMenu.classList.remove('is-mobile-open');
				window.requestAnimationFrame(function () {
					window.requestAnimationFrame(function () {
						landingMenu.classList.add('is-mobile-open');
					});
				});
			}
			document.body.classList.add('gt-nav-open');
			document.body.style.overflow = 'hidden';
			getLandingBackdrop().classList.add('is-visible');

			if (window.growteleLenis && typeof window.growteleLenis.stop === 'function') {
				window.growteleLenis.stop();
			}
		}

		navToggle.addEventListener('click', function (event) {
			event.preventDefault();
			event.stopPropagation();
			ignoreLandingOutsideClick = true;
			window.setTimeout(function () {
				ignoreLandingOutsideClick = false;
			}, 0);

			if (nav.classList.contains('is-open')) {
				closeLandingNav();
				return;
			}

			openLandingNav();
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
				if (!window.matchMedia('(max-width: 1024px)').matches) {
					return;
				}
				closeLandingNav();
			});
		});

		document.addEventListener('click', function (event) {
			if (ignoreLandingOutsideClick) {
				return;
			}
			if (!nav.classList.contains('is-open')) {
				return;
			}
			if (navToggle.contains(event.target)) {
				return;
			}
			if (landingMenu && landingMenu.contains(event.target)) {
				return;
			}
			if (header && header.contains(event.target)) {
				return;
			}
			closeLandingNav();
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && nav.classList.contains('is-open')) {
				closeLandingNav();
			}
		});

		window.addEventListener('resize', function () {
			if (!isLandingMobileNav()) {
				if (nav.classList.contains('is-open')) {
					closeLandingNav();
				} else {
					restoreLandingMenu();
					if (landingMenu) {
						landingMenu.classList.remove('is-mobile-open');
					}
				}
			}
		});
	}

	function canHoverNavDropdowns() {
		return window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	}

	const mobileNavMq = window.matchMedia('(max-width: 1024px)');
	const MOBILE_DROPDOWN_MS = 400;
	let navDropdownHideTimer = 0;

	function cancelNavDropdownHide() {
		if (!navDropdownHideTimer) return;
		window.clearTimeout(navDropdownHideTimer);
		navDropdownHideTimer = 0;
	}

	function scheduleNavDropdownHide(closeFn) {
		cancelNavDropdownHide();
		navDropdownHideTimer = window.setTimeout(closeFn, 360);
	}

	function isMobileNavLayout() {
		return mobileNavMq.matches;
	}

	function prepareDesktopDropdownPanel(panel) {
		if (!panel || isMobileNavLayout()) return;
		panel.removeAttribute('hidden');
		panel.setAttribute('aria-hidden', 'true');
		panel.classList.remove('is-open');
	}

	function closeNavDropdownPanel(parent, panel, trigger) {
		if (!panel) return;
		if (parent) parent.classList.remove('is-open');
		panel.classList.remove('is-open');
		if (trigger) trigger.setAttribute('aria-expanded', 'false');
		panel.setAttribute('aria-hidden', 'true');
		if (isMobileNavLayout()) {
			return;
		}
	}

	function openNavDropdownPanel(parent, panel, trigger) {
		if (!panel || !parent) return;
		panel.removeAttribute('hidden');
		panel.setAttribute('aria-hidden', 'false');
		if (parent.classList.contains('is-open') && panel.classList.contains('is-open')) {
			return;
		}
		parent.classList.remove('is-open');
		panel.classList.remove('is-open');
		void panel.offsetHeight;
		parent.classList.add('is-open');
		panel.classList.add('is-open');
		if (trigger) trigger.setAttribute('aria-expanded', 'true');
	}

	function mountNavDropdown(dropdown, parentLi) {
		if (!dropdown || !parentLi) {
			return;
		}

		if (isMobileNavLayout()) {
			if (dropdown.parentElement !== parentLi) {
				parentLi.appendChild(dropdown);
			}
			dropdown.removeAttribute('hidden');
			dropdown.setAttribute('aria-hidden', 'true');
			dropdown.classList.remove('is-open');
			dropdown.style.top = '';
			dropdown.style.left = '';
			dropdown.style.right = '';
			return;
		}

		if (dropdown.parentElement !== document.body) {
			document.body.appendChild(dropdown);
		}
		prepareDesktopDropdownPanel(dropdown);
	}

	function mountAllNavDropdowns() {
		const menu = document.querySelector('[data-nav-menu]');
		if (!menu) {
			return;
		}

		mountNavDropdown(menu.querySelector('[data-mega-menu]'), menu.querySelector('[data-mega-parent]'));
		mountNavDropdown(
			menu.querySelector('[data-industry-solutions-dropdown]'),
			menu.querySelector('[data-industry-solutions-parent]')
		);
		mountNavDropdown(menu.querySelector('[data-company-dropdown]'), menu.querySelector('[data-company-parent]'));
	}

	mountAllNavDropdowns();
	mobileNavMq.addEventListener('change', mountAllNavDropdowns);

	function bindNavDropdownHover(parent, panel, openFn, closeFn) {
		function show() {
			if (!canHoverNavDropdowns()) return;
			cancelNavDropdownHide();
			openFn();
		}

		function hide() {
			if (!canHoverNavDropdowns()) return;
			scheduleNavDropdownHide(closeFn);
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
		const megaMenu = document.querySelector('[data-mega-menu]');
		const megaLinks = document.querySelectorAll('[data-mega-link]');

		mountNavDropdown(megaMenu, megaParent);

		function setActiveNavItem(activeItem) {
			navItems.forEach(function (item) {
				item.classList.toggle('is-active', item === activeItem);
			});
		}

		function positionMegaMenu() {
			if (!megaMenu || !headerInner || isMobileNavLayout()) return;
			const rect = headerInner.getBoundingClientRect();
			megaMenu.style.top = Math.round(rect.bottom) + 'px';
		}

		function closeMegaMenu() {
			if (!megaParent || !megaTrigger || !megaMenu) return;
			closeNavDropdownPanel(megaParent, megaMenu, megaTrigger);
		}

		function openMegaMenu() {
			if (!megaParent || !megaTrigger || !megaMenu) return;
			cancelNavDropdownHide();
			positionMegaMenu();
			openNavDropdownPanel(megaParent, megaMenu, megaTrigger);
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
		const industryMenu = document.querySelector('[data-industry-solutions-dropdown]');
		const industryLinks = document.querySelectorAll('[data-industry-solutions-link]');

		const companyParent = menu.querySelector('[data-company-parent]');
		const companyTrigger = menu.querySelector('[data-company-trigger]');
		const companyMenu = document.querySelector('[data-company-dropdown]');
		const companyLinks = document.querySelectorAll('[data-company-link]');

		mountNavDropdown(industryMenu, industryParent);
		mountNavDropdown(companyMenu, companyParent);

		function setActiveNavItem(activeItem) {
			navItems.forEach(function (item) {
				item.classList.toggle('is-active', item === activeItem);
			});
		}

		function positionDropdown(dropdownEl) {
			if (!dropdownEl || !headerInner || isMobileNavLayout()) return;
			const rect = headerInner.getBoundingClientRect();
			dropdownEl.style.top = Math.round(rect.bottom) + 'px';
		}

		function closeProductsDropdown() {
			if (!productsParent || !productsMenu) return;
			closeNavDropdownPanel(productsParent, productsMenu, productsTrigger);
		}

		function closeIndustryDropdown() {
			if (!industryParent || !industryTrigger || !industryMenu) return;
			closeNavDropdownPanel(industryParent, industryMenu, industryTrigger);
		}

		function closeCompanyDropdown() {
			if (!companyParent || !companyTrigger || !companyMenu) return;
			closeNavDropdownPanel(companyParent, companyMenu, companyTrigger);
		}

		function openIndustryDropdown() {
			if (!industryParent || !industryTrigger || !industryMenu) return;
			cancelNavDropdownHide();
			closeProductsDropdown();
			closeCompanyDropdown();
			positionDropdown(industryMenu);
			openNavDropdownPanel(industryParent, industryMenu, industryTrigger);
			setActiveNavItem(industryParent);
			document.dispatchEvent(new CustomEvent('growtele:nav-dropdown', { detail: 'industry' }));
		}

		function openCompanyDropdown() {
			if (!companyParent || !companyTrigger || !companyMenu) return;
			cancelNavDropdownHide();
			closeProductsDropdown();
			closeIndustryDropdown();
			positionDropdown(companyMenu);
			openNavDropdownPanel(companyParent, companyMenu, companyTrigger);
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
				const href = link.getAttribute('href');
				const hasDestination = href && href !== '#' && href.trim() !== '';
				if (!hasDestination) {
					event.preventDefault();
				}
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

		function isCaseMobileLayout() {
			return window.matchMedia('(max-width: 1024px)').matches;
		}

		function getActiveCaseTabKey() {
			if (isCaseMobileLayout()) {
				var activeTab = caseContainer.querySelector('.gt-case-studies__tab.is-active');
				return activeTab ? activeTab.dataset.caseTab : '0';
			}
			return stackOrder[stackOrder.length - 1] || '0';
		}

		function scrollCaseTabIntoView(tab, done) {
			if (!tab || !isCaseMobileLayout()) {
				if (done) done();
				return;
			}

			var scroller = caseContainer;
			var edge = 12;
			var tabLeft = tab.offsetLeft;
			var tabRight = tabLeft + tab.offsetWidth;
			var viewLeft = scroller.scrollLeft;
			var viewRight = viewLeft + scroller.clientWidth;
			var targetScroll = viewLeft;

			if (tabLeft < viewLeft + edge) {
				targetScroll = Math.max(0, tabLeft - edge);
			} else if (tabRight > viewRight - edge) {
				targetScroll = Math.min(
					scroller.scrollWidth - scroller.clientWidth,
					tabRight - scroller.clientWidth + edge
				);
			} else {
				if (done) done();
				return;
			}

			scroller.scrollTo({ left: targetScroll, behavior: 'smooth' });

			if (!done) return;

			var finished = false;
			function finish() {
				if (finished) return;
				finished = true;
				scroller.removeEventListener('scroll', onScroll);
				done();
			}

			function onScroll() {
				clearTimeout(scrollEndTimer);
				scrollEndTimer = setTimeout(finish, 60);
			}

			var scrollEndTimer = setTimeout(finish, 420);
			scroller.addEventListener('scroll', onScroll, { passive: true });
		}

		function syncStackHeight() {
			if (!stackEl) return;
			if (isCaseMobileLayout()) {
				stackEl.style.minHeight = 'auto';
				stackEl.style.height = 'auto';
				return;
			}
			stackEl.style.minHeight = '470px';
			stackEl.style.height = '470px';
		}

		function renderStack(target, animate) {
			if (isCaseMobileLayout()) {
				casePanels.forEach(function (panel) {
					panel.classList.remove('is-stacked', 'is-entering');
					panel.style.removeProperty('--stack-depth');
					var on = panel.dataset.casePanel === target;
					panel.classList.toggle('is-active', on);
					panel.setAttribute('aria-hidden', on ? 'false' : 'true');
				});
				requestAnimationFrame(syncStackHeight);
				return;
			}

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
			const current = getActiveCaseTabKey();
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

			function syncCaseTabChrome() {
				if (!tab) return;
				if (isManual && section.classList.contains('is-case-paused')) {
					updateCaseProgressPosition(tab);
					return;
				}
				startCaseProgress(tab);
			}

			if (isCaseMobileLayout()) {
				requestAnimationFrame(function () {
					scrollCaseTabIntoView(tab, syncCaseTabChrome);
				});
			} else {
				syncCaseTabChrome();
			}
		}

		const CASE_AUTO_MS = parseInt(section.getAttribute('data-case-cycle'), 10) || 5000;
		const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		let caseAutoTimer = null;

		function advanceCaseTab() {
			if (section.classList.contains('is-case-paused')) return;
			const current = getActiveCaseTabKey();
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
