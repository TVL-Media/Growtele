(function () {
  'use strict';

  /* Channel tabs */
  var channelData = {
    sms: {
      title: 'Send booking confirmations, PNR status, gate changes, and check-in reminders over SMS from DLT-approved headers to any mobile.',
      desc: 'Booking confirmations and flight alerts by SMS that reach any phone, even when offline.',
      image: 'assets/ReTail X SMS.png',
      features: [
        { title: 'Booking Confirmations', text: 'Confirm flight, hotel, and holiday bookings instantly with the PNR, dates, and full trip details.' },
        { title: 'Flight Status', text: 'Alert travelers to delays, gate changes, cancellations, and web check-in windows before they leave.' },
        { title: 'Holiday Fare Offers', text: 'Share holiday deals, seasonal airfares, and loyalty points with travelers who opted in to promotions.' }
      ]
    },
    whatsapp: {
      title: 'Help travelers on WhatsApp with e-tickets, boarding passes, itinerary updates, and instant answers to their booking questions.',
      desc: 'Share e-tickets, boarding passes, trip updates, and instant booking support on WhatsApp.',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-691.png',
      features: [
        { title: 'E-Tickets &amp; Boarding Passes', text: 'Send e-tickets, hotel vouchers, and boarding passes on WhatsApp, so travelers have everything on their phone.' },
        { title: 'Itinerary Updates', text: 'Share day-by-day itineraries and let travelers know right away about any change in timings or plans.' },
        { title: 'Booking Support', text: 'Answer questions about baggage, cancellations, and refunds instantly, with a live agent ready for tricky cases.' }
      ]
    },
    telephony: {
      title: 'Answer booking queries on IVR and call travelers about cancellations and reschedules with automated outbound voice alerts.',
      desc: 'IVR helplines, outbound calls, and number masking for cab drivers, tour guides, and travelers.',
      image: 'assets/ReTail X Cloud Tele.png',
      features: [
        { title: 'IVR Booking Helpline', text: 'Travelers call one number and get routed to bookings, cancellations, or refunds through a simple IVR menu.' },
        { title: 'Disruption Alert Calls', text: 'Call travelers automatically about cancellations or reschedules, so the news reaches them even when offline.' },
        { title: 'Masked Driver Calls', text: 'Cab drivers, tour guides, and travelers connect on masked numbers, keeping personal numbers private.' }
      ]
    },
    rcs: {
      title: 'Show flight details, seat upgrade offers, and hotel carousels in branded RCS cards with one-tap web check-in buttons.',
      desc: 'Verified RCS cards with hotel carousels, seat upgrades, and one-tap check-in buttons.',
      image: 'assets/ReTail X RCS.png',
      features: [
        { title: 'Flight Detail Cards', text: 'Show the flight number, gate, and boarding time in a branded card with a one-tap web check-in button.' },
        { title: 'Hotel Carousels', text: 'Show hotels at the destination in a swipeable carousel with photos, prices, and a Book Now button.' },
        { title: 'Seat Upgrade Offers', text: 'Offer seat upgrades and add-ons like extra baggage or meals, which travelers can buy with a single tap.' }
      ]
    },
    email: {
      title: 'Email e-tickets, invoices, and full itineraries, plus holiday offers and post-trip feedback requests to your past travelers.',
      desc: 'E-tickets, invoices, itineraries, holiday offers, and feedback requests sent by Email.',
      image: 'assets/ReTail X EMAIL.png',
      features: [
        { title: 'E-Tickets &amp; Invoices', text: 'Email e-tickets and invoices right after booking, so travelers have a clean record for work or personal use.' },
        { title: 'Full Itineraries', text: 'Send a complete trip itinerary with flights, hotels, transfers, and contact numbers, all in one email.' },
        { title: 'Feedback &amp; Holiday Offers', text: 'Ask for feedback after the trip, and send holiday offers to past travelers when they\'re ready to plan again.' }
      ]
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
