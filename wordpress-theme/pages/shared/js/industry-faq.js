(function () {
  'use strict';

  var faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  var desktopHoverQuery = window.matchMedia('(min-width: 1025px) and (hover: hover)');

  function closeAllFaqItems() {
    faqItems.forEach(function (other) {
      setFaqItemOpen(other, false);
    });
  }

  function setFaqItemOpen(item, isOpen) {
    if (!item) return;
    item.classList.toggle('faq-item--open', isOpen);
    var button = item.querySelector('.faq-item__question');
    var toggleEl = item.querySelector('.faq-item__toggle');
    if (button) button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    if (toggleEl) toggleEl.textContent = isOpen ? '_' : '+';
  }

  function openFaqItem(item) {
    if (!item) return;
    faqItems.forEach(function (other) {
      if (other === item) {
        setFaqItemOpen(other, true);
        return;
      }
      if (other.classList.contains('faq-item--open')) {
        setFaqItemOpen(other, false);
      }
    });
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
