(function () {
  'use strict';

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

})();
