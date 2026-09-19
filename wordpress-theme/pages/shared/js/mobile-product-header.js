/**
 * Product pages — mobile header: transparent over hero, solid navy on light sections.
 */
(function () {
  var header = document.querySelector("[data-sms-header]");
  var hero = document.querySelector(".hero");
  if (!header || !hero) return;

  var mq = window.matchMedia("(max-width: 1024px)");

  function updateHeaderState() {
    if (!mq.matches) {
      header.classList.remove("is-solid");
      return;
    }
    var headerH = header.offsetHeight || 72;
    var heroBottom = hero.getBoundingClientRect().bottom;
    header.classList.toggle("is-solid", heroBottom <= headerH + 8);
  }

  window.addEventListener("scroll", updateHeaderState, { passive: true });
  window.addEventListener("growtele:scroll", updateHeaderState, { passive: true });
  window.addEventListener("resize", updateHeaderState, { passive: true });
  window.addEventListener("load", updateHeaderState);
  window.addEventListener("growtele:smooth-scroll-ready", updateHeaderState);
  window.addEventListener("growtele:layout-refresh", updateHeaderState);
  updateHeaderState();
})();
