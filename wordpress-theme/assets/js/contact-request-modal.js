(function () {
  'use strict';

  var MODAL_ID = 'gtContactRequestModal';
  var OPEN_CLASS = 'gt-contact-request-modal--open';
  var TRANSITION_MS = 320;
  var scrollLockActive = false;

  function isPanelScrollable(panel, deltaY) {
    if (!panel || panel.scrollHeight <= panel.clientHeight + 1) {
      return false;
    }

    var atTop = panel.scrollTop <= 0;
    var atBottom = panel.scrollTop + panel.clientHeight >= panel.scrollHeight - 1;

    if (deltaY < 0 && !atTop) {
      return true;
    }

    if (deltaY > 0 && !atBottom) {
      return true;
    }

    return false;
  }

  function preventBackgroundScroll(event) {
    if (!scrollLockActive) {
      return;
    }

    var modal = document.getElementById(MODAL_ID);
    if (!modal || modal.hidden) {
      return;
    }

    var panel = modal.querySelector('.gt-contact-request-modal__panel');

    if (event.type === 'touchmove') {
      if (panel && panel.contains(event.target) && panel.scrollHeight > panel.clientHeight + 1) {
        return;
      }
      event.preventDefault();
      return;
    }

    var deltaY = event.deltaY || 0;

    if (panel && panel.contains(event.target) && isPanelScrollable(panel, deltaY)) {
      return;
    }

    event.preventDefault();
  }

  function lockPageScroll() {
    if (scrollLockActive) {
      return;
    }

    scrollLockActive = true;
    document.documentElement.classList.add('gt-contact-modal-open');
    document.body.classList.add('gt-contact-modal-open');
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';

    if (window.growteleLenis && typeof window.growteleLenis.stop === 'function') {
      window.growteleLenis.stop();
    }

    window.addEventListener('wheel', preventBackgroundScroll, { passive: false, capture: true });
    window.addEventListener('touchmove', preventBackgroundScroll, { passive: false, capture: true });
  }

  function unlockPageScroll() {
    if (!scrollLockActive) {
      return;
    }

    scrollLockActive = false;
    window.removeEventListener('wheel', preventBackgroundScroll, true);
    window.removeEventListener('touchmove', preventBackgroundScroll, true);

    document.documentElement.classList.remove('gt-contact-modal-open');
    document.body.classList.remove('gt-contact-modal-open');
    document.documentElement.style.overflow = '';
    document.body.style.overflow = '';

    if (window.growteleLenis && typeof window.growteleLenis.start === 'function') {
      window.growteleLenis.start();
    }
  }
  var VIDEO_SRC =
    'https://listings.selectvia.com/wp-content/uploads/2026/09/0_Conversation_Call_1080x1920-1.mp4';

  function themePagesBase() {
    if (window.GROWTELE_THEME_URI) {
      return String(window.GROWTELE_THEME_URI).replace(/\/$/, '') + '/pages/contact/';
    }

    var path = window.location.pathname.replace(/\\/g, '/');
    var pagesIdx = path.indexOf('/pages/');
    if (pagesIdx >= 0) {
      return path.slice(0, pagesIdx + 7) + 'contact/';
    }

    return '../contact/';
  }

  function contactAsset(relativePath) {
    var base = themePagesBase();
    var url = base + String(relativePath || '').replace(/^\.\//, '');

    if (window.growteleResolveAssetUrl) {
      return window.growteleResolveAssetUrl(url);
    }

    try {
      return new URL(url, window.location.href).href;
    } catch (err) {
      return url;
    }
  }

  function findPageLink(selector) {
    var link = document.querySelector(selector);
    return link ? link.getAttribute('href') : '#';
  }

  function buildModal() {
    if (document.getElementById(MODAL_ID)) {
      return document.getElementById(MODAL_ID);
    }

    var termsHref = findPageLink('a[href*="terms-and-condition"]');
    var privacyHref = findPageLink('a[href*="privacy-policy"]');

    var root = document.createElement('div');
    root.id = MODAL_ID;
    root.className = 'gt-contact-request-modal';
    root.hidden = true;
    root.setAttribute('aria-hidden', 'true');

    root.innerHTML =
      '<div class="gt-contact-request-modal__backdrop" data-gt-contact-modal-close tabindex="-1"></div>' +
      '<div class="gt-contact-request-modal__panel" role="dialog" aria-modal="true" aria-label="Talk to our experts">' +
      '<button type="button" class="gt-contact-request-modal__close" data-gt-contact-modal-close aria-label="Close">&times;</button>' +
      '<div class="contact-split contact-split--modal">' +
      '<div class="contact-split__inner">' +
      '<div class="contact-split__image">' +
      '<video src="' +
      VIDEO_SRC +
      '" autoplay muted loop playsinline preload="auto" aria-label="Customer support specialist on a call"></video>' +
      '</div>' +
      '<div class="contact-split__form-wrap">' +
      '<div class="contact-split__form-bg"></div>' +
      '<img src="' +
      contactAsset('assets/figma/form-mask.svg') +
      '" alt="" class="contact-split__form-mask" aria-hidden="true">' +
      '<form class="contact-form" id="gtContactModalForm" novalidate>' +
      '<div class="contact-form__row contact-form__row--two">' +
      '<div class="contact-form__field">' +
      '<label for="gtContactModalFirstName">First Name*</label>' +
      '<input type="text" id="gtContactModalFirstName" name="firstName" placeholder="Rajveer" required>' +
      '</div>' +
      '<div class="contact-form__field">' +
      '<label for="gtContactModalLastName">Last Name*</label>' +
      '<input type="text" id="gtContactModalLastName" name="lastName" placeholder="Singh" required>' +
      '</div>' +
      '</div>' +
      '<div class="contact-form__field">' +
      '<label for="gtContactModalCompany">Company Name</label>' +
      '<input type="text" id="gtContactModalCompany" name="company" placeholder="Enter Your Company Name">' +
      '</div>' +
      '<div class="contact-form__field">' +
      '<label for="gtContactModalEmail">Business E-Mail*</label>' +
      '<input type="email" id="gtContactModalEmail" name="email" placeholder="Enter Your Email Address" required>' +
      '</div>' +
      '<div class="contact-form__field">' +
      '<label for="gtContactModalPhone">Phone Number*</label>' +
      '<div class="contact-form__phone">' +
      '<span class="contact-form__phone-prefix">' +
      '<img src="' +
      contactAsset('assets/figma/flag-india.png') +
      '" alt="" width="26" height="14">' +
      '<span class="contact-form__phone-code">+91</span>' +
      '<img src="' +
      contactAsset('assets/figma/flag-dropdown.png') +
      '" alt="" class="contact-form__phone-caret" width="9" height="7">' +
      '</span>' +
      '<input type="tel" id="gtContactModalPhone" name="phone" placeholder="Enter Your Phone Number" required>' +
      '</div>' +
      '</div>' +
      '<div class="contact-form__field">' +
      '<label for="gtContactModalQuery">About Your Query</label>' +
      '<textarea id="gtContactModalQuery" name="query" rows="4" placeholder="Tell us about your communication needs - volumes, channels, goals ..."></textarea>' +
      '</div>' +
      '<div class="contact-form__terms">' +
      '<input type="checkbox" id="gtContactModalTerms" name="terms" required>' +
      '<label for="gtContactModalTerms">' +
      '<span class="contact-form__terms-white">I agree to the</span> ' +
      '<a href="' +
      termsHref +
      '">Terms &amp; Conditions</a> ' +
      '<span class="contact-form__terms-white">and</span> ' +
      '<a href="' +
      privacyHref +
      '">Privacy Policy</a>' +
      '</label>' +
      '</div>' +
      '<button type="submit" class="contact-form__submit">Submit Request</button>' +
      '</form>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>';

    document.body.appendChild(root);
    bindModalEvents(root);
    bindForm(root);
    return root;
  }

  function openModal() {
    var modal = buildModal();
    if (modal.classList.contains(OPEN_CLASS)) {
      return;
    }

    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');

    window.requestAnimationFrame(function () {
      window.requestAnimationFrame(function () {
        modal.classList.add(OPEN_CLASS);
        lockPageScroll();
      });
    });

    var video = modal.querySelector('video');
    if (video) {
      window.setTimeout(function () {
        try {
          video.currentTime = 0;
          var playPromise = video.play();
          if (playPromise && typeof playPromise.catch === 'function') {
            playPromise.catch(function () {});
          }
        } catch (err) {
          /* ignore */
        }
      }, 40);
    }

    var firstInput = modal.querySelector('#gtContactModalFirstName');
    if (firstInput) {
      window.setTimeout(function () {
        firstInput.focus({ preventScroll: true });
      }, TRANSITION_MS + 40);
    }
  }

  function finishClose(modal) {
    modal.hidden = true;
    modal.setAttribute('aria-hidden', 'true');
    unlockPageScroll();

    var video = modal.querySelector('video');
    if (video) {
      video.pause();
    }
  }

  function closeModal() {
    var modal = document.getElementById(MODAL_ID);
    if (!modal || modal.hidden || !modal.classList.contains(OPEN_CLASS)) {
      return;
    }

    modal.classList.remove(OPEN_CLASS);

    var closed = false;
    function completeClose() {
      if (closed) {
        return;
      }
      closed = true;
      finishClose(modal);
    }

    var panel = modal.querySelector('.gt-contact-request-modal__panel');
    if (panel) {
      panel.addEventListener(
        'transitionend',
        function onTransitionEnd(event) {
          if (event.target !== panel) {
            return;
          }
          if (event.propertyName !== 'opacity' && event.propertyName !== 'transform') {
            return;
          }
          panel.removeEventListener('transitionend', onTransitionEnd);
          completeClose();
        }
      );
    }

    window.setTimeout(completeClose, TRANSITION_MS + 80);
  }

  function bindModalEvents(modal) {
    modal.addEventListener('click', function (event) {
      if (event.target.closest('[data-gt-contact-modal-close]')) {
        closeModal();
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && modal.classList.contains(OPEN_CLASS)) {
        closeModal();
      }
    });
  }

  function bindForm(modal) {
    var form = modal.querySelector('#gtContactModalForm');
    if (!form || form.dataset.bound === 'true') {
      return;
    }

    form.dataset.bound = 'true';

    var contactErrors = Object.assign(
      {
        first_name: 'First name is required',
        last_name: 'Last name is required',
        email: 'Email is required',
        email_invalid: 'Please enter a valid email',
        phone: 'Phone number is required',
        phone_invalid: 'Please enter a valid 10-digit phone number',
        terms: 'You must agree to the terms',
      },
      window.GROWTELE_CMS_CONTACT_ERRORS || {}
    );

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      clearErrors(form);

      var valid = true;
      var firstName = form.querySelector('#gtContactModalFirstName');
      var lastName = form.querySelector('#gtContactModalLastName');
      var email = form.querySelector('#gtContactModalEmail');
      var phone = form.querySelector('#gtContactModalPhone');
      var terms = form.querySelector('#gtContactModalTerms');

      if (!firstName.value.trim()) {
        showError(firstName, contactErrors.first_name);
        valid = false;
      }

      if (!lastName.value.trim()) {
        showError(lastName, contactErrors.last_name);
        valid = false;
      }

      if (!email.value.trim()) {
        showError(email, contactErrors.email);
        valid = false;
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        showError(email, contactErrors.email_invalid);
        valid = false;
      }

      if (!phone.value.trim()) {
        showError(phone, contactErrors.phone);
        valid = false;
      } else if (!/^\d{10}$/.test(phone.value.replace(/\D/g, ''))) {
        showError(phone, contactErrors.phone_invalid);
        valid = false;
      }

      if (!terms.checked) {
        showError(terms, contactErrors.terms);
        valid = false;
      }

      if (!valid) {
        return;
      }

      var btn = form.querySelector('.contact-form__submit');
      var originalText = btn.textContent;
      btn.textContent = window.GROWTELE_CMS_CONTACT_SUBMITTED || 'Submitted!';
      btn.disabled = true;
      window.setTimeout(function () {
        btn.textContent = originalText;
        btn.disabled = false;
        form.reset();
        closeModal();
      }, 2000);
    });
  }

  function showError(input, message) {
    var field = input.closest('.contact-form__field') || input.closest('.contact-form__terms');
    if (!field) {
      return;
    }

    field.classList.add('contact-form__field--error');
    var existing = field.querySelector('.contact-form__error-msg');
    if (!existing) {
      existing = document.createElement('span');
      existing.className = 'contact-form__error-msg';
      field.appendChild(existing);
    }
    existing.textContent = message;
  }

  function clearErrors(form) {
    form.querySelectorAll('.contact-form__field--error').forEach(function (el) {
      el.classList.remove('contact-form__field--error');
    });
    form.querySelectorAll('.contact-form__error-msg').forEach(function (el) {
      el.remove();
    });
  }

  function findContactModalTrigger(target) {
    if (!target || !target.closest) {
      return null;
    }

    return target.closest('a.btn-cta--header, a.gt-footer__cta');
  }

  function initTriggers() {
    document.addEventListener('click', function (event) {
      var trigger = findContactModalTrigger(event.target);
      if (!trigger) {
        return;
      }

      event.preventDefault();
      openModal();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTriggers);
  } else {
    initTriggers();
  }
})();
