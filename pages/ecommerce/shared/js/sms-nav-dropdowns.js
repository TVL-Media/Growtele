(function () {
  'use strict';

  var MOBILE_MQ = window.matchMedia('(max-width: 1024px)');

  function initSmsNavDropdowns() {
    var menu = document.querySelector('[data-sms-nav] [data-nav-menu]');
    if (!menu) return;

    var groups = [
      {
        parent: menu.querySelector('[data-mega-parent]'),
        trigger: menu.querySelector('[data-mega-trigger]'),
        panel: menu.querySelector('[data-mega-menu]')
      },
      {
        parent: menu.querySelector('[data-industry-solutions-parent]'),
        trigger: menu.querySelector('[data-industry-solutions-trigger]'),
        panel: menu.querySelector('[data-industry-solutions-dropdown]')
      },
      {
        parent: menu.querySelector('[data-company-parent]'),
        trigger: menu.querySelector('[data-company-trigger]'),
        panel: menu.querySelector('[data-company-dropdown]')
      }
    ];

    groups.forEach(function (group) {
      if (!group.panel || !group.parent) return;
      syncPanelParent(group);
    });

    function isMobileNav() {
      return MOBILE_MQ.matches;
    }

    function syncPanelParent(group) {
      if (!group.panel || !group.parent) return;

      if (isMobileNav()) {
        if (group.panel.parentElement !== group.parent) {
          group.parent.appendChild(group.panel);
        }
        clearPanelPosition(group.panel);
        return;
      }

      if (group.panel.parentElement !== document.body) {
        group.panel.classList.add('sms-dropdown');
        document.body.appendChild(group.panel);
      }
    }

    function clearPanelPosition(panel) {
      if (!panel) return;
      panel.style.position = '';
      panel.style.left = '';
      panel.style.top = '';
      panel.style.transform = '';
      panel.style.width = '';
      panel.style.zIndex = '';
    }

    function positionPanel(panel) {
      if (!panel) return;

      if (isMobileNav()) {
        clearPanelPosition(panel);
        return;
      }

      panel.style.position = 'fixed';
      panel.style.left = '50%';
      panel.style.transform = 'translateX(-50%)';
      panel.style.top = '116px';
      panel.style.width = Math.min(window.innerWidth - 32, 1100) + 'px';
      panel.style.zIndex = '10000';
    }

    function closeAll() {
      groups.forEach(function (group) {
        if (!group.parent || !group.trigger || !group.panel) return;
        group.parent.classList.remove('is-open');
        group.panel.classList.remove('is-open');
        group.trigger.setAttribute('aria-expanded', 'false');
        group.panel.setAttribute('hidden', '');
      });
      menu.querySelectorAll('.menu-item').forEach(function (item) {
        item.classList.remove('is-open');
      });
    }

    function openGroup(group) {
      closeAll();
      if (!group.parent || !group.trigger || !group.panel) return;
      syncPanelParent(group);
      group.parent.classList.add('is-open');
      group.panel.classList.add('is-open');
      group.trigger.setAttribute('aria-expanded', 'true');
      group.panel.removeAttribute('hidden');
      positionPanel(group.panel);
    }

    groups.forEach(function (group) {
      if (!group.trigger) return;

      group.trigger.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (isMobileNav()) {
          if (group.parent && group.parent.classList.contains('is-open')) {
            closeAll();
          } else {
            openGroup(group);
          }
          return;
        }

        var canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
        if (canHover) {
          if (!(group.parent && group.parent.classList.contains('is-open'))) {
            openGroup(group);
          }
          return;
        }

        if (group.parent && group.parent.classList.contains('is-open')) {
          closeAll();
        } else {
          openGroup(group);
        }
      });

      var hideTimer = 0;
      function showOnHover() {
        if (isMobileNav()) return;
        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
        window.clearTimeout(hideTimer);
        openGroup(group);
      }
      function hideOnHover() {
        if (isMobileNav()) return;
        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
        window.clearTimeout(hideTimer);
        hideTimer = window.setTimeout(closeAll, 140);
      }

      if (group.parent) {
        group.parent.addEventListener('mouseenter', showOnHover);
        group.parent.addEventListener('mouseleave', hideOnHover);
      }
      if (group.panel) {
        group.panel.addEventListener('mouseenter', showOnHover);
        group.panel.addEventListener('mouseleave', hideOnHover);
      }
    });

    document.addEventListener('click', function (event) {
      var hit = groups.some(function (group) {
        return (
          (group.parent && group.parent.contains(event.target)) ||
          (group.panel && group.panel.contains(event.target))
        );
      });
      if (!hit) closeAll();
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') closeAll();
    });

    window.addEventListener('resize', function () {
      groups.forEach(function (group) {
        syncPanelParent(group);
        if (group.parent && group.parent.classList.contains('is-open')) {
          positionPanel(group.panel);
        } else {
          clearPanelPosition(group.panel);
        }
      });
    });

    MOBILE_MQ.addEventListener('change', function () {
      groups.forEach(syncPanelParent);
      closeAll();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSmsNavDropdowns);
  } else {
    initSmsNavDropdowns();
  }
})();
