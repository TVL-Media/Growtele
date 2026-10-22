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

  /* Reserve the list height of the tallest open answer, so switching items
     never changes the section height and the CTA/footer below stays still. */
  var faqList = document.querySelector('.faq__list');

  function lockFaqListHeight() {
    if (!faqList) return;
    var openItem = document.querySelector('.faq-item.faq-item--open');
    var answers = Array.prototype.map.call(faqItems, function (item) {
      return item.querySelector('.faq-item__answer');
    });
    answers.forEach(function (answer) {
      if (answer) answer.style.setProperty('transition', 'none', 'important');
    });
    faqList.style.removeProperty('min-height');
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
    void faqList.offsetHeight;
    answers.forEach(function (answer) {
      if (answer) answer.style.removeProperty('transition');
    });
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
