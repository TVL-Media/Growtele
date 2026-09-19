(function () {
  'use strict';

  var faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  var desktopHoverQuery = window.matchMedia('(min-width: 1025px) and (hover: hover)');

  function closeAllFaqItems() {
    faqItems.forEach(function (other) {
      other.classList.remove('faq-item--open');
      var otherBtn = other.querySelector('.faq-item__question');
      var otherToggle = other.querySelector('.faq-item__toggle');
      if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
      if (otherToggle) otherToggle.textContent = '+';
    });
  }

  function openFaqItem(item) {
    if (!item) return;

    closeAllFaqItems();

    item.classList.add('faq-item--open');
    var button = item.querySelector('.faq-item__question');
    var toggleEl = item.querySelector('.faq-item__toggle');
    if (button) button.setAttribute('aria-expanded', 'true');
    if (toggleEl) toggleEl.textContent = '_';
  }

  document.querySelectorAll('.faq-item__question').forEach(function (button) {
    button.addEventListener('click', function () {
      var item = button.closest('.faq-item');
      if (item.classList.contains('faq-item--open')) {
        closeAllFaqItems();
        return;
      }
      openFaqItem(item);
    });
  });

  faqItems.forEach(function (item) {
    item.addEventListener('mouseenter', function () {
      if (!desktopHoverQuery.matches) return;
      openFaqItem(item);
    });
  });
})();
