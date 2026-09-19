(function () {
  'use strict';

  var CDN_HOST = 'listings.selectvia.com';
  var FIRST_SCREEN_BUFFER = 120;

  function fixBrokenSrc(src) {
    if (!src) {
      return src;
    }

    return src
      .replace(/^(?:\.\.\/)+https:\/\//i, 'https://')
      .replace(/\/https:\/\//i, 'https://');
  }

  function ensurePreconnect() {
    if (document.querySelector('link[rel="preconnect"][href*="' + CDN_HOST + '"]')) {
      return;
    }

    if (window.location.hostname === CDN_HOST) {
      return;
    }

    var preconnect = document.createElement('link');
    preconnect.rel = 'preconnect';
    preconnect.href = 'https://' + CDN_HOST;
    preconnect.crossOrigin = '';
    document.head.appendChild(preconnect);
  }

  function isInFirstScreen(el) {
    var rect = el.getBoundingClientRect();
    return rect.top < window.innerHeight + FIRST_SCREEN_BUFFER && rect.bottom > -FIRST_SCREEN_BUFFER;
  }

  function isHeaderLogo(el) {
    return !!(
      el &&
      el.tagName === 'IMG' &&
      (el.closest('.gt-retail-header .header__logo, .gt-header__logo') ||
        el.classList.contains('custom-logo') ||
        el.classList.contains('gt-header__logo-img'))
    );
  }

  function isPriorityImage(el) {
    if (!el || el.tagName !== 'IMG') {
      return false;
    }

    if (isHeaderLogo(el)) {
      return true;
    }

    if (el.closest('header, .nav, .hero, .channels, .platform-tabs, .journey, .funnel, .growth-card')) {
      return true;
    }

    if (el.id === 'channel-phone-img' || el.id === 'funnelVisual') {
      return true;
    }

    return false;
  }

  function markLoaded(img) {
    img.classList.remove('gt-img-loading');
    img.classList.add('gt-img-loaded');
  }

  function markLoading(img) {
    if (img.classList.contains('gt-img-loaded')) {
      return;
    }

    img.classList.add('gt-img-loading');
  }

  function normalizeImage(img) {
    var fixed = fixBrokenSrc(img.getAttribute('src') || img.src || '');

    if (fixed && fixed !== img.getAttribute('src')) {
      img.src = fixed;
    }

    if (!img.hasAttribute('decoding')) {
      img.decoding = 'async';
    }

    if (img.dataset.gtLazyInit === '1') {
      return;
    }

    img.dataset.gtLazyInit = '1';

    if (isHeaderLogo(img)) {
      img.loading = 'eager';
      img.fetchPriority = 'high';
      markLoaded(img);
      img.addEventListener('load', markLoaded, { once: true });
      img.addEventListener('error', function () {
        img.classList.remove('gt-img-loading');
      }, { once: true });
      return;
    }

    if (isPriorityImage(img)) {
      img.loading = 'eager';
      img.fetchPriority = 'high';
    } else if (!img.hasAttribute('loading')) {
      img.loading = 'lazy';
    }

    if (img.complete && img.naturalWidth > 0) {
      markLoaded(img);
      return;
    }

    markLoading(img);
    img.addEventListener('load', function () {
      markLoaded(img);
    }, { once: true });
    img.addEventListener('error', function () {
      img.classList.remove('gt-img-loading');
    }, { once: true });
  }

  function optimizeImages(root) {
    (root || document).querySelectorAll('img').forEach(normalizeImage);
  }

  function promoteFirstScreenImages() {
    document.querySelectorAll('img[loading="lazy"]').forEach(function (img) {
      if (isInFirstScreen(img)) {
        img.loading = 'eager';
        img.fetchPriority = 'high';
      }
    });
  }

  function observeNewImages() {
    if (!('MutationObserver' in window)) {
      return;
    }

    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        mutation.addedNodes.forEach(function (node) {
          if (!node || node.nodeType !== 1) {
            return;
          }

          if (node.tagName === 'IMG') {
            normalizeImage(node);
          } else if (node.querySelectorAll) {
            optimizeImages(node);
          }
        });
      });
    });

    observer.observe(document.documentElement, {
      childList: true,
      subtree: true
    });
  }

  ensurePreconnect();
  optimizeImages();

  if ('requestAnimationFrame' in window) {
    requestAnimationFrame(promoteFirstScreenImages);
  } else {
    promoteFirstScreenImages();
  }

  observeNewImages();

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      optimizeImages();
      promoteFirstScreenImages();
    });
  }

  window.growteleRefreshImagePerformance = optimizeImages;

  document.addEventListener(
    'error',
    function (event) {
      var target = event.target;

      if (!target || target.tagName !== 'IMG') {
        return;
      }

      var fixed = fixBrokenSrc(target.getAttribute('src') || '');

      if (fixed && fixed !== target.getAttribute('src')) {
        target.src = fixed;
      }
    },
    true
  );
})();
