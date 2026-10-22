(function () {
  'use strict';

  var faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  var desktopHoverQuery = window.matchMedia('(min-width: 1025px) and (hover: hover)');

  function closeAllFaqItems() {
    faqItems.forEach(function (other) {
      other.classList.remove('is-open');
      var otherBtn = other.querySelector('.faq-item__btn');
      var otherToggle = other.querySelector('.faq-item__toggle');
      if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
      if (otherToggle) otherToggle.textContent = '+';
    });
  }

  function openFaqItem(item) {
    if (!item) return;

    closeAllFaqItems();

    item.classList.add('is-open');
    var button = item.querySelector('.faq-item__btn');
    var toggleEl = item.querySelector('.faq-item__toggle');
    if (button) button.setAttribute('aria-expanded', 'true');
    if (toggleEl) toggleEl.textContent = '_';
  }

  document.querySelectorAll('.faq-item__btn').forEach(function (button) {
    button.addEventListener('click', function () {
      var item = button.closest('.faq-item');
      if (item.classList.contains('is-open')) {
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

  /* Mobile/tablet: reserve the list height of the tallest open answer, so
     opening or closing an item never moves the CTA/footer card below. */
  var mobileQuery = window.matchMedia('(max-width: 1024px)');
  var faqList = document.querySelector('.faq__list');

  function lockFaqListHeight() {
    if (!faqList) return;
    faqList.style.removeProperty('min-height');
    if (!mobileQuery.matches) return;
    var openItem = document.querySelector('.faq-item.is-open');
    var tallest = 0;
    faqItems.forEach(function (item) {
      openFaqItem(item);
      tallest = Math.max(tallest, faqList.getBoundingClientRect().height);
    });
    if (openItem) {
      openFaqItem(openItem);
    } else {
      closeAllFaqItems();
    }
    faqList.style.setProperty('min-height', Math.ceil(tallest) + 'px', 'important');
  }

  var resizeTimer = null;
  window.addEventListener('resize', function () {
    window.clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(lockFaqListHeight, 150);
  });
  window.addEventListener('load', lockFaqListHeight);
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(lockFaqListHeight);
  }
  lockFaqListHeight();
})();
