(function () {
  'use strict';

  var jobCards = document.querySelectorAll('.job-card');

  jobCards.forEach(function (card) {
    var readMore = card.querySelector('.job-card__read-more');
    if (!readMore) {
      return;
    }

    readMore.addEventListener('click', function (event) {
      event.preventDefault();

      var isExpanded = card.classList.contains('is-expanded');

      jobCards.forEach(function (c) {
        c.classList.remove('is-expanded');
        var header = c.querySelector('.job-card__header');
        if (header) {
          header.setAttribute('aria-expanded', 'false');
        }
      });

      if (!isExpanded) {
        card.classList.add('is-expanded');
        var expandedHeader = card.querySelector('.job-card__header');
        if (expandedHeader) {
          expandedHeader.setAttribute('aria-expanded', 'true');
        }
      }
    });
  });

  (function initCultureHorizontalScroll() {
    var section = document.querySelector('[data-culture-hscroll]');
    var track = section && section.querySelector('[data-culture-track]');
    if (!section || !track) {
      return;
    }

    var desktopMq = window.matchMedia('(min-width: 1025px)');
    var sticky = section.querySelector('.culture-hscroll__sticky');
    var culturePinTop = 120;
    var pinned = false;
    var pinScrollY = 0;
    var progress = 0;
    var wheelAccum = 0;

    function maxShift() {
      return Math.max(0, track.scrollWidth - window.innerWidth);
    }

    function stickyHeight() {
      return sticky ? sticky.offsetHeight : 0;
    }

    function getScrollY() {
      if (window.growteleLenis && typeof window.growteleLenis.scroll === 'number') {
        return window.growteleLenis.scroll;
      }
      return window.scrollY || window.pageYOffset || 0;
    }

    function freezeAt(y) {
      pinScrollY = y;
      var lenis = window.growteleLenis;
      if (lenis && typeof lenis.scrollTo === 'function') {
        lenis.scrollTo(y, { immediate: true });
      } else {
        window.scrollTo(0, y);
      }
    }

    function getViewCenterY() {
      return window.innerHeight * 0.5;
    }

    function getCardsCenterY() {
      if (!sticky) {
        return 0;
      }
      var rect = sticky.getBoundingClientRect();
      return rect.top + rect.height * 0.5;
    }

    function getCenterTolerance() {
      return Math.max(48, window.innerHeight * 0.055);
    }

    function measurePinTop() {
      var sh = stickyHeight() || 384;
      culturePinTop = Math.max(80, Math.round(getViewCenterY() - sh * 0.5));
      section.style.setProperty('--culture-sticky-top', culturePinTop + 'px');
    }

    function applyProgress(nextProgress, immediate) {
      var shift = maxShift();
      progress = Math.min(1, Math.max(0, nextProgress));
      wheelAccum = progress * shift;
      track.style.transition = immediate ? 'none' : 'transform 0.12s linear';
      track.style.transform = 'translate3d(' + (-progress * shift) + 'px,0,0)';
    }

    function stickyAtPinLine() {
      if (!sticky) {
        return false;
      }
      return Math.abs(getCardsCenterY() - getViewCenterY()) <= getCenterTolerance();
    }

    function sectionInCultureView() {
      var rect = section.getBoundingClientRect();
      return rect.top < window.innerHeight * 0.92 && rect.bottom > getViewCenterY() * 0.35;
    }

    function alignPinScrollY() {
      if (!sticky) {
        return pinScrollY;
      }
      return getScrollY() + (getCardsCenterY() - getViewCenterY());
    }

    function beginPin() {
      pinned = true;
      freezeAt(alignPinScrollY());
    }

    function releasePin() {
      pinned = false;
    }

    function resetLayout() {
      if (!desktopMq.matches) {
        section.style.height = '';
        section.style.marginBottom = '';
        section.style.removeProperty('--culture-sticky-top');
        track.style.transform = '';
        track.style.transition = '';
        pinned = false;
        progress = 0;
        wheelAccum = 0;
        return;
      }

      measurePinTop();
      section.style.height = '';
      section.style.marginBottom = '';
      applyProgress(progress, true);
    }

    function onWheel(event) {
      if (!desktopMq.matches) {
        return;
      }

      var shift = maxShift();
      if (shift <= 0) {
        return;
      }

      var goingDown = event.deltaY > 0;
      var goingUp = event.deltaY < 0;

      if (!sectionInCultureView()) {
        if (progress <= 0) {
          releasePin();
        }
        return;
      }

      if (goingDown && progress >= 1) {
        releasePin();
        return;
      }

      if (goingUp && progress <= 0) {
        releasePin();
        return;
      }

      if (!pinned) {
        if (!stickyAtPinLine()) {
          return;
        }
        if (goingDown && progress < 1) {
          beginPin();
        } else if (goingUp && progress > 0) {
          beginPin();
        } else {
          return;
        }
      }

      event.preventDefault();
      event.stopPropagation();
      freezeAt(pinScrollY);

      wheelAccum += event.deltaY;
      wheelAccum = Math.min(shift, Math.max(0, wheelAccum));
      applyProgress(wheelAccum / shift);

      if (progress >= 1 && goingDown) {
        releasePin();
      }
      if (progress <= 0 && goingUp) {
        releasePin();
      }
    }

    function resetIfScrolledPastSection() {
      var rect = section.getBoundingClientRect();
      if (rect.top > window.innerHeight) {
        if (progress > 0) {
          applyProgress(0, true);
        }
        releasePin();
      }
    }

    function onScrollPassive() {
      if (!desktopMq.matches) {
        return;
      }

      resetIfScrolledPastSection();

      if (pinned) {
        if (progress >= 1 || progress <= 0) {
          releasePin();
          return;
        }
        freezeAt(pinScrollY);
        return;
      }

      if (progress <= 0 || progress >= 1) {
        return;
      }

      if (stickyAtPinLine() && sectionInCultureView()) {
        beginPin();
      }
    }

    function onLayoutChange() {
      resetLayout();
    }

    window.addEventListener('wheel', onWheel, { passive: false, capture: true });
    window.addEventListener('scroll', onScrollPassive, { passive: true });
    window.addEventListener('growtele:scroll', onScrollPassive, { passive: true });
    window.addEventListener('resize', onLayoutChange);
    window.addEventListener('growtele:smooth-scroll-ready', onLayoutChange);
    if (typeof desktopMq.addEventListener === 'function') {
      desktopMq.addEventListener('change', onLayoutChange);
    } else if (typeof desktopMq.addListener === 'function') {
      desktopMq.addListener(onLayoutChange);
    }

    window.addEventListener('load', onLayoutChange);
    onLayoutChange();
  })();

  (function initCareerPhotoCarousel() {
    var carousel = document.querySelector('[data-career-photo-carousel]');
    if (!carousel) {
      return;
    }

    var cards = Array.prototype.slice.call(carousel.querySelectorAll('.cta-mid__stack-card'));
    if (cards.length < 2) {
      return;
    }

    var activeIndex = 0;
    var timerId = null;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function wrap(index) {
      var total = cards.length;
      return (index % total + total) % total;
    }

    function render() {
      cards.forEach(function (card, index) {
        var pos = 'hidden';
        if (index === activeIndex) {
          pos = 'center';
        } else if (index === wrap(activeIndex - 1)) {
          pos = 'left';
        } else if (index === wrap(activeIndex + 1)) {
          pos = 'right';
        }
        card.setAttribute('data-pos', pos);
      });
    }

    function advance() {
      activeIndex = wrap(activeIndex + 1);
      render();
    }

    function start() {
      if (timerId || reduceMotion) {
        return;
      }
      timerId = window.setInterval(advance, 2150);
    }

    function stop() {
      if (!timerId) {
        return;
      }
      window.clearInterval(timerId);
      timerId = null;
    }

    render();
    start();

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) {
        stop();
      } else {
        start();
      }
    });
  })();
})();
