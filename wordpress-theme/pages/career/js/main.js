(function () {
  'use strict';

  var jobCards = document.querySelectorAll('.job-card');
    var header = card.querySelector('.job-card__header');
    if (!header) return;

    header.addEventListener('click', function () {
      var isExpanded = card.classList.contains('is-expanded');

      jobCards.forEach(function (c) {
        c.classList.remove('is-expanded');
        var btn = c.querySelector('.job-card__header');
        if (btn) btn.setAttribute('aria-expanded', 'false');
      });

      if (!isExpanded) {
        card.classList.add('is-expanded');
        header.setAttribute('aria-expanded', 'true');
      }
    });
  });

  var expanded = document.querySelector('.job-card.is-expanded');
  if (expanded) {
    var expandedHeader = expanded.querySelector('.job-card__header');
    if (expandedHeader) expandedHeader.setAttribute('aria-expanded', 'true');
  }
})();
