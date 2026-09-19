(function () {
  'use strict';

  var jobCards = document.querySelectorAll('.job-card');

  jobCards.forEach(function (card) {
    var readMore = card.querySelector('.job-card__read-more');
    if (!readMore) {
      return;
    }

    readMore.addEventListener('click', function (event) {
      event.preventDefault();

      var isExpanded = card.classList.contains('is-expanded');

      jobCards.forEach(function (c) {
        c.classList.remove('is-expanded');
        var header = c.querySelector('.job-card__header');
        if (header) {
          header.setAttribute('aria-expanded', 'false');
        }
      });

      if (!isExpanded) {
        card.classList.add('is-expanded');
        var expandedHeader = card.querySelector('.job-card__header');
        if (expandedHeader) {
          expandedHeader.setAttribute('aria-expanded', 'true');
        }
      }
    });
  });
})();
