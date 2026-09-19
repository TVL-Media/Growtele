(function () {
  'use strict';

  var MQ = window.matchMedia('(max-width: 1024px)');

  function resetTrack(track) {
    if (!MQ.matches) return;
    track.scrollLeft = 0;
  }

  function initTrack(track) {
    if (!MQ.matches) return;
    resetTrack(track);
    requestAnimationFrame(function () {
      resetTrack(track);
    });
  }

  function init() {
    if (!MQ.matches) return;
    document.querySelectorAll('.growth__cards').forEach(initTrack);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  window.addEventListener('load', init);
  MQ.addEventListener('change', function (event) {
    if (event.matches) init();
  });
})();
