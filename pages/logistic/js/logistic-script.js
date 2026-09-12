(function () {
  'use strict';

  /* Channel tabs */
  var channelData = {
    sms: {
      title: 'Deliver personalized shopping experiences through SMS with instant notifications, promotional alerts and two-way customer engagement.',
      desc: 'Engage customers with personalized offers, order updates, and real-time support on SMS.',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/048f9c95d92484c5b83adf2cab1aab70c19a1bb9.png'
    },
    whatsapp: {
      title: 'Deliver personalized shopping experiences through WhatsApp with product catalogs, exclusive offers and instant customer assistance.',
      desc: 'Engage customers with personalized offers, order updates, and real-time support on WhatsApp.',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/75dfa533b29fdf1be34332baa54751442a8ee9b7.png'
    },
    telephony: {
      title: 'Deliver personalized shopping experiences through Cloud Telephony with voice-assisted calls and automated customer support.',
      desc: 'Engage customers with personalized offers, order updates, and real-time support on Cloud Telephony.',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/e1c09164fdad96522a0dbeb6c8054148660caacb.png'
    },
    rcs: {
      title: 'Deliver personalized shopping experiences through RCS with rich media messages, carousels and interactive retail campaigns.',
      desc: 'Engage customers with personalized offers, order updates, and real-time support on RCS.',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/7326829650997d9f4748051752355347b07f16f6.png'
    },
    email: {
      title: 'Deliver personalized shopping experiences through E-mail with targeted campaigns, product recommendations and loyalty updates.',
      desc: 'Engage customers with personalized offers, order updates, and real-time support on E-mail.',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-624.png'
    }
  };

  var industryChannels = window.growteleInitIndustryChannels(channelData);
  var tabs = document.querySelectorAll('.channels__tab');

  /* Channels — tabs follow scroll through sticky stage (no scroll blocking) */
  (function initChannelsScroll() {
    var section = document.querySelector('.channels');
    var stage = section && section.querySelector('.channels__scroll-stage');
    var sticky = stage && stage.querySelector('.channels__sticky');
    if (!section || !stage || !sticky || !tabs.length) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var maxProgress = tabs.length - 1;
    var stickyTop = 100;
    var STEP_VH = 0.42;
    var TOP_INSET = 16;
    var desktopQuery = window.matchMedia('(min-width: 1281px)');

    function getBottomGap() {
      var gap = parseInt(getComputedStyle(section).getPropertyValue('--channels-bottom-gap'), 10);
      return isFinite(gap) && gap > 0 ? gap : 48;
    }

    function getStickyTop() {
      var blockHeight = sticky.offsetHeight;
      var viewHeight = window.innerHeight;
      var bottomGap = getBottomGap();

      if (blockHeight <= 0) return TOP_INSET;

      if (blockHeight + TOP_INSET + bottomGap <= viewHeight) {
        return TOP_INSET;
      }

      return Math.max(TOP_INSET, Math.round(viewHeight - blockHeight - bottomGap));
    }

    function measureStage() {
      stickyTop = getStickyTop();
      section.style.setProperty('--channels-sticky-top', stickyTop + 'px');

      if (!desktopQuery.matches) {
        stage.style.height = '';
        return;
      }

      var stepHeight = window.innerHeight * STEP_VH;
      var range = Math.max(1, maxProgress * stepHeight);
      stage.style.height = (sticky.offsetHeight + range) + 'px';
    }

    function applyTab(index) {
      var next = Math.min(maxProgress, Math.max(0, Math.round(index)));
      if (!industryChannels || next === industryChannels.getActiveIndex()) return;
      industryChannels.activateChannelTab(tabs[next], { animate: true, immediate: true });
    }

    function syncTabFromScroll() {
      if (!desktopQuery.matches) return;

      stickyTop = getStickyTop();
      section.style.setProperty('--channels-sticky-top', stickyTop + 'px');

      var stageRect = stage.getBoundingClientRect();

      if (stageRect.top > stickyTop + 8) {
        if (industryChannels && industryChannels.getActiveIndex() !== 0) applyTab(0);
        return;
      }

      var scrollRange = stage.offsetHeight - sticky.offsetHeight;
      if (scrollRange <= 0) return;

      var scrolled = Math.max(0, stickyTop - stageRect.top);
      var progress = Math.min(1, scrolled / scrollRange);
      applyTab(Math.round(progress * maxProgress));
    }

    var ticking = false;
    function scheduleSync() {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        ticking = false;
        syncTabFromScroll();
      });
    }

    function bindLenisScroll() {
      var lenis = window.growteleLenis;
      if (!lenis || lenis.__channelsScrollBound) return;
      lenis.__channelsScrollBound = true;
      lenis.on('scroll', scheduleSync);
    }

    measureStage();
    scheduleSync();

    window.addEventListener('scroll', scheduleSync, { passive: true });
    window.addEventListener('growtele:scroll', scheduleSync, { passive: true });
    window.addEventListener('resize', function () {
      measureStage();
      scheduleSync();
    });
    window.addEventListener('growtele:smooth-scroll-ready', function () {
      measureStage();
      bindLenisScroll();
      scheduleSync();
    });
    window.addEventListener('load', function () {
      measureStage();
      bindLenisScroll();
      scheduleSync();
      setTimeout(scheduleSync, 150);
      setTimeout(scheduleSync, 800);
    });

    bindLenisScroll();

    if (typeof desktopQuery.addEventListener === 'function') {
      desktopQuery.addEventListener('change', function () {
        measureStage();
        scheduleSync();
      });
    }
  })();

  /* Use cases — horizontal carousel driven by vertical scroll (retail layout) */
  (function initUsecasesCarousel() {
    var section = document.querySelector('.usecases');
    var viewport = document.querySelector('[data-usecases-carousel]');
    var track = viewport && viewport.querySelector('.usecases__cards');
    var dots = Array.prototype.slice.call(document.querySelectorAll('[data-usecases-dot]'));
    if (!section || !viewport || !track || !dots.length) return;

    var cards = Array.prototype.slice.call(track.querySelectorAll('.usecase-card'));
    if (cards.length < 2) return;

    if (window.growteleInitUsecasesMobile && window.growteleInitUsecasesMobile(viewport, track, dots, cards)) {
      return;
    }

    var GAP = 21;
    var CARD_W = 438;
    var STEP = CARD_W + GAP;
    var trackW = 0;
    var maxProgress = cards.length - 1;
    var activeIndex = 0;
    var progress = 0;
    var pinned = false;
    var pinScrollY = 0;
    var wheelLocked = false;
    var SLIDE_MS = 280;

    function getViewCenterY() {
      return window.innerHeight * 0.5;
    }

    function getCarouselCenterY() {
      var vpRect = viewport.getBoundingClientRect();
      return vpRect.top + vpRect.height * 0.5;
    }

    function getCenterTolerance() {
      return Math.max(50, window.innerHeight * 0.055);
    }

    function isInCarouselZone() {
      return Math.abs(getCarouselCenterY() - getViewCenterY()) <= getCenterTolerance();
    }

    function getPinScrollY() {
      var scrollY = getScrollY();
      return Math.max(0, scrollY + (getCarouselCenterY() - getViewCenterY()));
    }

    function beginPin() {
      pinned = true;
      freezeAt(getPinScrollY());
    }

    function measureLayout() {
      CARD_W = cards[0] ? cards[0].offsetWidth : 438;
      STEP = CARD_W + GAP;
      trackW = cards.length * CARD_W + Math.max(0, cards.length - 1) * GAP;
      applySlide(activeIndex, true);
    }

    function applySlide(index, immediate) {
      activeIndex = Math.min(maxProgress, Math.max(0, Math.round(index)));
      progress = activeIndex;
      var offset = Math.min(activeIndex * STEP, getMaxOffset());
      track.style.transition = immediate ? 'none' : 'transform 0.28s ease-out';
      track.style.transform = 'translate3d(' + (-offset) + 'px,0,0)';
      dots.forEach(function (dot, i) {
        if (i > maxProgress) {
          dot.style.display = 'none';
          return;
        }
        dot.style.display = '';
        dot.classList.toggle('usecases__dot--active', i === activeIndex);
      });
    }

    function tryStep(direction) {
      if (wheelLocked) return false;
      var next = activeIndex + direction;
      if (next < 0 || next > maxProgress) return false;
      applySlide(next);
      wheelLocked = true;
      window.setTimeout(function () {
        wheelLocked = false;
      }, SLIDE_MS);
      return true;
    }

    function getViewWidth() {
      return viewport.clientWidth || 1206;
    }

    function getMaxOffset() {
      return Math.max(0, trackW - getViewWidth());
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

    function sectionInView() {
      var rect = section.getBoundingClientRect();
      return rect.top < window.innerHeight * 0.92 && rect.bottom > window.innerHeight * 0.08;
    }

    function isAtPinLevel() {
      if (!sectionInView()) return false;
      if (pinned) return true;
      if (progress >= maxProgress) return false;
      return isInCarouselZone();
    }

    function isReadyForScrollUp() {
      if (progress <= 0) return false;
      if (!sectionInView()) return false;
      if (pinned) return true;
      return isInCarouselZone();
    }

    function catchScrollUpEntry(goingUp) {
      if (!goingUp || pinned || progress <= 0 || progress >= maxProgress) return;
      if (!isInCarouselZone()) return;
      beginPin();
    }

    function resetIfAboveSection() {
      var rect = section.getBoundingClientRect();
      if (rect.top > window.innerHeight && progress > 0) {
        progress = 0;
        pinned = false;
        applySlide(0, true);
      }
    }

    function onWheel(event) {
      resetIfAboveSection();

      var goingDown = event.deltaY > 0;
      var goingUp = event.deltaY < 0;

      if (goingDown && progress >= maxProgress) {
        pinned = false;
        return;
      }

      catchScrollUpEntry(goingUp);

      if (!sectionInView()) {
        pinned = false;
        return;
      }

      var atLevel = isAtPinLevel();
      var readyUp = isReadyForScrollUp();

      if (pinned && goingDown && progress >= maxProgress) {
        pinned = false;
        return;
      }

      if (!atLevel && !readyUp) {
        if (progress <= 0) pinned = false;
        return;
      }

      if (!pinned && goingDown && progress <= 0 && atLevel) {
        beginPin();
        event.preventDefault();
        event.stopPropagation();
        tryStep(1);
        return;
      }

      if (!pinned && goingUp && readyUp) {
        beginPin();
        event.preventDefault();
        event.stopPropagation();
        tryStep(-1);
        return;
      }

      if (!pinned) return;

      if (goingDown && activeIndex < maxProgress) {
        event.preventDefault();
        event.stopPropagation();
        freezeAt(pinScrollY);
        tryStep(1);
        if (activeIndex >= maxProgress) {
          pinned = false;
        }
        return;
      }

      if (goingUp && activeIndex > 0) {
        event.preventDefault();
        event.stopPropagation();
        freezeAt(pinScrollY);
        tryStep(-1);
        if (activeIndex <= 0) pinned = false;
        return;
      }

      if (goingDown && progress >= maxProgress) {
        pinned = false;
      }

      if (goingUp && progress <= 0) {
        pinned = false;
      }
    }

    function onLayoutChange() {
      measureLayout();
    }

    window.addEventListener('wheel', onWheel, { passive: false, capture: true });
    window.addEventListener('growtele:scroll', resetIfAboveSection, { passive: true });
    window.addEventListener('scroll', resetIfAboveSection, { passive: true });
    window.addEventListener('resize', onLayoutChange);
    if (window.visualViewport) {
      window.visualViewport.addEventListener('resize', onLayoutChange);
    }
    window.addEventListener('growtele:smooth-scroll-ready', onLayoutChange);
    window.addEventListener('load', onLayoutChange);

    dots.forEach(function (dot, i) {
      if (i > maxProgress) {
        dot.style.display = 'none';
        return;
      }
      dot.style.cursor = 'pointer';
      dot.addEventListener('click', function () {
        applySlide(i);
      });
    });

    measureLayout();
  })();
})();
