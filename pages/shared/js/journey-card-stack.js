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

    var titleEl = section.querySelector(".journey__title");
    var phones = Array.prototype.slice.call(section.querySelectorAll(".journey__phone"));
    var GAP = 12;
    var CARD_H = 172;
    var STEP = CARD_H + GAP;
    var maxProgress = cards.length - 1;
    var progress = 0;
    var activePhoneIndex = 0;
    var mobLockedCardH = 0;
    var mobLockedStep = 0;
    var mobLockedWrapH = 0;
    var mobLockedSectionMinH = 0;
    var mobLockedBodyShellH = 0;
    var mobBodyMinSet = false;
    var mobAnimProgress = null;
    var mobAnimTarget = 0;
    var mobAnimRaf = 0;
    var mobPinInertiaV = 0;
    var mobChainScrubLatched = false;
    var mobScrubScrollYSnap = 0;
    var mobScrubScrollDir = 0;
    var mobScrollVelEma = 0;
    var mobApplyPaintCache = {
      active: false,
      transforms: [],
      wrapH: "",
      wrapOverflow: "",
      cardH: 0,
      cssVarCardH: "",
      secMin: "",
      bodyMin: "",
      chainScrub: null,
    };

    function mobResetApplyPaintCache() {
      mobApplyPaintCache.active = false;
      mobApplyPaintCache.transforms = [];
      mobApplyPaintCache.wrapH = "";
      mobApplyPaintCache.wrapOverflow = "";
      mobApplyPaintCache.cardH = 0;
      mobApplyPaintCache.cssVarCardH = "";
      mobApplyPaintCache.secMin = "";
      mobApplyPaintCache.bodyMin = "";
      mobApplyPaintCache.chainScrub = null;
      mobChainScrubLatched = false;
    }

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
      section.classList.remove("journey--stack-idle");
      section.style.paddingBottom = "";
    }

    var mqMobile = window.matchMedia("(max-width: 1024px)");
    var isProductPage = document.body.classList.contains("sms-page");
    /* Scroll-scrubbed stack (no scrollTo pin) for every mobile browser: the
       legacy pin path snapped window scroll back each frame and vibrated. */
    var mobAndroidStable = true;

    function journeyDebugOn() {
      return /(?:^|[?&])journeyDebug=1(?:&|$)/.test(
        window.location.search || ""
      );
    }

    function jdbgEnabled() {
      if (!mobAndroidStable) {
        return false;
      }
      if (journeyDebugOn()) {
        return true;
      }
      var tr = window.__growteleJourneyTrace;
      return !!(tr && tr.enabled && tr.recording);
    }

    function jdbg(hypothesisId, location, message, data) {
      if (!jdbgEnabled()) {
        return;
      }
      var payload = {
        sessionId: "c2b221",
        runId: "post-fix",
        hypothesisId: hypothesisId,
        location: location,
        message: message,
        data: data || {},
        timestamp: Date.now(),
      };
      // #region agent log
      fetch(
        "http://127.0.0.1:7762/ingest/dda70681-3b84-498a-b146-024aecdabea7",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Debug-Session-Id": "c2b221",
          },
          body: JSON.stringify(payload),
        }
      ).catch(function () {});
      // #endregion
      try {
        window.__growteleJourneyDebugBuffer =
          window.__growteleJourneyDebugBuffer || [];
        window.__growteleJourneyDebugBuffer.push(payload);
        if (window.__growteleJourneyDebugBuffer.length > 400) {
          window.__growteleJourneyDebugBuffer.shift();
        }
      } catch (ignore) {}
    }

    function applyStack(value) {
      if (typeof value === "number") {
        progress = Math.min(maxProgress, Math.max(0, value));
      }
      if (section.classList.contains("journey--stack-idle")) {
        return;
      }
      if (
        mqMobile.matches &&
        isProductPage &&
        section.classList.contains("journey--scroll-stack") &&
        mobLockedCardH > 0
      ) {
        CARD_H = mobLockedCardH;
        STEP = mobLockedStep;
      }
      var renderP = progress;
      if (
        mqMobile.matches &&
        isProductPage &&
        mobAnimProgress !== null &&
        section.classList.contains("journey--mob-pinned")
      ) {
        renderP = mobAnimProgress;
      }
      var useApplyPaintCache =
        mqMobile.matches &&
        isProductPage &&
        mobAndroidStable &&
        section.classList.contains("journey--scroll-stack") &&
        !section.classList.contains("journey--stack-idle");
      if (useApplyPaintCache) {
        mobApplyPaintCache.active = true;
      }
      cards.forEach(function (card, index) {
        var move = Math.min(index, renderP) * STEP;
        var androidScrubPaint =
          useApplyPaintCache && mobAndroidStable;
        if (mqMobile.matches && isProductPage && !androidScrubPaint) {
          move = Math.round(move);
        } else if (androidScrubPaint) {
          move = Math.round(move * 100) / 100;
        }
        var tf = "translate3d(0," + -move + "px,0)";
        if (useApplyPaintCache) {
          if (mobApplyPaintCache.transforms[index] !== tf) {
            card.style.transform = tf;
            mobApplyPaintCache.transforms[index] = tf;
          }
        } else {
          card.style.transform = tf;
        }
        var zStr = String(index + 1);
        if (!useApplyPaintCache || card.style.zIndex !== zStr) {
          card.style.zIndex = zStr;
        }
      });

        if (
          jdbgEnabled() &&
          section.classList.contains("journey--scroll-stack") &&
          !section.classList.contains("journey--stack-idle")
        ) {
        var jStateApply = window.__growteleJdbg || {};
        jStateApply.applyInCore = (jStateApply.applyInCore || 0) + 1;
        if (jStateApply.applyInCore > 1) {
          jdbg(
            "B",
            "journey-card-stack.js:applyStack",
            "multiApplyStackSameScrollCore",
            {
              count: jStateApply.applyInCore,
              coreGen: jStateApply.coreGen,
              progress: progress,
              renderP: renderP,
              writer:
                window.__growteleJourneyTrace &&
                window.__growteleJourneyTrace.pendingWriter
                  ? window.__growteleJourneyTrace.pendingWriter
                  : "",
            }
          );
        }
        var move1Dbg = Math.round(Math.min(1, renderP) * STEP);
        if (
          jStateApply.lastCard1Move != null &&
          Math.abs(move1Dbg - jStateApply.lastCard1Move) === 1 &&
          Math.abs(progress - (jStateApply.lastApplyProgress || 0)) < 0.12
        ) {
          jdbg(
            "D",
            "journey-card-stack.js:applyStack",
            "card1Transform1pxOscillation",
            {
              prevMove: jStateApply.lastCard1Move,
              move: move1Dbg,
              progress: progress,
              renderP: renderP,
              fastFlag: !!jStateApply.fastScrolling,
            }
          );
        }
        jStateApply.lastCard1Move = move1Dbg;
        jStateApply.lastApplyProgress = progress;
        window.__growteleJdbg = jStateApply;
      }

      if (
        mqMobile.matches &&
        isProductPage &&
        section.classList.contains("journey--scroll-stack") &&
        maxProgress > 0
      ) {
        var wrapH =
          mobLockedWrapH > 0
            ? mobLockedWrapH
            : CARD_H + maxProgress * STEP;
        var wrapHStr = wrapH + "px";
        if (useApplyPaintCache) {
          if (mobApplyPaintCache.wrapH !== wrapHStr) {
            wrap.style.height = wrapHStr;
            mobApplyPaintCache.wrapH = wrapHStr;
          }
          if (mobApplyPaintCache.wrapOverflow !== "hidden") {
            wrap.style.overflow = "hidden";
            mobApplyPaintCache.wrapOverflow = "hidden";
          }
        } else {
          wrap.style.height = wrapHStr;
          wrap.style.overflow = "hidden";
        }
        if (mobLockedCardH > 0) {
          var cardHVar = mobLockedCardH + "px";
          if (
            !useApplyPaintCache ||
            mobApplyPaintCache.cardH !== mobLockedCardH
          ) {
            if (
              !useApplyPaintCache ||
              mobApplyPaintCache.cssVarCardH !== cardHVar
            ) {
              section.style.setProperty("--journey-mob-card-h", cardHVar);
              mobApplyPaintCache.cssVarCardH = cardHVar;
            }
            cards.forEach(function (card) {
              card.style.height = cardHVar;
              card.style.minHeight = cardHVar;
              card.style.maxHeight = cardHVar;
            });
            mobApplyPaintCache.cardH = mobLockedCardH;
          }
        }
        if (!(mobPinActive && stackSessionActive)) {
          if (!mobBodyMinSet) {
            mobBodyMinSet = true;
          }
          if (mobAndroidStackShellFrozen()) {
            var secMinStr = mobLockedSectionMinH + "px";
            if (
              !useApplyPaintCache ||
              mobApplyPaintCache.secMin !== secMinStr
            ) {
              section.style.minHeight = secMinStr;
              mobApplyPaintCache.secMin = secMinStr;
            }
            if (mobLockedBodyShellH > 0) {
              var bodyMinStr = mobLockedBodyShellH + "px";
              if (
                !useApplyPaintCache ||
                mobApplyPaintCache.bodyMin !== bodyMinStr
              ) {
                body.style.minHeight = bodyMinStr;
                mobApplyPaintCache.bodyMin = bodyMinStr;
              }
            }
          } else if (
            !(
              mobAndroidStable &&
              section.classList.contains("journey--scroll-stack") &&
              !section.classList.contains("journey--stack-idle") &&
              mobLockedSectionMinH <= 0
            )
          ) {
            applyMobSectionShell(true);
          }
        }
        var chainScrubOn =
          progress > 0.001 && progress < maxProgress - 0.001;
        if (mobAndroidStable && useApplyPaintCache) {
          if (mobChainScrubLatched) {
            if (progress < 0.006 || progress >= maxProgress - 0.006) {
              mobChainScrubLatched = false;
            }
          } else if (
            progress > 0.028 &&
            progress < maxProgress - 0.028
          ) {
            mobChainScrubLatched = true;
          }
          chainScrubOn = mobChainScrubLatched;
        }
        if (
          !useApplyPaintCache ||
          mobApplyPaintCache.chainScrub !== chainScrubOn
        ) {
          section.classList.toggle("journey--mob-chain-scrub", chainScrubOn);
          mobApplyPaintCache.chainScrub = chainScrubOn;
        }
      }

      if (phones.length) {
        var phoneIndex = 0;
        if (
          mqMobile.matches &&
          isProductPage &&
          (section.classList.contains("journey--mob-pinned") ||
            (mobAndroidStable &&
              section.classList.contains("journey--scroll-stack") &&
              !section.classList.contains("journey--stack-idle")))
        ) {
          var phoneCandidate = Math.min(
            phones.length - 1,
            Math.max(0, Math.round(renderP))
          );
          if (mobAndroidStable) {
            phoneIndex = activePhoneIndex;
            if (mobScrollVelEma <= 4.5) {
              if (phoneCandidate > activePhoneIndex) {
                if (
                  renderP >= activePhoneIndex + 0.42 &&
                  mobScrubScrollDir >= 0
                ) {
                  phoneIndex = phoneCandidate;
                }
              } else if (phoneCandidate < activePhoneIndex) {
                if (
                  renderP <= activePhoneIndex - 0.42 &&
                  mobScrubScrollDir <= 0
                ) {
                  phoneIndex = phoneCandidate;
                }
              } else {
                phoneIndex = phoneCandidate;
              }
            }
            if (
              jdbgEnabled() &&
              phoneIndex !== activePhoneIndex &&
              Math.abs(renderP - activePhoneIndex) < 0.2
            ) {
              jdbg(
                "D",
                "journey-card-stack.js:applyStack",
                "phoneIndexHysteresisBlock",
                {
                  renderP: renderP,
                  activePhoneIndex: activePhoneIndex,
                  candidate: phoneCandidate,
                  chosen: phoneIndex,
                }
              );
            }
          } else {
            phoneIndex = phoneCandidate;
          }
        } else {
          var halfTrigger = CARD_H / (2 * STEP);
          for (var i = 1; i < cards.length; i++) {
            if (renderP >= i - halfTrigger) {
              phoneIndex = i;
            }
          }
        }
        if (phoneIndex !== activePhoneIndex) {
          activePhoneIndex = phoneIndex;
          phones.forEach(function (phone, i) {
            phone.classList.toggle("is-active", i === phoneIndex);
          });
        }
      }

      if (
        window.__growteleJourneyTrace &&
        window.__growteleJourneyTrace.enabled &&
        mobAndroidStable &&
        mqMobile.matches &&
        isProductPage
      ) {
        var trApply = window.__growteleJourneyTrace;
        var card0Tf = cards[0] ? cards[0].style.transform || "" : "";
        trApply.lastApply = {
          t: Math.round(performance.now()),
          writer: trApply.pendingWriter || "applyStack",
          progress: progress,
          renderP: renderP,
          phone: activePhoneIndex,
          card0Transform: card0Tf,
          idle: section.classList.contains("journey--stack-idle"),
        };
        if (trApply.recording && trApply.currentFrame) {
          if (!trApply.currentFrame.applyStackCalls) {
            trApply.currentFrame.applyStackCalls = [];
          }
          trApply.currentFrame.applyStackCalls.push({
            writer: trApply.pendingWriter || "applyStack",
            progress: progress,
            renderP: renderP,
          });
        }
        trApply.pendingWriter = "";
      }
    }

    var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    if (mqMobile.matches) {
      if (!isProductPage || reduceMotion) {
        clearCardStackStyles();
        return;
      }

      /*
       * Mobile: the section sticks at one fixed spot inside a scroll runway and
       * the cards stack / unstack in proportion to native scroll through that
       * runway. No scrollTo, no touch or wheel interception, so it cannot
       * fight the browser's scrolling, and scrolling up reverses it exactly.
       */
      var mobBody = section.querySelector(".journey__body");
      var mobHeader = document.querySelector(".header");
      var runway = document.createElement("div");
      runway.className = "journey-pin-runway";
      section.parentNode.insertBefore(runway, section);
      runway.appendChild(section);

      var mobSpan = 0;
      var mobStickTop = 0;
      var mobLayoutW = 0;
      var mobRaf = 0;
      var mobLastP = -1;

      function clearMobileStackInline() {
        cards.forEach(function (card) {
          card.style.top = "";
          card.style.transform = "";
          card.style.zIndex = "";
        });
        wrap.style.height = "";
        runway.style.height = "";
        section.style.top = "";
        [
          "--journey-mob-card-h",
          "--journey-mob-cards-w",
          "--journey-mob-cards-left",
          "--journey-mob-shell-h",
        ].forEach(function (name) {
          section.style.removeProperty(name);
        });
      }

      function renderMobileStack() {
        mobRaf = 0;
        var traveled = mobStickTop - runway.getBoundingClientRect().top;
        var p =
          mobSpan > 0
            ? Math.min(1, Math.max(0, traveled / mobSpan)) * maxProgress
            : 0;
        p = Math.round(p * 1000) / 1000;
        if (p === mobLastP) {
          return;
        }
        mobLastP = p;
        progress = p;
        cards.forEach(function (card, index) {
          var move = Math.round(Math.min(index, p) * STEP * 100) / 100;
          card.style.transform = "translate3d(0," + -move + "px,0)";
        });
        if (phones.length) {
          var phoneIndex = Math.min(phones.length - 1, Math.round(p));
          if (phoneIndex !== activePhoneIndex) {
            activePhoneIndex = phoneIndex;
            phones.forEach(function (phone, i) {
              phone.classList.toggle("is-active", i === phoneIndex);
            });
          }
        }
      }

      function layoutMobileStack() {
        /* Measure the natural (idle) layout, then lock it into the stack layout */
        clearMobileStackInline();
        section.classList.remove("journey--mob-android-stack", "journey--mob-sticky");
        section.classList.add("journey--scroll-stack", "journey--stack-idle");
        var phoneH = Math.round(Math.min(Math.max(window.innerWidth * 0.48, 220), 300));
        section.style.setProperty("--journey-mob-phone-h", phoneH + "px");

        CARD_H = 0;
        cards.forEach(function (card) {
          CARD_H = Math.max(CARD_H, Math.round(card.getBoundingClientRect().height));
        });
        STEP = CARD_H + GAP;
        var bodyRect = mobBody.getBoundingClientRect();
        var wrapRect = wrap.getBoundingClientRect();
        var stackH = CARD_H + maxProgress * STEP;
        section.style.setProperty("--journey-mob-cards-w", Math.round(wrapRect.width) + "px");
        section.style.setProperty(
          "--journey-mob-cards-left",
          Math.max(0, Math.round(wrapRect.left - bodyRect.left)) + "px"
        );
        section.style.setProperty("--journey-mob-card-h", CARD_H + "px");
        section.style.setProperty("--journey-mob-shell-h", Math.max(phoneH, stackH) + "px");

        section.classList.remove("journey--stack-idle");
        section.classList.add("journey--mob-android-stack", "journey--mob-sticky");
        wrap.style.height = stackH + "px";
        cards.forEach(function (card, index) {
          card.style.top = index * STEP + "px";
          card.style.zIndex = String(index + 1);
        });

        /* One fixed spot: directly below the fixed header */
        mobLayoutW = window.innerWidth;
        var vh = window.innerHeight;
        var headerH = 0;
        if (mobHeader && getComputedStyle(mobHeader).position === "fixed") {
          headerH = Math.max(0, mobHeader.getBoundingClientRect().bottom);
        }
        var secH = section.offsetHeight;
        var avail = vh - headerH;
        mobStickTop = Math.round(secH <= avail ? headerH : vh - secH);
        section.style.top = mobStickTop + "px";
        mobSpan = Math.max(STEP, Math.round(vh * 0.28)) * maxProgress;
        runway.style.height = secH + mobSpan + "px";

        mobLastP = -1;
        renderMobileStack();
      }

      function onMobileStackScroll() {
        if (!mobRaf) {
          mobRaf = window.requestAnimationFrame(renderMobileStack);
        }
      }

      function refreshMobileStack() {
        /* Height-only changes are the mobile URL bar; keep the layout stable */
        if (window.innerWidth !== mobLayoutW) {
          layoutMobileStack();
        } else {
          onMobileStackScroll();
        }
      }

      function teardownMobileStack() {
        window.removeEventListener("scroll", onMobileStackScroll);
        window.removeEventListener("resize", refreshMobileStack);
        if (mobRaf) {
          window.cancelAnimationFrame(mobRaf);
          mobRaf = 0;
        }
        clearMobileStackInline();
        section.style.removeProperty("--journey-mob-phone-h");
        section.classList.remove("journey--mob-android-stack", "journey--mob-sticky");
        clearCardStackStyles();
        if (runway.parentNode) {
          runway.parentNode.insertBefore(section, runway);
          runway.parentNode.removeChild(runway);
        }
      }

      layoutMobileStack();
      registerLayoutRefresh(refreshMobileStack);
      window.addEventListener("scroll", onMobileStackScroll, { passive: true });
      window.addEventListener("resize", refreshMobileStack, { passive: true });
      window.addEventListener("load", layoutMobileStack);
      if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(layoutMobileStack);
      }
      mqMobile.addEventListener("change", function (event) {
        if (!event.matches) teardownMobileStack();
      });
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
