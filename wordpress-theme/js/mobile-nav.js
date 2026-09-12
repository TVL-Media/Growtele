/**
 * Shared mobile nav toggle — industry + company pages.
 */
(function () {
  'use strict';

  var MOBILE_MQ = window.matchMedia('(max-width: 1024px)');

  function isDropdownTrigger(link) {
    return (
      link.hasAttribute('data-mega-trigger') ||
      link.hasAttribute('data-industry-solutions-trigger') ||
      link.hasAttribute('data-company-trigger')
    );
  }

  function closeNav(nav, toggle) {
    if (!nav) return;
    nav.classList.remove('is-open');
    document.body.classList.remove('gt-nav-open');
    if (toggle) {
      toggle.setAttribute('aria-expanded', 'false');
    }
    if (window.growteleLenis && typeof window.growteleLenis.start === 'function') {
      window.growteleLenis.start();
    }
  }

  function initToggle(toggle) {
    if (toggle.dataset.mobileNavBound === 'true') {
      return;
    }

    var header = toggle.closest('.header, [data-sms-header]');
    if (!header) {
      return;
    }

    var nav = header.querySelector('[data-sms-nav]');
    if (!nav) {
      return;
    }

    toggle.dataset.mobileNavBound = 'true';

    toggle.addEventListener('click', function (event) {
      event.stopPropagation();
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('gt-nav-open', open);

      if (window.growteleLenis) {
        if (open && typeof window.growteleLenis.stop === 'function') {
          window.growteleLenis.stop();
        } else if (!open && typeof window.growteleLenis.start === 'function') {
          window.growteleLenis.start();
        }
      }
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
      if (!nav.classList.contains('is-open')) {
        return;
      }
      if (header.contains(event.target)) {
        return;
      }
      closeNav(nav, toggle);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeNav(nav, toggle);
      }
    });

    window.addEventListener('resize', function () {
      if (!MOBILE_MQ.matches) {
        closeNav(nav, toggle);
      }
    });
  }

  function init() {
    document.querySelectorAll('.nav-toggle').forEach(initToggle);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
