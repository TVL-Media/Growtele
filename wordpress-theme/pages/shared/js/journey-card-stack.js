/**
 * Journey section — mobile scroll stack + desktop wheel (product pages).
 */
(function () {
  function initJourneyCardStack(getScrollY, registerLayoutRefresh) {
    var section = document.querySelector(".journey");
    var wrap = document.querySelector(".journey__cards");
    var body = section && section.querySelector(".journey__body");
    if (!section || !wrap || !body) return;
    var cards = Array.prototype.slice.call(wrap.querySelectorAll(".journey-card"));
    if (cards.length < 2) return;

    var phones = Array.prototype.slice.call(section.querySelectorAll(".journey__phone"));
    var GAP = 12;
    var CARD_H = 172;
    var STEP = CARD_H + GAP;
    var maxProgress = cards.length - 1;
    var progress = 0;
    var activePhoneIndex = 0;

    function clearCardStackStyles() {
      cards.forEach(function (card) {
        card.style.transform = "";
        card.style.top = "";
        card.style.zIndex = "";
        card.style.position = "";
        card.style.left = "";
        card.style.width = "";
        card.style.height = "";
        card.style.minHeight = "";
      });
      wrap.style.height = "";
      wrap.style.overflow = "";
      section.classList.remove("journey--scroll-stack");
      section.style.paddingBottom = "";
    }

    function applyStack(value) {
      progress = Math.min(maxProgress, Math.max(0, value));
      cards.forEach(function (card, index) {
        var move = Math.min(index, progress) * STEP;
        card.style.transform = "translate3d(0," + (-move) + "px,0)";
        card.style.zIndex = String(index + 1);
      });

      if (phones.length) {
        var halfTrigger = CARD_H / (2 * STEP);
        var phoneIndex = 0;
        for (var i = 1; i < cards.length; i++) {
          if (progress >= i - halfTrigger) {
            phoneIndex = i;
          }
        }
        if (phoneIndex !== activePhoneIndex) {
          activePhoneIndex = phoneIndex;
          phones.forEach(function (phone, i) {
            phone.classList.toggle("is-active", i === phoneIndex);
          });
        }
      }
    }

    var mqMobile = window.matchMedia("(max-width: 1024px)");
    var isProductPage = document.body.classList.contains("sms-page");
    var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    if (mqMobile.matches) {
      if (!isProductPage || reduceMotion) {
        clearCardStackStyles();
        return;
      }

      var pinned = false;
      var pinScrollY = 0;
      var touchLastY = null;
      var gestureAccum = 0;
      var scrollIntentAccum = 0;
      var stackLatched = false;
      var inStackZonePrev = false;
      var lastScrollY = getScrollY();
      var stepLocked = false;
      var STEP_MS = 380;
      var GESTURE_THRESHOLD = 32;
      var STEP_SCROLL_DELTA = 2;
      var FAST_SCROLL_DELTA = 22;
      var fastScrolling = false;
      var fastScrollTimer = null;
      var freezeRaf = 0;
      var pendingFreezeY = null;
      var stackGestureActive = false;
      var scrollHandlerRaf = 0;
      var stackSessionActive = false;

      function noteFastScroll(delta) {
        if (Math.abs(delta) < FAST_SCROLL_DELTA) {
          return false;
        }
        if (stackSessionActive) {
          return false;
        }
        fastScrolling = true;
        releasePin();
        stackLatched = false;
        scrollIntentAccum = 0;
        gestureAccum = 0;
        window.clearTimeout(fastScrollTimer);
        fastScrollTimer = window.setTimeout(function () {
          fastScrolling = false;
        }, 240);
        return true;
      }

      function getStickyTop() {
        var root = getComputedStyle(document.documentElement);
        var header = parseFloat(root.getPropertyValue("--sms-mobile-header-h")) || 72;
        return header + 8;
      }

      function killLenisMomentum() {
        var lenis = window.growteleLenis;
        if (!lenis || typeof lenis.scrollTo !== "function") return;
        try {
          lenis.scrollTo(lenis.scroll, { immediate: true });
        } catch (err) {
          /* ignore */
        }
      }

      function freezeAt(y) {
        pinScrollY = y;
        pendingFreezeY = y;
        if (freezeRaf) {
          return;
        }
        freezeRaf = window.requestAnimationFrame(function () {
          freezeRaf = 0;
          var targetY = pendingFreezeY;
          pendingFreezeY = null;
          if (targetY === null || fastScrolling) {
            return;
          }
          var lenis = window.growteleLenis;
          if (lenis && typeof lenis.scrollTo === "function") {
            lenis.scrollTo(targetY, { immediate: true });
          } else {
            window.scrollTo(0, targetY);
          }
        });
      }

      function getPinScrollY() {
        var stickyTop = getStickyTop();
        var bodyRect = body.getBoundingClientRect();
        return Math.max(0, getScrollY() + (bodyRect.top - stickyTop));
      }

      /** Phone slot + card stack both in view — animation runs at this scroll position only */
      function isNearStackFrame() {
        var stickyTop = getStickyTop();
        var bodyRect = body.getBoundingClientRect();
        var wrapRect = wrap.getBoundingClientRect();
        var viewH = window.innerHeight;
        var bodyAligned =
          bodyRect.top <= stickyTop + 36 && bodyRect.top >= stickyTop - 120;
        var cardsVisible =
          wrapRect.top < viewH * 0.94 && wrapRect.bottom > viewH * 0.22;
        var phoneOk = true;
        if (phones.length) {
          var phoneEl = body.querySelector(".journey__phone--a") || phones[0];
          var phoneRect = phoneEl.getBoundingClientRect();
          phoneOk =
            phoneRect.bottom > stickyTop + 24 &&
            phoneRect.top < viewH * 0.78;
        }
        return sectionInView() && bodyAligned && cardsVisible && phoneOk;
      }

      function snapToStackFrame() {
        if (stackSessionActive) {
          freezeAt(pinScrollY);
          return;
        }
        stackSessionActive = true;
        stackLatched = true;
        pinned = true;
        pinScrollY = getPinScrollY();
        freezeAt(pinScrollY);
        killLenisMomentum();
        lastScrollY = pinScrollY;
      }

      function releaseStackSession() {
        stackSessionActive = false;
        pinned = false;
        gestureAccum = 0;
        scrollIntentAccum = 0;
        stackLatched = false;
      }

      function sectionInView() {
        var rect = section.getBoundingClientRect();
        return rect.top < window.innerHeight * 0.92 && rect.bottom > window.innerHeight * 0.08;
      }

      function isInStackZone() {
        if (!sectionInView()) return false;
        var viewH = window.innerHeight;
        var wrapRect = wrap.getBoundingClientRect();
        if (inStackZonePrev) {
          return wrapRect.top < viewH * 0.88 && wrapRect.bottom > viewH * 0.12;
        }
        return wrapRect.top < viewH * 0.82 && wrapRect.bottom > viewH * 0.18;
      }

      function shouldPinStack() {
        return isInStackZone() && progress > 0 && progress < maxProgress;
      }

      function isStackSessionActive() {
        if (!stackLatched || !isInStackZone()) return false;
        if (progress < maxProgress) return true;
        if (scrollIntentAccum > 0) return false;
        return pinned || stepLocked || scrollIntentAccum < 0;
      }

      function canRunStackSteps() {
        return stackSessionActive || isInStackZone() || isNearStackFrame();
      }

      function tryReverseStep() {
        if (stepLocked || !canRunStackSteps() || progress <= 0) return false;
        stackLatched = true;
        return tryStep(-1);
      }

      function tryForwardStep() {
        if (stepLocked || !canRunStackSteps() || progress >= maxProgress) return false;
        stackLatched = true;
        return tryStep(1);
      }

      function driveStackFromScroll(y, scrollDelta) {
        if (stepLocked || !isInStackZone()) return false;

        if (progress >= maxProgress && scrollDelta > STEP_SCROLL_DELTA) {
          stackLatched = false;
          pinned = false;
          return false;
        }

        if (progress > 0 && scrollDelta < -STEP_SCROLL_DELTA) {
          if (tryReverseStep()) {
            freezeAt(pinScrollY);
            killLenisMomentum();
            return true;
          }
        }

        if (progress > 0 && scrollDelta > STEP_SCROLL_DELTA && progress < maxProgress) {
          if (tryForwardStep()) {
            freezeAt(pinScrollY);
            killLenisMomentum();
            return true;
          }
        }

        return false;
      }

      function updateStackLatch(scrollDelta) {
        if (!stackSessionActive && !isNearStackFrame() && !isInStackZone()) {
          if (progress <= 0) {
            stackLatched = false;
            scrollIntentAccum = 0;
          }
          return;
        }
        if (progress === 0 && !stackSessionActive) {
          if (isNearStackFrame() && scrollDelta > 1.5) {
            stackLatched = true;
          } else if (scrollDelta < -1.5) {
            stackLatched = false;
            scrollIntentAccum = 0;
          }
          return;
        }
        if (progress >= maxProgress) {
          if (scrollDelta < -1.5) {
            stackLatched = true;
          } else if (scrollDelta > 1.5) {
            stackLatched = false;
            scrollIntentAccum = 0;
          }
          return;
        }
        stackLatched = true;
      }

      function shouldHoldGesture() {
        if (stepLocked && pinned) {
          return true;
        }
        if (!stackGestureActive || !isInStackZone()) {
          return false;
        }
        if (progress > 0 && progress < maxProgress) {
          return stackLatched;
        }
        return false;
      }

      function touchTargetInStack(event) {
        if (!event.touches || !event.touches[0]) {
          return false;
        }
        var touch = event.touches[0];
        var el = document.elementFromPoint(touch.clientX, touch.clientY);
        return !!(el && (body.contains(el) || wrap.contains(el)));
      }

      function consumeScrollIntent() {
        if (stepLocked || !stackLatched) return;
        if (!stackSessionActive && !canRunStackSteps()) return;
        if (progress >= maxProgress && scrollIntentAccum > 0) {
          scrollIntentAccum = 0;
          releaseStackSession();
          return;
        }
        while (Math.abs(scrollIntentAccum) >= GESTURE_THRESHOLD) {
          var dir = scrollIntentAccum > 0 ? 1 : -1;
          if (dir > 0 && progress >= maxProgress) {
            scrollIntentAccum = 0;
            releaseStackSession();
            break;
          }
          if (dir < 0 && progress <= 0) {
            scrollIntentAccum = 0;
            releaseStackSession();
            break;
          }
          scrollIntentAccum += dir > 0 ? -GESTURE_THRESHOLD : GESTURE_THRESHOLD;
          if (!tryStep(dir)) {
            break;
          }
        }
      }

      function engagePin(useStickyAlign) {
        pinned = true;
        if (useStickyAlign !== false) {
          pinScrollY = getPinScrollY();
          freezeAt(pinScrollY);
          killLenisMomentum();
        } else {
          pinScrollY = getScrollY();
        }
      }

      function releasePin() {
        releaseStackSession();
      }

      function resetIfOutOfView() {
        if (sectionInView()) return;
        if (progress <= 0 && !stackLatched && !pinned) return;
        progress = 0;
        pinned = false;
        gestureAccum = 0;
        scrollIntentAccum = 0;
        stackLatched = false;
        stepLocked = false;
        stackSessionActive = false;
        pinned = false;
        applyStack(0);
      }

      function tryStep(dir) {
        if (stepLocked || fastScrolling) return false;
        if (dir > 0 && progress >= maxProgress) {
          releaseStackSession();
          return false;
        }
        if (dir < 0 && progress <= 0) {
          releaseStackSession();
          return false;
        }
        if (!stackSessionActive) {
          if (!isNearStackFrame() && !isInStackZone()) {
            return false;
          }
          snapToStackFrame();
        }

        var current = Math.round(progress);
        var next = current + dir;
        if (next < 0 || next > maxProgress || next === current) return false;

        stackLatched = true;
        freezeAt(pinScrollY);
        killLenisMomentum();
        applyStack(next);

        stepLocked = true;
        window.setTimeout(function () {
          stepLocked = false;
        }, STEP_MS);
        return true;
      }

      function shouldHoldViewport() {
        return stepLocked;
      }

      function shouldBlockScroll() {
        return (stepLocked && pinned) || isStackSessionActive() || shouldPinStack();
      }

      function processGestureDelta(deltaY) {
        if (!sectionInView()) {
          releasePin();
          return false;
        }

        if (noteFastScroll(deltaY)) {
          return false;
        }

        if (fastScrolling) {
          return false;
        }

        if (
          !stackSessionActive &&
          progress <= 0 &&
          !isInStackZone() &&
          !isNearStackFrame()
        ) {
          return false;
        }

        if (stepLocked) {
          return true;
        }

        if (stackSessionActive && progress <= 0 && deltaY < 0) {
          releaseStackSession();
          gestureAccum = 0;
          return false;
        }

        gestureAccum += deltaY;

        if (stackSessionActive && progress <= 0 && gestureAccum < -GESTURE_THRESHOLD) {
          gestureAccum = 0;
          releaseStackSession();
          return false;
        }
        if (progress >= maxProgress && gestureAccum > GESTURE_THRESHOLD) {
          gestureAccum = 0;
          releaseStackSession();
          return false;
        }

        if (!stepLocked && Math.abs(deltaY) > STEP_SCROLL_DELTA && canRunStackSteps()) {
          if (deltaY < -STEP_SCROLL_DELTA && progress > 0 && tryReverseStep()) {
            return true;
          }
          if (deltaY > STEP_SCROLL_DELTA && progress < maxProgress && tryForwardStep()) {
            return true;
          }
          if (deltaY > STEP_SCROLL_DELTA && progress >= maxProgress) {
            releaseStackSession();
            return false;
          }
        }

        if (Math.abs(gestureAccum) < GESTURE_THRESHOLD) {
          return stepLocked;
        }

        var dir = gestureAccum > 0 ? 1 : -1;
        gestureAccum = 0;
        if (tryStep(dir)) {
          return true;
        }
        return stepLocked;
      }

      function onWheel(event) {
        resetIfOutOfView();
        var handled = processGestureDelta(event.deltaY);
        if (handled || stepLocked) {
          event.preventDefault();
          event.stopPropagation();
        }
      }

      function onTouchStart(event) {
        if (!event.touches || !event.touches[0]) return;
        stackGestureActive = true;
        touchLastY = event.touches[0].clientY;
        gestureAccum = 0;
      }

      function onTouchMove(event) {
        resetIfOutOfView();
        if (touchLastY === null || !event.touches || !event.touches[0]) return;
        if (!sectionInView() && !pinned && progress <= 0) {
          touchLastY = event.touches[0].clientY;
          return;
        }
        var y = event.touches[0].clientY;
        var delta = touchLastY - y;
        touchLastY = y;
        if (Math.abs(delta) < 0.5) return;
        var handled = processGestureDelta(delta);
        if (handled || stepLocked) {
          event.preventDefault();
          event.stopPropagation();
        }
      }

      function onTouchEnd() {
        touchLastY = null;
        stackGestureActive = false;
        if (!stepLocked) {
          gestureAccum = 0;
          if (progress <= 0 && pinned && !stackLatched) {
            releasePin();
          }
        }
      }

      function onScrollStackCore() {
        resetIfOutOfView();
        var y = getScrollY();
        var scrollDelta = y - lastScrollY;
        lastScrollY = y;

        if (noteFastScroll(scrollDelta) || fastScrolling) {
          inStackZonePrev = isInStackZone();
          return;
        }

        updateStackLatch(scrollDelta);

        var inZone = isInStackZone();
        var atFrame = isNearStackFrame();

        if (stepLocked || (stackSessionActive && pinned)) {
          if (Math.abs(y - pinScrollY) > 0.5) {
            freezeAt(pinScrollY);
            killLenisMomentum();
          }
        }

        if (stepLocked) {
          lastScrollY = pinScrollY;
          inStackZonePrev = inZone;
          return;
        }

        if (stackSessionActive && progress <= 0 && scrollDelta < -STEP_SCROLL_DELTA) {
          releaseStackSession();
          lastScrollY = y;
          inStackZonePrev = inZone;
          return;
        }

        if (stackSessionActive && pinned) {
          if (progress >= maxProgress && scrollDelta > STEP_SCROLL_DELTA) {
            releaseStackSession();
            lastScrollY = y;
            inStackZonePrev = inZone;
            return;
          }
          lastScrollY = pinScrollY;
          inStackZonePrev = inZone;
          return;
        }

        if (
          !stackSessionActive &&
          !stepLocked &&
          !fastScrolling &&
          inZone &&
          stackLatched
        ) {
          scrollIntentAccum += scrollDelta;
          consumeScrollIntent();
        }

        if (!inZone && !atFrame) {
          if (progress <= 0) {
            releaseStackSession();
          }
        }

        lastScrollY = y;
        inStackZonePrev = inZone;
      }

      function onScrollStack() {
        if (scrollHandlerRaf) {
          return;
        }
        scrollHandlerRaf = window.requestAnimationFrame(function () {
          scrollHandlerRaf = 0;
          onScrollStackCore();
        });
      }

      var mobileLayoutReady = false;
      var cachedMobileCardH = 0;

      function measureMobileLayout() {
        CARD_H = 172;
        if (section.classList.contains("journey--scroll-stack") && mobileLayoutReady) {
          cards.forEach(function (card) {
            CARD_H = Math.max(CARD_H, card.offsetHeight || 0);
          });
          if (Math.abs(CARD_H - cachedMobileCardH) < 4) {
            applyStack(progress);
            return;
          }
        }

        cards.forEach(function (card) {
          card.style.position = "static";
          card.style.top = "";
          card.style.height = "";
          card.style.minHeight = "";
        });
        wrap.style.height = "auto";

        CARD_H = 172;
        cards.forEach(function (card) {
          CARD_H = Math.max(CARD_H, card.offsetHeight || 0);
        });
        cachedMobileCardH = CARD_H;
        mobileLayoutReady = true;
        STEP = CARD_H + GAP;
        section.style.paddingBottom = "";

        cards.forEach(function (card, index) {
          card.style.position = "absolute";
          card.style.left = "0";
          card.style.width = "100%";
          card.style.height = CARD_H + "px";
          card.style.minHeight = CARD_H + "px";
          card.style.top = index * STEP + "px";
          card.style.zIndex = String(index + 1);
        });
        wrap.style.height = CARD_H + "px";
        wrap.style.overflow = "hidden";
        section.classList.add("journey--scroll-stack");
        applyStack(progress);
        if (stackSessionActive) {
          pinScrollY = getPinScrollY();
          freezeAt(pinScrollY);
        }
      }

      function teardownMobileStack() {
        clearCardStackStyles();
        stackSessionActive = false;
        pinned = false;
        window.removeEventListener("wheel", onWheel, true);
        section.removeEventListener("touchstart", onTouchStart, true);
        section.removeEventListener("touchmove", onTouchMove, true);
        section.removeEventListener("touchend", onTouchEnd, true);
        window.removeEventListener("scroll", onScrollStack);
        window.removeEventListener("growtele:scroll", onScrollStack);
      }

      registerLayoutRefresh(measureMobileLayout);
      window.addEventListener("wheel", onWheel, { passive: false, capture: true });
      section.addEventListener("touchstart", onTouchStart, { passive: true, capture: true });
      section.addEventListener("touchmove", onTouchMove, { passive: false, capture: true });
      section.addEventListener("touchend", onTouchEnd, { passive: true, capture: true });
      window.addEventListener("scroll", onScrollStack, { passive: true });
      window.addEventListener("growtele:scroll", onScrollStack, { passive: true });

      mqMobile.addEventListener("change", function (event) {
        if (!event.matches) teardownMobileStack();
      });

      measureMobileLayout();
      lastScrollY = getScrollY();
      return;
    }

    clearCardStackStyles();

    var pinned = false;
    var pinScrollY = 0;

    function freezeAt(y) {
      pinScrollY = y;
      var lenis = window.growteleLenis;
      if (lenis && typeof lenis.scrollTo === "function") {
        lenis.scrollTo(y, { immediate: true });
      } else {
        window.scrollTo(0, y);
      }
    }

    function measureLayout() {
      CARD_H = cards[0] ? cards[0].offsetHeight : 172;
      STEP = CARD_H + GAP;
      cards.forEach(function (card, index) {
        card.style.top = index * STEP + "px";
        card.style.zIndex = String(index + 1);
        card.style.transform = "translate3d(0,0,0)";
      });
      applyStack(progress);
    }

    /* Only interact while journey is actually in the viewport */
    function sectionInView() {
      var rect = section.getBoundingClientRect();
      return rect.top < window.innerHeight * 0.75 && rect.bottom > window.innerHeight * 0.2;
    }

    function isAtPinLevel() {
      var viewH = window.innerHeight;
      var secRect = section.getBoundingClientRect();
      var bodyRect = body.getBoundingClientRect();
      var first = cards[0].getBoundingClientRect();
      /* Check only first 3 cards — the last card stacks behind and may extend below viewport */
      var checkIndex = Math.min(cards.length - 1, 2);
      var last = cards[checkIndex].getBoundingClientRect();
      var sectionH = section.offsetHeight || 1;
      var designBodyTop = secRect.top + sectionH * (180 / 1000);
      var bodyTolerance = Math.max(48, viewH * 0.07);
      var bodyAligned = Math.abs(bodyRect.top - designBodyTop) <= bodyTolerance || (
        bodyRect.top >= viewH * 0.08 &&
        bodyRect.top <= viewH * 0.32
      );
      var cardTopMin = Math.max(56, viewH * 0.09);
      var cardBottomMax = viewH + Math.max(20, viewH * 0.04);
      var cardsInView = first.top >= cardTopMin && last.bottom <= cardBottomMax;
      var sectionVisible = secRect.top <= viewH * 0.28 && secRect.bottom >= viewH * 0.52;

      return bodyAligned && cardsInView && sectionVisible;
    }

    function onWheel(event) {
      /* Never hijack scroll when user is above/below this section */
      if (!sectionInView()) {
        pinned = false;
        return;
      }

      var goingDown = event.deltaY > 0;
      var goingUp = event.deltaY < 0;
      var step = Math.min(0.35, Math.abs(event.deltaY) / 420);
      var atLevel = isAtPinLevel();

      if (!pinned && atLevel && goingDown && progress <= 0) {
        pinned = true;
        freezeAt(getScrollY());
        event.preventDefault();
        event.stopPropagation();
        applyStack(step);
        return;
      }

      /* Only drive the stack while pinned or parked at the pin level */
      if (!pinned && !atLevel) return;

      if (goingDown && progress < maxProgress) {
        pinned = true;
        event.preventDefault();
        event.stopPropagation();
        freezeAt(pinScrollY || getScrollY());
        applyStack(progress + step);
        return;
      }

      if (goingUp && progress > 0) {
        pinned = true;
        event.preventDefault();
        event.stopPropagation();
        freezeAt(pinScrollY || getScrollY());
        applyStack(progress - step);
        if (progress <= 0) pinned = false;
        return;
      }

      if (goingDown && progress >= maxProgress) {
        pinned = false;
      }

      if (goingUp && progress <= 0) {
        pinned = false;
      }
    }

    registerLayoutRefresh(measureLayout);
    window.addEventListener("wheel", onWheel, { passive: false, capture: true });
    measureLayout();
  }

  window.growteleInitJourneyCardStack = initJourneyCardStack;
})();
