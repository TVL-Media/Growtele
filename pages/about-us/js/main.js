(function () {
  'use strict';

  // Location tabs
  const locationTabs = document.getElementById('locationTabs');
  const locationData = {
    kolkata: {
      city: 'Kolkata',
      address: 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-462.png'
    },
    delhi: {
      city: 'Delhi NCR',
      address: 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-462.png'
    },
    bengaluru: {
      city: 'Bengaluru',
      address: 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-462.png'
    },
    mumbai: {
      city: 'Mumbai',
      address: 'Unit No 303-3rd Floor, Majestic Signia, Plot No. A-27, Block A, Industrial Area, Sector 62, Noida, Uttar Pradesh 201309',
      phone: '+91 9999-564-564',
      email1: 'info@growtele.com',
      email2: 'support@growtele.com',
      image: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-462.png'
    }
  };

  if (locationTabs) {
    const tabs = locationTabs.querySelectorAll('.locations__tab');
    const cityEl = document.getElementById('locationCity');
    const addressEl = document.getElementById('locationAddress');
    const phoneEl = document.getElementById('locationPhone');
    const email1El = document.getElementById('locationEmail1');
    const email2El = document.getElementById('locationEmail2');
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
