(function () {
  'use strict';

  // Location tabs
  const locationTabs = document.getElementById('locationTabs');
  const locationData = {
    kolkata: {
      city: 'Kolkata',
      address: '3, Ismail Madan Lane, Zakaria Street,\nKolkata 700073, IN',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/526d7a71d22dd2b2008ce00a1bd539b77309d3e1.png',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-3.png'
    },
    delhi: {
      city: 'Delhi NCR',
      address: 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/d3821cf9de4106d1d740854567464a4bf8a43b16.png',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-462.png'
    },
    bengaluru: {
      city: 'Bengaluru',
      address: 'MG road, Raheja Towers, 7th floor, East Wing, Bengaluru, Karnataka 560061, IN',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/bb8667e3c10c1ec42abfb1e27f4c0a753d6d38c4.png',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-1.png'
    },
    mumbai: {
      city: 'Mumbai',
      address: 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      icon: 'https://listings.selectvia.com/wp-content/uploads/2026/09/954a1aa36af01ba5f2647ec2b95abd204c1942d5.png',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Mask-group-2.png'
    }
  };

  if (window.GROWTELE_CMS_LOCATIONS) {
    Object.keys(window.GROWTELE_CMS_LOCATIONS).forEach(function (key) {
      locationData[key] = Object.assign({}, locationData[key] || {}, window.GROWTELE_CMS_LOCATIONS[key]);
    });
  }

  if (locationTabs) {
    const tabs = locationTabs.querySelectorAll('.locations__tab');
    const cityEl = document.getElementById('locationCity');
    const addressEl = document.getElementById('locationAddress');
    const phoneEl = document.getElementById('locationPhone');
    const email1El = document.getElementById('locationEmail1');
    const email2El = document.getElementById('locationEmail2');
    const iconEl = document.getElementById('locationIcon');
    const imageEl = document.getElementById('locationImage');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        const city = tab.dataset.city;
        const data = locationData[city];
        if (!data) return;

        tabs.forEach(function (t) { t.classList.remove('locations__tab--active'); });
        tab.classList.add('locations__tab--active');

        if (cityEl) cityEl.textContent = data.city;
        if (addressEl) addressEl.textContent = data.address;
        if (phoneEl) phoneEl.textContent = data.phone;
        if (email1El) email1El.textContent = data.email1;
        if (email2El) email2El.textContent = data.email2;
        if (iconEl && data.icon) {
          iconEl.src = data.icon;
          iconEl.alt = data.city + ' office';
        }
        if (imageEl) {
          imageEl.style.opacity = '0';
          setTimeout(function () {
            imageEl.src = data.image;
            imageEl.alt = data.city + ' office location';
            imageEl.style.opacity = '1';
          }, 150);
        }
      });
    });
  }

  // Team carousel navigation
  const teamCarousel = document.getElementById('teamCarousel');
  const teamPrev = document.getElementById('teamPrev');
  const teamNext = document.getElementById('teamNext');

  if (teamCarousel && teamPrev && teamNext) {
    const scrollAmount = 320;

    teamPrev.addEventListener('click', function () {
      teamCarousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    teamNext.addEventListener('click', function () {
      teamCarousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
  }

  // Smooth image transition for location
  const locationImage = document.getElementById('locationImage');
  if (locationImage) {
    locationImage.style.transition = 'opacity 0.15s ease';
  }
})();
