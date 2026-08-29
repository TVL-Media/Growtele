(function () {
  var page = document.getElementById("page");
  var scaleEl = document.getElementById("pageScale");
  var wrap = document.querySelector(".page-wrap");
  var PAGE_W = 1440;
  var PAGE_H = 5945;
  var nav = document.querySelector(".nav");
  var toggle = document.querySelector(".nav-toggle");
  var funnelVisual = document.getElementById("funnelVisual");

  var funnelImages = {
    acquisition: { src: "assets/rcseng.png", alt: "Discovery campaign flow" },
    engagement: { src: "assets/rcseng.png", alt: "Engagement campaign flow" },
    retention: { src: "assets/rcseng.png", alt: "Retention campaign flow" }
  };

  function getScrollY() {
    if (window.growteleLenis && typeof window.growteleLenis.scroll === "number") {
      return window.growteleLenis.scroll;
    }
    return window.scrollY || window.pageYOffset || 0;
  }

  function fitPage() {
    if (!page || !scaleEl) return;

    var width = window.innerWidth;
    var keepY = null;
    if (window.growteleLenis && typeof window.growteleLenis.scroll === "number") {
      keepY = window.growteleLenis.scroll;
    } else {
      keepY = window.scrollY || window.pageYOffset || 0;
    }

    if (width < 768) {
      page.style.transform = "none";
      page.style.height = "";
      scaleEl.style.width = "";
      scaleEl.style.height = "";
      if (wrap) wrap.style.height = "auto";
      return;
    }

    var footer = page.querySelector(".gt-footer");
    var pageH = PAGE_H;
    if (footer) {
      pageH = Math.ceil(footer.offsetTop + footer.offsetHeight);
      page.style.height = pageH + "px";
    }

    var scale = width / PAGE_W;
    page.style.transform = "scale(" + scale + ")";
    scaleEl.style.width = width + "px";
    scaleEl.style.height = Math.round(pageH * scale) + "px";
    if (wrap) wrap.style.height = Math.round(pageH * scale) + "px";

    if (window.growteleLenis && typeof window.growteleLenis.resize === "function") {
      window.growteleLenis.resize();
      if (keepY != null && typeof window.growteleLenis.scrollTo === "function") {
        window.growteleLenis.scrollTo(keepY, { immediate: true });
      }
    } else if (keepY != null) {
      window.scrollTo(0, keepY);
    }
  }

  function closeNav() {
    if (!nav || !toggle) return;
    nav.classList.remove("is-open");
    toggle.setAttribute("aria-expanded", "false");
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
      document.querySelectorAll(".funnel__tab").forEach(function (item) {
        item.classList.remove("is-active");
        item.setAttribute("aria-selected", "false");
      });
      tab.classList.add("is-active");
      tab.setAttribute("aria-selected", "true");
      var key = tab.getAttribute("data-funnel");
      if (funnelVisual && funnelImages[key]) {
        funnelVisual.src = funnelImages[key].src;
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

  document.querySelectorAll(".faq-item__btn").forEach(function (button) {
    button.addEventListener("click", function () {
      var item = button.closest(".faq-item");
      var isOpen = item.classList.contains("is-open");
      document.querySelectorAll(".faq-item").forEach(function (other) {
        other.classList.remove("is-open");
        var otherBtn = other.querySelector(".faq-item__btn");
        var otherToggle = other.querySelector(".faq-item__toggle");
        if (otherBtn) otherBtn.setAttribute("aria-expanded", "false");
        if (otherToggle) otherToggle.textContent = "+";
      });
      if (!isOpen) {
        item.classList.add("is-open");
        button.setAttribute("aria-expanded", "true");
        var toggleEl = item.querySelector(".faq-item__toggle");
        if (toggleEl) toggleEl.textContent = "_";
      }
    });
  });

  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      var open = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", closeNav);
    });
  }

  window.addEventListener("resize", fitPage);
  fitPage();
  window.addEventListener("growtele:smooth-scroll-ready", fitPage);

  /* Journey cards — pin only while section is on screen, then stack on scroll */
  (function initJourneyCardStack() {
    var section = document.querySelector(".journey");
    var wrap = document.querySelector(".journey__cards");
    if (!section || !wrap) return;
    var cards = Array.prototype.slice.call(wrap.querySelectorAll(".journey-card"));
    if (cards.length < 2) return;

    var CARD_H = 172;
    var GAP = 12;
    var STEP = CARD_H + GAP;
    var maxProgress = cards.length - 1;
    var progress = 0;
    var pinned = false;
    var pinScrollY = 0;

    cards.forEach(function (card, index) {
      card.style.top = index * STEP + "px";
      card.style.zIndex = String(index + 1);
      card.style.transform = "translate3d(0,0,0)";
    });

    function applyStack(value) {
      progress = Math.min(maxProgress, Math.max(0, value));
      cards.forEach(function (card, index) {
        var move = Math.min(index, progress) * STEP;
        card.style.transform = "translate3d(0," + (-move) + "px,0)";
        card.style.zIndex = String(index + 1);
      });
    }

    function getScrollY() {
      if (window.growteleLenis && typeof window.growteleLenis.scroll === "number") {
        return window.growteleLenis.scroll;
      }
      return window.scrollY || window.pageYOffset || 0;
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

    /* Only interact while journey is actually in the viewport */
    function sectionInView() {
      var rect = section.getBoundingClientRect();
      return rect.top < window.innerHeight * 0.75 && rect.bottom > window.innerHeight * 0.2;
    }

    function isAtPinLevel() {
      var rect = section.getBoundingClientRect();
      var first = cards[0].getBoundingClientRect();
      var last = cards[cards.length - 1].getBoundingClientRect();
      var sectionNearTop = rect.top <= 60 && rect.top >= -80;
      var cardsInView = first.top >= 70 && last.bottom <= window.innerHeight + 20;
      return sectionNearTop && cardsInView;
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

    window.addEventListener("wheel", onWheel, { passive: false, capture: true });
    applyStack(0);
  })();

  /* Scale cards — first open by default, expand on hover */
  (function initScaleHoverCards() {
    var grid = document.querySelector("[data-scale-grid]");
    if (!grid) return;
    var cards = Array.prototype.slice.call(grid.querySelectorAll("[data-scale-card]"));
    if (!cards.length) return;
    var first = cards[0];

    function setActive(card) {
      cards.forEach(function (item) {
        item.classList.toggle("is-active", item === card);
      });
      grid.classList.add("has-active");
    }

    cards.forEach(function (card) {
      card.addEventListener("mouseenter", function () {
        setActive(card);
      });
    });

    grid.addEventListener("mouseleave", function () {
      setActive(first);
    });

    setActive(first);
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
      var src = card.getAttribute("data-benefit-img");
      if (src) {
        visual.src = src;
        var title = card.querySelector("h3");
        visual.alt = title ? title.textContent.replace(/\s+/g, " ").trim() : "Benefit preview";
      }
    }

    cards.forEach(function (card) {
      card.addEventListener("click", function () {
        activate(card);
      });
    });

    activate(cards[0]);
  })();

  /* Why section — smooth side scroll, clamp so last card stays in view */
  (function initWhyCarousel() {
    var viewport = document.querySelector("[data-why-carousel]");
    var track = viewport && viewport.querySelector(".why__cards");
    var dots = Array.prototype.slice.call(document.querySelectorAll("[data-why-dot]"));
    if (!viewport || !track || !dots.length) return;

    var cards = Array.prototype.slice.call(track.querySelectorAll(".why-card"));
    if (!cards.length) return;

    var CARD_W = 438;
    var GAP = 21;
    var VIEW_W = 1206;
    var STEP = CARD_W + GAP;
    var trackW = cards.length * CARD_W + Math.max(0, cards.length - 1) * GAP;
    var maxOffset = Math.max(0, trackW - VIEW_W);
    var maxIndex = Math.max(0, cards.length - 1);
    var index = 0;
    var locked = false;
    var lockTimer = null;

    function offsetFor(i) {
      return Math.min(Math.max(0, i) * STEP, maxOffset);
    }

    function goTo(next) {
      index = Math.min(maxIndex, Math.max(0, next));
      track.style.transform = "translate3d(" + (-offsetFor(index)) + "px,0,0)";
      dots.forEach(function (dot, i) {
        dot.classList.toggle("is-active", i === index);
      });
    }

    function lockBriefly() {
      locked = true;
      clearTimeout(lockTimer);
      lockTimer = setTimeout(function () {
        locked = false;
      }, 480);
    }

    viewport.addEventListener("wheel", function (event) {
      /* Only take over when gesture is mostly horizontal, or vertical while hovering carousel */
      var absX = Math.abs(event.deltaX);
      var absY = Math.abs(event.deltaY);
      var delta = absX > absY ? event.deltaX : event.deltaY;
      if (absX < absY && absY < 6) return;

      if (delta > 0 && index < maxIndex) {
        event.preventDefault();
        if (locked) return;
        lockBriefly();
        goTo(index + 1);
      } else if (delta < 0 && index > 0) {
        event.preventDefault();
        if (locked) return;
        lockBriefly();
        goTo(index - 1);
      }
      /* At ends: allow normal page scroll (no empty overscroll on track) */
    }, { passive: false });

    var startX = 0;
    viewport.addEventListener("pointerdown", function (event) {
      startX = event.clientX;
    });
    viewport.addEventListener("pointerup", function (event) {
      var dx = event.clientX - startX;
      if (dx < -40) goTo(index + 1);
      if (dx > 40) goTo(index - 1);
    });

    dots.forEach(function (dot, i) {
      if (i > maxIndex) {
        dot.style.display = "none";
        return;
      }
      dot.style.cursor = "pointer";
      dot.addEventListener("click", function () {
        goTo(i);
      });
    });

    goTo(0);
  })();
})();
