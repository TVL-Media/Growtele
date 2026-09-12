(function () {
  'use strict';

  // Mobile navigation
  const menuBtn = document.getElementById('menuBtn');
  const mainNav = document.getElementById('mainNav');

  if (menuBtn && mainNav) {
    menuBtn.addEventListener('click', function () {
      const isOpen = mainNav.classList.toggle('is-open');
      menuBtn.setAttribute('aria-expanded', String(isOpen));
    });

    mainNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mainNav.classList.remove('is-open');
        menuBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }

  var sharedAddress = 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309';

  const locationData = {
    kolkata: {
      city: 'Kolkata',
      address: sharedAddress,
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/526d7a71d22dd2b2008ce00a1bd539b77309d3e1.png',
      iconAlt: 'Kolkata office',
      map: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group.png',
      mapAlt: 'Kolkata office location'
    },
    delhi: {
      city: 'Delhi NCR',
      address: sharedAddress,
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'assets/image 82 (1).png',
      iconAlt: 'India Gate, Delhi NCR',
      map: 'assets/Group 462 (1).png',
      mapAlt: 'India Gate, Delhi NCR'
    },
    bengaluru: {
      city: 'Bengaluru',
      address: sharedAddress,
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/bb8667e3c10c1ec42abfb1e27f4c0a753d6d38c4.png',
      iconAlt: 'Bengaluru office',
      map: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-1.png',
      mapAlt: 'Bengaluru office location'
    },
    mumbai: {
      city: 'Mumbai',
      address: sharedAddress,
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/954a1aa36af01ba5f2647ec2b95abd204c1942d5.png',
      iconAlt: 'Mumbai office',
      map: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-2.png',
      mapAlt: 'Mumbai office location'
    }
  };

  const tabs = document.querySelectorAll('.locations__tab');
  const cityEl = document.getElementById('locationCity');
  const addressEl = document.getElementById('locationAddress');
  const phoneEl = document.getElementById('locationPhone');
  const email1El = document.getElementById('locationEmail1');
  const email2El = document.getElementById('locationEmail2');
  const iconEl = document.getElementById('locationIcon');
  const mapEl = document.getElementById('locationMap');

  if (mapEl) {
    mapEl.style.transition = 'opacity 0.15s ease';
  }

  function applyLocation(data) {
    if (!data) return;

    if (cityEl) cityEl.textContent = data.city;
    if (addressEl) addressEl.textContent = data.address;
    if (phoneEl) {
      phoneEl.textContent = data.phone;
      phoneEl.href = 'tel:' + data.phone.replace(/\s/g, '');
    }
    if (email1El) {
      email1El.textContent = data.email1;
      email1El.href = 'mailto:' + data.email1;
    }
    if (email2El) {
      email2El.textContent = data.email2;
      email2El.href = 'mailto:' + data.email2;
    }
    if (iconEl) {
      iconEl.src = data.icon;
      iconEl.alt = data.iconAlt;
    }
    if (mapEl) {
      mapEl.style.opacity = '0';
      setTimeout(function () {
        mapEl.src = data.map;
        mapEl.alt = data.mapAlt;
        mapEl.style.opacity = '1';
      }, 150);
    }
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var key = tab.getAttribute('data-location');
      var data = locationData[key];
      if (!data) return;

      tabs.forEach(function (t) {
        t.classList.remove('locations__tab--active');
        t.setAttribute('aria-selected', 'false');
      });
      tab.classList.add('locations__tab--active');
      tab.setAttribute('aria-selected', 'true');

      applyLocation(data);
    });
  });

  // Contact form validation
  const form = document.getElementById('contactForm');

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      clearErrors();

      var valid = true;
      var firstName = document.getElementById('firstName');
      var lastName = document.getElementById('lastName');
      var email = document.getElementById('email');
      var phone = document.getElementById('phone');
      var terms = document.getElementById('terms');

      if (!firstName.value.trim()) {
        showError(firstName, 'First name is required');
        valid = false;
      }

      if (!lastName.value.trim()) {
        showError(lastName, 'Last name is required');
        valid = false;
      }

      if (!email.value.trim()) {
        showError(email, 'Email is required');
        valid = false;
      } else if (!isValidEmail(email.value)) {
        showError(email, 'Please enter a valid email');
        valid = false;
      }

      if (!phone.value.trim()) {
        showError(phone, 'Phone number is required');
        valid = false;
      } else if (!/^\d{10}$/.test(phone.value.replace(/\D/g, ''))) {
        showError(phone, 'Please enter a valid 10-digit phone number');
        valid = false;
      }

      if (!terms.checked) {
        showError(terms, 'You must agree to the terms');
        valid = false;
      }

      if (valid) {
        var btn = form.querySelector('.contact-form__submit');
        var originalText = btn.textContent;
        btn.textContent = 'Submitted!';
        btn.disabled = true;
        setTimeout(function () {
          btn.textContent = originalText;
          btn.disabled = false;
          form.reset();
        }, 2000);
      }
    });
  }

  function isValidEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  }

  function showError(input, message) {
    var field = input.closest('.contact-form__field') || input.closest('.contact-form__terms');
    if (!field) return;

    field.classList.add('contact-form__field--error');
    var existing = field.querySelector('.contact-form__error-msg');
    if (!existing) {
      existing = document.createElement('span');
      existing.className = 'contact-form__error-msg';
      field.appendChild(existing);
    }
    existing.textContent = message;
  }

  function clearErrors() {
    document.querySelectorAll('.contact-form__field--error').forEach(function (el) {
      el.classList.remove('contact-form__field--error');
    });
    document.querySelectorAll('.contact-form__error-msg').forEach(function (el) {
      el.remove();
    });
  }
})();
