/**
 * Industry use cases — native horizontal swipe on mobile (≤1024px).
 * Desktop keeps wheel-pinned transform carousel in each page script.
 */
(function (window) {
  'use strict';

  var MOBILE_MQ = window.matchMedia('(max-width: 1024px)');

  window.growteleInitUsecasesMobile = function (viewport, track, dots, cards) {
    if (!MOBILE_MQ.matches || !viewport || !track || !cards.length) {
      return false;
    }

    viewport.classList.add('usecases__viewport--touch');
    track.style.transform = 'none';
    track.style.transition = 'none';
    track.style.willChange = 'auto';

    function getGap() {
      var styles = window.getComputedStyle(track);
      var gap = parseFloat(styles.columnGap || styles.gap);
      return isFinite(gap) ? gap : 16;
    }

    function getCardStep() {
      var card = cards[0];
      if (!card) return 0;
      return card.offsetWidth + getGap();
    }

    function setActiveDot(index) {
      var active = Math.min(cards.length - 1, Math.max(0, index));
      dots.forEach(function (dot, i) {
        if (i >= cards.length) {
          dot.style.display = 'none';
          return;
        }
        dot.style.display = '';
        dot.classList.toggle('usecases__dot--active', i === active);
      });
    }

    function updateDotsFromScroll() {
      var step = getCardStep();
      if (!step) return;
      setActiveDot(Math.round(viewport.scrollLeft / step));
    }

    viewport.addEventListener('scroll', updateDotsFromScroll, { passive: true });

    dots.forEach(function (dot, i) {
      if (i >= cards.length) {
        dot.style.display = 'none';
        return;
      }
      dot.style.display = '';
      dot.style.cursor = 'pointer';
      dot.addEventListener('click', function () {
        var step = getCardStep();
        if (!step) return;
        viewport.scrollTo({ left: i * step, behavior: 'smooth' });
      });
    });

    window.addEventListener('resize', function () {
      if (!MOBILE_MQ.matches) return;
      track.style.transform = 'none';
      updateDotsFromScroll();
    });

    setActiveDot(0);
    return true;
  };
})(window);
