(function () {
  var nav = document.querySelector(".nav");
  var toggle = document.querySelector(".nav-toggle");
  var funnelVisual = document.getElementById("funnelVisual");

  var funnelImages = {
    acquisition: { src: "https://listings.selectvia.com/wp-content/uploads/2026/09/Eng-2.png", alt: "Acquisition campaign flow" },
    engagement: { src: "https://listings.selectvia.com/wp-content/uploads/2026/09/Eng-1-3.png", alt: "Engagement campaign flow" },
    retention: { src: "https://listings.selectvia.com/wp-content/uploads/2026/09/Eng-2-1.png", alt: "Retention campaign flow" }
  };
  if (window.GROWTELE_CMS_FUNNEL) {
    Object.keys(window.GROWTELE_CMS_FUNNEL).forEach(function (key) {
      funnelImages[key] = Object.assign({}, funnelImages[key] || {}, window.GROWTELE_CMS_FUNNEL[key]);
    });
  }

  Object.keys(funnelImages).forEach(function (key) {
    var preload = new Image();
    var src = funnelImages[key].src;
    preload.src = window.growteleResolveAssetUrl
      ? window.growteleResolveAssetUrl(src, funnelVisual)
      : src;
  });

  function getScrollY() {
    if (window.growteleLenis && typeof window.growteleLenis.scroll === "number") {
      return window.growteleLenis.scroll;
    }
    return window.scrollY || window.pageYOffset || 0;
  }

  function closeNav() {
    if (!nav || !toggle) return;
    nav.classList.remove("is-open");
    toggle.setAttribute("aria-expanded", "false");
    document.body.classList.remove("gt-nav-open");
  }

  function isDropdownTrigger(link) {
    return (
      link.hasAttribute("data-mega-trigger") ||
      link.hasAttribute("data-industry-solutions-trigger") ||
      link.hasAttribute("data-company-trigger")
    );
  }

  document.querySelectorAll(".journey__tab").forEach(function (tab) {
    tab.addEventListener("click", function () {
      document.querySelectorAll(".journey__tab").forEach(function (item) {
        item.classList.remove("is-active");
        item.setAttribute("aria-selected", "false");
      });
      tab.classList.add("is-active");
      tab.setAttribute("aria-selected", "true");
    });
  });

  document.querySelectorAll(".funnel__tab").forEach(function (tab) {
    tab.addEventListener("click", function () {
      var panel = document.querySelector(".funnel__panel");
      document.querySelectorAll(".funnel__tab").forEach(function (item) {
        item.classList.remove("is-active");
        item.setAttribute("aria-selected", "false");
      });
      tab.classList.add("is-active");
      tab.setAttribute("aria-selected", "true");
      var key = tab.getAttribute("data-funnel");
      if (panel) {
        panel.classList.toggle("funnel__panel--acquisition", key === "acquisition");
        panel.classList.toggle("funnel__panel--engagement", key === "engagement");
        panel.classList.toggle("funnel__panel--retention", key === "retention");
      }
      if (funnelVisual && funnelImages[key]) {
        if (window.growteleApplyAssetSrc) {
          window.growteleApplyAssetSrc(funnelVisual, funnelImages[key].src);
        } else {
          funnelVisual.src = window.growteleResolveAssetUrl
            ? window.growteleResolveAssetUrl(funnelImages[key].src, funnelVisual)
            : funnelImages[key].src;
        }
        funnelVisual.alt = funnelImages[key].alt;
      }
      document.querySelectorAll("[data-funnel-list]").forEach(function (list) {
        if (list.getAttribute("data-funnel-list") === key) {
          list.removeAttribute("hidden");
        } else {
          list.setAttribute("hidden", "");
        }
      });
    });
  });

  /* Mobile nav toggle — handled by assets/js/mobile-nav.js */

  var layoutRefreshCallbacks = [];

  function registerLayoutRefresh(callback) {
    layoutRefreshCallbacks.push(callback);
  }

  function refreshScroll() {
    if (window.growteleLenis && typeof window.growteleLenis.resize === "function") {
      window.growteleLenis.resize();
    }
    layoutRefreshCallbacks.forEach(function (callback) {
      callback();
    });
    window.dispatchEvent(new Event("growtele:layout-refresh"));
  }

  window.addEventListener("resize", refreshScroll);
  /* visualViewport resize fires on every mobile browser-chrome toggle and causes scroll jank */
  if (window.visualViewport && !window.matchMedia("(max-width: 1024px)").matches) {
    window.visualViewport.addEventListener("resize", refreshScroll);
  }
  window.addEventListener("growtele:smooth-scroll-ready", refreshScroll);
  window.addEventListener("load", refreshScroll);

  /* Journey cards — pin only while section is on screen, then stack on scroll */
  (function initJourneyCardStack() {
    var section = document.querySelector(".journey");
    var wrap = document.querySelector(".journey__cards");
    var body = section && section.querySelector(".journey__body");
    if (!section || !wrap || !body) return;
    var cards = Array.prototype.slice.call(wrap.querySelectorAll(".journey-card"));
    if (cards.length < 2) return;

    if (window.matchMedia("(max-width: 1024px)").matches) {
      cards.forEach(function (card) {
        card.style.transform = "";
        card.style.top = "";
        card.style.zIndex = "";
      });
      return;
    }

    var phones = Array.prototype.slice.call(section.querySelectorAll(".journey__phone"));

    var GAP = 12;
    var CARD_H = 172;
    var STEP = CARD_H + GAP;
    var maxProgress = cards.length - 1;
    var progress = 0;
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
        phones.forEach(function (phone, i) {
          phone.classList.toggle("is-active", i === phoneIndex);
        });
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
      var last = cards[cards.length - 1].getBoundingClientRect();
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
  })();

  /* Scale cards — auto-rotate every 3s; hover pauses on hovered card */
  (function initScaleHoverCards() {
    var grid = document.querySelector("[data-scale-grid]");
    if (!grid) return;
    var cards = Array.prototype.slice.call(grid.querySelectorAll("[data-scale-card]"));
    if (!cards.length) return;

    /* Mobile: static stacked cards — no autoplay */
    if (window.matchMedia("(max-width: 768px)").matches) {
      cards.forEach(function (item) {
        item.classList.remove("is-active");
      });
      grid.classList.remove("has-active");
      return;
    }

    var activeIndex = 0;
    var intervalId = null;
    var hovered = false;
    var transitionTimers = [];
    var ROTATE_MS = 3000;
    var TRANSITION_MS = 900;

    function clearCardPointerLock() {
      transitionTimers.forEach(function (timerId) {
        window.clearTimeout(timerId);
      });
      transitionTimers = [];
      cards.forEach(function (item) {
        item.style.pointerEvents = "";
      });
    }

    function lockPreviousCardDuringTransition(previousIndex) {
      var prevCard = cards[previousIndex];
      if (!prevCard) {
        return;
      }
      prevCard.style.pointerEvents = "none";
      var timerId = window.setTimeout(function () {
        prevCard.style.pointerEvents = "";
        transitionTimers = transitionTimers.filter(function (id) {
          return id !== timerId;
        });
      }, TRANSITION_MS);
      transitionTimers.push(timerId);
    }

    function setActiveIndex(index) {
      var previousIndex = activeIndex;
      activeIndex = ((index % cards.length) + cards.length) % cards.length;
      cards.forEach(function (item, i) {
        item.classList.toggle("is-active", i === activeIndex);
      });
      grid.classList.add("has-active");
      if (hovered && previousIndex !== activeIndex) {
        lockPreviousCardDuringTransition(previousIndex);
      }
    }

    function startAutoplay() {
      if (intervalId !== null) {
        window.clearInterval(intervalId);
      }
      intervalId = window.setInterval(function () {
        if (!hovered) {
          setActiveIndex(activeIndex + 1);
        }
      }, ROTATE_MS);
    }

    function stopAutoplay() {
      if (intervalId !== null) {
        window.clearInterval(intervalId);
        intervalId = null;
      }
    }

    cards.forEach(function (card, index) {
      card.addEventListener("mouseenter", function () {
        hovered = true;
        stopAutoplay();
        setActiveIndex(index);
      });
    });

    grid.addEventListener("mouseleave", function () {
      hovered = false;
      clearCardPointerLock();
      startAutoplay();
    });

    setActiveIndex(0);
    startAutoplay();
  })();

  /* Benefits — click highlights icon + content; first active by default */
  (function initBenefitsSwitch() {
    var grid = document.querySelector("[data-benefits-grid]");
    var visual = document.getElementById("benefitsVisual");
    if (!grid || !visual) return;
    var cards = Array.prototype.slice.call(grid.querySelectorAll("[data-benefit]"));
    if (!cards.length) return;

    function activate(card) {
      cards.forEach(function (item) {
        item.classList.toggle("is-active", item === card);
      });
      var imgSrc = card.getAttribute("data-benefit-img") || "https://listings.selectvia.com/wp-content/uploads/2026/09/e6f1e938ecf0adfbc22076c112e0031b884df6e9.png";
      if (window.growteleResolveAssetUrl) {
        imgSrc = window.growteleResolveAssetUrl(imgSrc, visual);
      }
      var heading = card.querySelector("h3");
      var label = heading ? heading.textContent.replace(/\s+/g, " ").trim() : "Benefits dashboard";
      visual.style.backgroundImage = 'url("' + imgSrc + '")';
      visual.setAttribute("aria-label", label);
    }

    cards.forEach(function (card) {
      card.addEventListener("click", function () {
        activate(card);
      });
    });

    activate(cards[0]);
  })();

  /* Why section — pin scroll: vertical wheel drives horizontal cards, then page scroll */
  (function initWhyCarousel() {
    var section = document.querySelector(".why");
    var viewport = document.querySelector("[data-why-carousel]");
    var track = viewport && viewport.querySelector(".why__cards");
    var dots = Array.prototype.slice.call(document.querySelectorAll("[data-why-dot]"));
    if (!section || !viewport || !track || !dots.length) return;

    var cards = Array.prototype.slice.call(track.querySelectorAll(".why-card"));
    if (cards.length < 2) return;

    if (window.matchMedia("(max-width: 1024px)").matches) {
      track.style.transform = "";
      dots.forEach(function (dot, i) {
        dot.style.display = i === 0 ? "" : "none";
        dot.classList.toggle("is-active", i === 0);
      });
      return;
    }

    var GAP = 21;
    var CARD_W = 438;
    var STEP = CARD_W + GAP;
    var trackW = 0;
    var VIEW_W = 1206;
    var maxOffset = 0;
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

    function applySlide(index, immediate) {
      activeIndex = Math.min(maxProgress, Math.max(0, Math.round(index)));
      progress = activeIndex;
      var offset = Math.min(activeIndex * STEP, maxOffset);
      track.style.transition = immediate ? "none" : "transform 0.28s ease-out";
      track.style.transform = "translate3d(" + (-offset) + "px,0,0)";
      dots.forEach(function (dot, i) {
        if (i > maxProgress) {
          dot.style.display = "none";
          return;
        }
        dot.classList.toggle("is-active", i === activeIndex);
      });
    }

    function measureLayout() {
      CARD_W = cards[0] ? cards[0].offsetWidth : 438;
      STEP = CARD_W + GAP;
      trackW = cards.length * CARD_W + Math.max(0, cards.length - 1) * GAP;
      VIEW_W = viewport.clientWidth || 1206;
      maxOffset = Math.max(0, trackW - VIEW_W);
      applySlide(activeIndex, true);
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

    function freezeAt(y) {
      pinScrollY = y;
      var lenis = window.growteleLenis;
      if (lenis && typeof lenis.scrollTo === "function") {
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
      if (rect.top > window.innerHeight * 0.5 && progress > 0) {
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

    function onScroll() {
      resetIfAboveSection();
    }

    registerLayoutRefresh(measureLayout);
    window.addEventListener("wheel", onWheel, { passive: false, capture: true });
    window.addEventListener("growtele:scroll", onScroll, { passive: true });
    window.addEventListener("scroll", onScroll, { passive: true });

    dots.forEach(function (dot, i) {
      if (i > maxProgress) {
        dot.style.display = "none";
        return;
      }
      dot.style.cursor = "pointer";
      dot.addEventListener("click", function () {
        applySlide(i);
      });
    });

    measureLayout();
  })();
})();
