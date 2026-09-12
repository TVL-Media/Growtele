/**
 * Shared mobile nav — landing, product, industry, and company pages.
 */
(function () {
  'use strict';

  var MOBILE_MQ = window.matchMedia('(max-width: 1024px)');
  var backdrop = null;
  var activeNav = null;
  var activeToggle = null;

  function isDropdownTrigger(link) {
    return (
      link.hasAttribute('data-mega-trigger') ||
      link.hasAttribute('data-industry-solutions-trigger') ||
      link.hasAttribute('data-company-trigger')
    );
  }

  function getNavContext(toggle) {
    var landingNav = toggle.closest('.gt-header__nav');
    if (landingNav) {
      return {
        nav: landingNav,
        toggle: toggle,
      };
    }

    var header = toggle.closest('.header, [data-sms-header]');
    if (!header) {
      return null;
    }

    var nav = header.querySelector('[data-sms-nav], .header__nav, .nav');
    if (!nav) {
      return null;
    }

    return { nav: nav, toggle: toggle };
  }

  function getBackdrop() {
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'gt-nav-backdrop';
      backdrop.setAttribute('aria-hidden', 'true');
      backdrop.addEventListener('click', closeActiveNav);
      backdrop.addEventListener('touchstart', closeActiveNav, { passive: true });
      document.body.appendChild(backdrop);
    }
    return backdrop;
  }

  function closeNav(nav, toggle) {
    var targetNav = nav || activeNav;
    var targetToggle = toggle || activeToggle;
    if (!targetNav || !targetToggle) {
      return;
    }

    targetNav.classList.remove('is-open');
    targetToggle.setAttribute('aria-expanded', 'false');
    targetToggle.classList.remove('is-active');
    document.body.classList.remove('gt-nav-open');
    document.body.style.overflow = '';
    getBackdrop().classList.remove('is-visible');

    if (window.growteleLenis && typeof window.growteleLenis.start === 'function') {
      window.growteleLenis.start();
    }

    if (activeNav === targetNav) {
      activeNav = null;
      activeToggle = null;
    }
  }

  function closeActiveNav() {
    closeNav(activeNav, activeToggle);
  }

  function openNav(nav, toggle) {
    nav.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'true');
    toggle.classList.add('is-active');
    document.body.classList.add('gt-nav-open');
    document.body.style.overflow = 'hidden';
    getBackdrop().classList.add('is-visible');
    activeNav = nav;
    activeToggle = toggle;

    window.requestAnimationFrame(function () {
      window.requestAnimationFrame(function () {
        nav.classList.add('is-open');
      });
    });

    if (MOBILE_MQ.matches && typeof window.growteleSyncSmsNavPanels === 'function') {
      window.growteleSyncSmsNavPanels();
    }

    if (window.growteleLenis && typeof window.growteleLenis.stop === 'function') {
      window.growteleLenis.stop();
    }
  }

  function isInsideNav(event, nav, toggle) {
    var target = event.target;
    if (!target) {
      return false;
    }
    if (toggle.contains(target)) {
      return true;
    }
    if (nav.contains(target)) {
      return true;
    }
    return false;
  }

  function initToggle(toggle) {
    if (toggle.dataset.mobileNavBound === 'true') {
      return;
    }

    var ctx = getNavContext(toggle);
    if (!ctx) {
      return;
    }

    var nav = ctx.nav;
    var ignoreOutsideClick = false;
    toggle.dataset.mobileNavBound = 'true';

    toggle.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();
      ignoreOutsideClick = true;
      window.setTimeout(function () {
        ignoreOutsideClick = false;
      }, 0);

      if (nav.classList.contains('is-open')) {
        closeNav(nav, toggle);
        return;
      }

      if (activeNav && activeNav !== nav) {
        closeNav(activeNav, activeToggle);
      }

      openNav(nav, toggle);
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        if (isDropdownTrigger(link)) {
          return;
        }
        if (!MOBILE_MQ.matches) {
          return;
        }
        closeNav(nav, toggle);
      });
    });

    document.addEventListener('click', function (event) {
      if (ignoreOutsideClick) {
        return;
      }
      if (!nav.classList.contains('is-open')) {
        return;
      }
      if (isInsideNav(event, nav, toggle)) {
        return;
      }
      closeNav(nav, toggle);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && nav.classList.contains('is-open')) {
        closeNav(nav, toggle);
      }
    });

    window.addEventListener('resize', function () {
      if (!MOBILE_MQ.matches && nav.classList.contains('is-open')) {
        closeNav(nav, toggle);
      }
    });
  }

  function init() {
    /* Landing page uses main.js for gt-header__toggle */
    document.querySelectorAll('.nav-toggle').forEach(initToggle);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
