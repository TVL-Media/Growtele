(function () {
  'use strict';

  if (window.growteleResolveAssetUrl) {
    return;
  }

  var THEME_CDN = 'https://listings.selectvia.com/wp-content/themes/mt';
  var RASTER_EXT = /\.(png|jpe?g|gif|webp|mp4|mov|avif|svg)(\?|$)/i;

  function encodePart(part) {
    try {
      return encodeURIComponent(decodeURIComponent(part));
    } catch (e) {
      return encodeURIComponent(part);
    }
  }

  function encodePath(path) {
    return String(path)
      .split('/')
      .filter(Boolean)
      .map(encodePart)
      .join('/');
  }

  function isAbsoluteUrl(path) {
    return /^https?:\/\//i.test(path) || /^\/\//.test(path) || path.charAt(0) === '/';
  }

  function normalizeSlashes(path) {
    return String(path || '').replace(/\\/g, '/').replace(/^\.\//, '');
  }

  function documentBase(hintEl) {
    if (hintEl && hintEl.ownerDocument && hintEl.ownerDocument.baseURI) {
      return hintEl.ownerDocument.baseURI;
    }

    if (document.baseURI) {
      return document.baseURI;
    }

    return window.location.href;
  }

  function resolveWithBase(path, base) {
    try {
      return new URL(path, base).href;
    } catch (e) {
      return path;
    }
  }

  function isThemeAssetBase(base) {
    return /\/wp-content\/themes\//i.test(String(base || ''));
  }

  function detectPageSlug(hintEl) {
    if (window.GROWTELE_PAGE_ASSETS) {
      var fromBase = String(window.GROWTELE_PAGE_ASSETS).match(/\/pages\/([^/]+)\/assets\/?$/i);
      if (fromBase) {
        return fromBase[1];
      }
    }

    try {
      var pathname = new URL(documentBase(hintEl)).pathname;
      var parts = pathname.split('/').filter(Boolean);
      if (parts.length) {
        return decodeURIComponent(parts[parts.length - 1]);
      }
    } catch (e) {
      /* ignore */
    }

    return null;
  }

  function resolveThemeMirror(path, hintEl) {
    var normalized = normalizeSlashes(path);

    if (!/^assets\//i.test(normalized)) {
      return null;
    }

    var slug = detectPageSlug(hintEl);
    if (!slug) {
      return null;
    }

    var rel = normalized.replace(/^assets\//i, '');
    return THEME_CDN + '/pages/' + encodePart(slug) + '/assets/' + encodePath(rel);
  }

  function resolveWordPressPageAsset(path) {
    if (!window.GROWTELE_PAGE_ASSETS) {
      return null;
    }

    var normalized = normalizeSlashes(path);

    if (!/^assets\//i.test(normalized)) {
      return null;
    }

    var rel = normalized.replace(/^assets\//i, '');
    var base = window.GROWTELE_PAGE_ASSETS;

    if (!/\/assets\/$/i.test(base)) {
      base = base.replace(/\/?$/, '/assets/');
    }

    return base + rel.split('/').map(encodePart).join('/');
  }

  function shouldUseThemeMirror(hintEl) {
    var host = '';

    try {
      host = new URL(documentBase(hintEl)).hostname;
    } catch (e) {
      return false;
    }

    if (host === 'listings.selectvia.com') {
      return true;
    }

    if (window.GROWTELE_PAGE_ASSETS && !isThemeAssetBase(window.GROWTELE_PAGE_ASSETS)) {
      return true;
    }

    return host === 'localhost' || host === '127.0.0.1';
  }

  window.growteleResolveAssetUrl = function (path, hintEl) {
    if (!path || isAbsoluteUrl(path)) {
      return path;
    }

    var wpAsset = resolveWordPressPageAsset(path);
    var themeMirror = shouldUseThemeMirror(hintEl) ? resolveThemeMirror(path, hintEl) : null;

    if (wpAsset && isThemeAssetBase(window.GROWTELE_PAGE_ASSETS)) {
      return wpAsset;
    }

    if (themeMirror) {
      return themeMirror;
    }

    if (wpAsset) {
      return wpAsset;
    }

    return resolveWithBase(path, documentBase(hintEl));
  };

  window.growteleApplyAssetSrc = function (el, path) {
    if (!el || !path) {
      return;
    }

    el.src = window.growteleResolveAssetUrl(path, el);
  };

  function repairMediaAttribute(el, attribute) {
    var raw = el.getAttribute(attribute);

    if (!raw || isAbsoluteUrl(raw)) {
      return;
    }

    var fixed = window.growteleResolveAssetUrl(raw, el);

    if (fixed && fixed !== raw) {
      el.setAttribute(attribute, fixed);
    }
  }

  function repairAllMediaElements() {
    document.querySelectorAll('img[src], source[src], video[src]').forEach(function (el) {
      repairMediaAttribute(el, 'src');
    });

    document.querySelectorAll('video[poster]').forEach(function (el) {
      repairMediaAttribute(el, 'poster');
    });
  }

  function handleMediaError(event) {
    var target = event.target;

    if (!target || (target.tagName !== 'IMG' && target.tagName !== 'VIDEO' && target.tagName !== 'SOURCE')) {
      return;
    }

    var attribute = target.tagName === 'VIDEO' && target.hasAttribute('poster') && !target.getAttribute('src')
      ? 'poster'
      : 'src';
    var raw = target.getAttribute(attribute) || '';

    if (!raw || isAbsoluteUrl(raw)) {
      return;
    }

    var themeMirror = resolveThemeMirror(raw, target);
    if (themeMirror && target.getAttribute(attribute) !== themeMirror) {
      target.setAttribute(attribute, themeMirror);
      return;
    }

    var fixed = window.growteleResolveAssetUrl(raw, target);

    if (fixed && fixed !== raw && fixed !== target.getAttribute(attribute)) {
      target.setAttribute(attribute, fixed);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', repairAllMediaElements);
  } else {
    repairAllMediaElements();
  }

  document.addEventListener('error', handleMediaError, true);
})();
