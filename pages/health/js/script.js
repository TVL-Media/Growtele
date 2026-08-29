(function () {
  'use strict';

  /* Keep exact scroll position on refresh (no smooth jump to next section) */
  (function initScrollRestore() {
    var key = 'growtele:scroll-y:' + window.location.pathname + window.location.search;
    if ('scrollRestoration' in history) {
      history.scrollRestoration = 'manual';
    }

    function readSaved() {
      try {
        var raw = sessionStorage.getItem(key);
        if (raw == null || raw === '') return null;
        var y = parseFloat(raw);
        return isFinite(y) && y >= 0 ? y : null;
      } catch (err) {
        return null;
      }
    }

    function save(y) {
      try {
        sessionStorage.setItem(key, String(Math.max(0, Number(y) || 0)));
      } catch (err) { /* ignore */ }
    }

    var restoreY = readSaved();
    if (restoreY == null) restoreY = window.scrollY || window.pageYOffset || 0;
    var until = Date.now() + 1500;

    function restore() {
      if (restoreY == null || restoreY < 1 || Date.now() > until) return;
      window.scrollTo(0, restoreY);
    }

    restore();
    window.addEventListener('load', function () {
      restore();
      requestAnimationFrame(restore);
    });
    setTimeout(restore, 300);
    setTimeout(restore, 900);

    window.addEventListener('scroll', function () {
      if (Date.now() > until) restoreY = window.scrollY || 0;
      save(window.scrollY || 0);
    }, { passive: true });

    window.addEventListener('pagehide', function () {
      save(window.scrollY || 0);
    });
  })();

  /* Channel tabs */
  var channelData = {
    sms: {
      title: 'Deliver secure patient communication through SMS with appointment reminders, health alerts and two-way engagement.',
      desc: 'Engage patients with appointment reminders, health updates, and real-time support on SMS.',
      image: 'assets/healthse.png'
    },
    whatsapp: {
      title: 'Deliver personalized patient care through WhatsApp with appointment booking, prescription updates and instant assistance.',
      desc: 'Engage patients with appointment confirmations, health tips, and real-time support on WhatsApp.',
      image: 'assets/healthse.png'
    },
    telephony: {
      title: 'Deliver reliable healthcare communication through Cloud Telephony with voice reminders and automated patient support.',
      desc: 'Engage patients with voice-assisted calls, follow-ups, and real-time support on Cloud Telephony.',
      image: 'assets/healthse.png'
    },
    rcs: {
      title: 'Deliver rich healthcare communication through RCS with interactive appointment cards and personalized health updates.',
      desc: 'Engage patients with rich media messages, reminders, and real-time support on RCS.',
      image: 'assets/healthse.png'
    },
    email: {
      title: 'Deliver secure healthcare communication through E-mail with test results, care plans and personalized patient updates.',
      desc: 'Engage patients with health reports, appointment details, and real-time support on E-mail.',
      image: 'assets/healthse.png'
    }
  };

  var tabs = document.querySelectorAll('.channels__tab');
  var channelTitle = document.getElementById('channel-title');
  var channelTabDesc = document.getElementById('channel-tab-desc');
  var channelPhoneImg = document.getElementById('channel-phone-img');
  var tabsContainer = document.querySelector('.channels__tabs');

  function placeTabDesc(activeTab) {
    if (!channelTabDesc || !activeTab || !tabsContainer) return;
    activeTab.insertAdjacentElement('afterend', channelTabDesc);
    channelTabDesc.hidden = false;
  }

  function updateIndicator(activeTab) {
    if (!tabsContainer || !activeTab) return;
    var height = activeTab.offsetHeight;
    if (channelTabDesc && channelTabDesc.parentElement === tabsContainer) {
      height += channelTabDesc.offsetHeight + 8;
    }
    tabsContainer.style.setProperty('--tab-indicator-top', activeTab.offsetTop + 'px');
    tabsContainer.style.setProperty('--tab-indicator-height', height + 'px');
  }

  function activateChannelTab(tab) {
    tabs.forEach(function (t) {
      t.classList.remove('channels__tab--active');
      t.setAttribute('aria-selected', 'false');
    });
    tab.classList.add('channels__tab--active');
    tab.setAttribute('aria-selected', 'true');

    var key = tab.getAttribute('data-tab');
    var data = channelData[key];
    if (data) {
      if (channelTitle) channelTitle.textContent = data.title;
      if (channelTabDesc) channelTabDesc.textContent = data.desc;
      if (channelPhoneImg && data.image) {
        channelPhoneImg.src = data.image;
        channelPhoneImg.alt = '';
      }
    }

    placeTabDesc(tab);
    requestAnimationFrame(function () {
      updateIndicator(tab);
    });
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      activateChannelTab(tab);
    });
  });

  var initialTab = document.querySelector('.channels__tab--active') || tabs[0];
  if (initialTab) activateChannelTab(initialTab);

  /* FAQ accordion */
  var faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(function (item) {
    var btn = item.querySelector('.faq-item__question');
    if (!btn) return;

    btn.addEventListener('click', function () {
      var isOpen = item.classList.contains('faq-item--open');

      faqItems.forEach(function (other) {
        other.classList.remove('faq-item--open');
        var otherBtn = other.querySelector('.faq-item__question');
        var toggle = other.querySelector('.faq-item__toggle');
        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        if (toggle) toggle.textContent = '+';
      });

      if (!isOpen) {
        item.classList.add('faq-item--open');
        btn.setAttribute('aria-expanded', 'true');
        var toggleEl = item.querySelector('.faq-item__toggle');
        if (toggleEl) toggleEl.textContent = '_';
      }
    });
  });
})();
const usecasesCards = document.querySelector('.usecases__cards');
const usecaseDots = document.querySelectorAll('.usecases__dot');

if (usecasesCards && usecaseDots.length) {

  function updateActiveDot() {
    const maxScroll =
      usecasesCards.scrollWidth - usecasesCards.clientWidth;

    const currentScroll = usecasesCards.scrollLeft;

    const step = maxScroll / (usecaseDots.length - 1);

    let activeIndex = Math.round(currentScroll / step);

    activeIndex = Math.max(
      0,
      Math.min(activeIndex, usecaseDots.length - 1)
    );

    usecaseDots.forEach((dot, index) => {
      dot.classList.toggle(
        'usecases__dot--active',
        index === activeIndex
      );
    });
  }

  // Dot click
  usecaseDots.forEach((dot, index) => {
    dot.addEventListener('click', () => {

      const maxScroll =
        usecasesCards.scrollWidth - usecasesCards.clientWidth;

      const step = maxScroll / (usecaseDots.length - 1);

      usecasesCards.scrollTo({
        left: step * index,
        behavior: 'smooth'
      });
    });
  });

  // Manual side scroll
  usecasesCards.addEventListener('scroll', updateActiveDot);

  // Initial state
  updateActiveDot();
}