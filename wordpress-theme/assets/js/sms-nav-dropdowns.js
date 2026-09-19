(function () {
  'use strict';

  var MOBILE_MQ = window.matchMedia('(max-width: 1024px)');
  var HIDE_DELAY_MS = 360;
  var hideTimer = 0;

  function getHeaderInner() {
    return document.querySelector('.gt-header__inner') || document.querySelector('.header__inner');
  }

  function resolvePanel(menu, selector) {
    if (!menu || !selector) return null;
    return menu.querySelector(selector) || document.querySelector(selector);
  }

  function initSmsNavDropdowns() {
    var menu = document.querySelector('[data-sms-nav] [data-nav-menu]');
    if (!menu) return;

    var groups = [
      {
        parent: menu.querySelector('[data-mega-parent]'),
        trigger: menu.querySelector('[data-mega-trigger]'),
        panel: resolvePanel(menu, '[data-mega-menu]')
      },
      {
        parent: menu.querySelector('[data-industry-solutions-parent]'),
        trigger: menu.querySelector('[data-industry-solutions-trigger]'),
        panel: resolvePanel(menu, '[data-industry-solutions-dropdown]')
      },
      {
        parent: menu.querySelector('[data-company-parent]'),
        trigger: menu.querySelector('[data-company-trigger]'),
        panel: resolvePanel(menu, '[data-company-dropdown]')
      }
    ];

    groups.forEach(function (group) {
      if (!group.panel || !group.parent) return;
      syncPanelParent(group);
    });

    function isMobileNav() {
      return MOBILE_MQ.matches;
    }

    function prepareMobilePanel(panel) {
      if (!panel) return;
      panel.removeAttribute('hidden');
      panel.setAttribute('aria-hidden', 'true');
      panel.classList.remove('is-open');
    }

    function syncMobilePanels() {
      if (!isMobileNav()) return;
      groups.forEach(function (group) {
        prepareMobilePanel(group.panel);
      });
    }

    function syncDesktopPanels() {
      if (isMobileNav()) return;
      groups.forEach(function (group) {
        prepareDesktopPanel(group.panel);
      });
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

      var headerInner = getHeaderInner();
      var top = headerInner ? Math.round(headerInner.getBoundingClientRect().bottom) : 116;

      panel.style.position = 'fixed';
      panel.style.left = '50%';
      panel.style.transform = 'translateX(-50%)';
      panel.style.top = top + 'px';
      panel.style.width = Math.min(window.innerWidth - 32, 1100) + 'px';
      panel.style.zIndex = '10000';
    }

    function repositionOpenPanels() {
      if (isMobileNav()) return;
      groups.forEach(function (group) {
        if (group.parent && group.parent.classList.contains('is-open')) {
          positionPanel(group.panel);
        }
      });
    }

    function prepareDesktopPanel(panel) {
      if (!panel || isMobileNav()) return;
      panel.removeAttribute('hidden');
      panel.setAttribute('aria-hidden', 'true');
      panel.classList.remove('is-open');
    }

    function hidePanel(group) {
      if (!group.panel) return;
      group.panel.classList.remove('is-open');
      group.panel.setAttribute('aria-hidden', 'true');
    }

    function showPanel(group) {
      if (!group.panel || !group.parent) return;
      group.panel.removeAttribute('hidden');
      group.panel.setAttribute('aria-hidden', 'false');
      if (group.parent.classList.contains('is-open') && group.panel.classList.contains('is-open')) {
        return;
      }
      group.parent.classList.remove('is-open');
      group.panel.classList.remove('is-open');
      void group.panel.offsetHeight;
      group.parent.classList.add('is-open');
      group.panel.classList.add('is-open');
    }

    function cancelScheduledClose() {
      if (!hideTimer) return;
      window.clearTimeout(hideTimer);
      hideTimer = 0;
    }

    function scheduleCloseAll() {
      cancelScheduledClose();
      hideTimer = window.setTimeout(closeAll, HIDE_DELAY_MS);
    }

    function closeAll() {
      cancelScheduledClose();
      groups.forEach(function (group) {
        if (!group.parent || !group.trigger || !group.panel) return;
        group.parent.classList.remove('is-open');
        group.trigger.setAttribute('aria-expanded', 'false');
        hidePanel(group);
      });
      menu.querySelectorAll('.menu-item').forEach(function (item) {
        item.classList.remove('is-open');
      });
    }

    function openGroup(group) {
      if (!group.parent || !group.trigger || !group.panel) return;
      cancelScheduledClose();
      if (group.parent.classList.contains('is-open')) {
        positionPanel(group.panel);
        return;
      }

      groups.forEach(function (other) {
        if (other === group || !other.parent || !other.trigger || !other.panel) return;
        other.parent.classList.remove('is-open');
        other.trigger.setAttribute('aria-expanded', 'false');
        hidePanel(other);
      });

      syncPanelParent(group);
      group.trigger.setAttribute('aria-expanded', 'true');
      showPanel(group);
      positionPanel(group.panel);
    }

    groups.forEach(function (group) {
      if (!group.trigger) return;

      group.trigger.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (isMobileNav()) {
          syncPanelParent(group);
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

      function showOnHover() {
        if (isMobileNav()) return;
        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
        openGroup(group);
      }
      function hideOnHover() {
        if (isMobileNav()) return;
        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
        scheduleCloseAll();
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

    window.addEventListener('scroll', repositionOpenPanels, { passive: true });
    window.addEventListener('growtele:scroll', repositionOpenPanels, { passive: true });

    MOBILE_MQ.addEventListener('change', function () {
      groups.forEach(syncPanelParent);
      syncMobilePanels();
      syncDesktopPanels();
      closeAll();
    });

    syncMobilePanels();
    syncDesktopPanels();

    window.growteleSyncSmsNavPanels = function () {
      groups.forEach(syncPanelParent);
      syncMobilePanels();
      syncDesktopPanels();
    };
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSmsNavDropdowns);
  } else {
    initSmsNavDropdowns();
  }
})();
