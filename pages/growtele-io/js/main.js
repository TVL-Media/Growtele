(function () {
  'use strict';

  /* Reporting tabs */
  const reportItems = document.querySelectorAll('.reporting__item');

  reportItems.forEach(function (item) {
    item.addEventListener('click', function () {
      reportItems.forEach(function (i) {
        i.classList.remove('is-active');
      });
      item.classList.add('is-active');
    });
  });

  /* API list items */
  const apiItems = document.querySelectorAll('.apis__list-item');

  apiItems.forEach(function (item) {
    item.addEventListener('click', function () {
      apiItems.forEach(function (i) {
        i.classList.remove('is-active');
      });
      item.classList.add('is-active');
    });
  });

  /* Security items */
  const securityItems = document.querySelectorAll('.security__item');

  securityItems.forEach(function (item) {
    item.addEventListener('click', function () {
      securityItems.forEach(function (i) {
        i.classList.remove('is-active');
      });
      item.classList.add('is-active');
    });
  });

  /* FAQ accordion (Retail layout) */
  const faqItems = document.querySelectorAll('.faq-item');
  const desktopHoverQuery = window.matchMedia('(min-width: 1025px) and (hover: hover)');

  function closeAllFaqItems() {
    faqItems.forEach(function (other) {
      other.classList.remove('faq-item--open');
      const btn = other.querySelector('.faq-item__question');
      const toggle = other.querySelector('.faq-item__toggle');
      if (btn) btn.setAttribute('aria-expanded', 'false');
      if (toggle) toggle.textContent = '+';
    });
  }

  function openFaqItem(item) {
    if (!item) return;
    closeAllFaqItems();
    item.classList.add('faq-item--open');
    const trigger = item.querySelector('.faq-item__question');
    const toggle = item.querySelector('.faq-item__toggle');
    if (trigger) trigger.setAttribute('aria-expanded', 'true');
    if (toggle) toggle.textContent = '_';
  }

  faqItems.forEach(function (item) {
    const trigger = item.querySelector('.faq-item__question');
    if (!trigger) return;

    trigger.addEventListener('click', function () {
      if (item.classList.contains('faq-item--open')) {
        closeAllFaqItems();
        return;
      }
      openFaqItem(item);
    });

    item.addEventListener('mouseenter', function () {
      if (!desktopHoverQuery.matches) return;
      openFaqItem(item);
    });
  });
})();
