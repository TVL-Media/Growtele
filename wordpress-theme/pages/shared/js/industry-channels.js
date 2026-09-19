(function () {
  'use strict';

  var SWITCH_MS = 380;

  function resolveAsset(path, hintEl) {
    if (window.growteleResolveAssetUrl) {
      return window.growteleResolveAssetUrl(path, hintEl);
    }
    return path;
  }

  function applyPhoneSrc(el, path) {
    if (!el || !path) return;
    if (window.growteleApplyAssetSrc) {
      window.growteleApplyAssetSrc(el, path);
    } else {
      el.src = resolveAsset(path, el);
    }
    if (window.growteleRefreshImagePerformance) {
      window.growteleRefreshImagePerformance(el);
    }
  }

  function usesSingleImage(channelData) {
    var paths = Object.keys(channelData || {}).map(function (key) {
      return channelData[key].image;
    });
    if (paths.length <= 1) return true;
    return paths.every(function (path) {
      return path === paths[0];
    });
  }

  window.growteleInitIndustryChannels = function initIndustryChannels(channelData) {
    var tabs = document.querySelectorAll('.channels__tab');
    if (!tabs.length) return null;

    var channelTitle = document.getElementById('channel-title');
    var channelTabDesc = document.getElementById('channel-tab-desc');
    var channelPhoneImg = document.getElementById('channel-phone-img');
    var channelPhoneImgNext = document.getElementById('channel-phone-img-next');
    var tabsContainer = document.querySelector('.channels__tabs');
    var channelPanel = document.getElementById('channel-panel');
    var channelsContent = document.querySelector('.channels__content');
    var channelActiveIndex = 0;
    var channelSwitchTimer = null;
    var singleImageMode = usesSingleImage(channelData);
    var phoneActive = channelPhoneImg;
    var phoneIdle = channelPhoneImgNext;

    if (!singleImageMode && phoneActive && !phoneIdle && phoneActive.parentNode) {
      phoneIdle = phoneActive.cloneNode(true);
      phoneIdle.id = 'channel-phone-img-next';
      phoneIdle.setAttribute('aria-hidden', 'true');
      phoneIdle.classList.remove('is-active');
      phoneActive.parentNode.appendChild(phoneIdle);
    }

    function resetIdlePhone() {
      if (!phoneIdle) return;
      phoneIdle.className = 'channels__phone-img';
      phoneIdle.removeAttribute('data-channel');
      phoneIdle.setAttribute('aria-hidden', 'true');
    }

    function normalizePhoneLayers() {
      phoneActive = channelPhoneImg;
      phoneIdle = channelPhoneImgNext;
      if (!phoneActive) return;
      if (!phoneActive.classList.contains('is-active')) {
        phoneActive.classList.add('is-active');
      }
      resetIdlePhone();
    }

    if (phoneActive && !phoneActive.classList.contains('is-active')) {
      phoneActive.classList.add('is-active');
    }

    Object.keys(channelData || {}).forEach(function (key) {
      var preload = new Image();
      preload.src = resolveAsset(channelData[key].image, phoneActive);
    });

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

    function showChannelImage(key, direction, animate) {
      var data = channelData[key];
      if (!data || !phoneActive) return;

      var modifier = 'channels__phone-img--' + key;
      var useSimpleSwap = singleImageMode || !phoneIdle || !animate;

      if (useSimpleSwap) {
        normalizePhoneLayers();
        applyPhoneSrc(phoneActive, data.image);
        phoneActive.className = 'channels__phone-img ' + modifier + ' is-active';
        phoneActive.setAttribute('data-channel', key);
        phoneActive.removeAttribute('aria-hidden');
        resetIdlePhone();
        return;
      }

      if (phoneActive.getAttribute('data-channel') === key) return;

      var incoming = phoneIdle;
      var outgoing = phoneActive;
      var fromClass = direction >= 0 ? 'is-from-down' : 'is-from-up';
      var leaveClass = direction >= 0 ? 'is-leave-up' : 'is-leave-down';

      applyPhoneSrc(incoming, data.image);
      incoming.className = 'channels__phone-img ' + modifier + ' ' + fromClass;
      incoming.setAttribute('data-channel', key);
      incoming.removeAttribute('aria-hidden');
      incoming.alt = '';

      void incoming.offsetWidth;

      incoming.classList.add('is-active');
      incoming.classList.remove('is-from-down', 'is-from-up');
      outgoing.classList.remove('is-active', 'is-from-down', 'is-from-up', 'is-leave-up', 'is-leave-down');
      outgoing.classList.add(leaveClass);
      outgoing.setAttribute('aria-hidden', 'true');

      phoneActive = incoming;
      phoneIdle = outgoing;
    }

    function setChannelContent(tab, options) {
      options = options || {};
      var key = tab.getAttribute('data-tab');
      var data = channelData[key];
      if (data) {
        if (channelTitle) channelTitle.textContent = data.title;
        if (channelTabDesc) channelTabDesc.textContent = data.desc;
        var shouldAnimateImage = options.animateImage === true && !options.force;
        showChannelImage(key, options.direction || 0, shouldAnimateImage);
      }
      if (channelsContent) {
        channelsContent.classList.toggle('channels__content--box-bg', key === 'whatsapp' || key === 'rcs');
      }
    }

    function activateChannelTab(tab, options) {
      options = options || {};
      var nextIndex = Array.prototype.indexOf.call(tabs, tab);
      if (nextIndex < 0) nextIndex = 0;
      if (nextIndex === channelActiveIndex && !options.force) return;

      if (channelSwitchTimer) {
        window.clearTimeout(channelSwitchTimer);
        channelSwitchTimer = null;
      }

      var direction = nextIndex - channelActiveIndex;
      var shouldAnimatePanel = options.animate && channelPanel && !options.immediate && !options.force;
      var shouldAnimateImage = options.animate && !options.immediate && !options.force && !singleImageMode;

      function applyState() {
        tabs.forEach(function (t) {
          t.classList.remove('channels__tab--active');
          t.setAttribute('aria-selected', 'false');
        });
        tab.classList.add('channels__tab--active');
        tab.setAttribute('aria-selected', 'true');
        setChannelContent(tab, {
          direction: direction,
          animateImage: shouldAnimateImage,
          force: options.force
        });
        channelActiveIndex = nextIndex;
        placeTabDesc(tab);
        requestAnimationFrame(function () {
          updateIndicator(tab);
        });
      }

      if (shouldAnimatePanel) {
        channelPanel.classList.add('is-switching');
        applyState();
        channelSwitchTimer = window.setTimeout(function () {
          if (channelPanel) channelPanel.classList.remove('is-switching');
          channelSwitchTimer = null;
        }, SWITCH_MS);
        return;
      }

      if (channelPanel) channelPanel.classList.remove('is-switching');
      applyState();
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        activateChannelTab(tab, { animate: true });
      });
    });

    var initialTab = document.querySelector('.channels__tab--active') || tabs[0];
    if (initialTab) {
      activateChannelTab(initialTab, { force: true });
    }

    return {
      activateChannelTab: activateChannelTab,
      getActiveIndex: function () {
        return channelActiveIndex;
      }
    };
  };
})();
