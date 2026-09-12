/**
 * Industries scroll stack —
 * starts when tab icons settle under the header (img 2 level); icons stay pinned until animation ends;
 * next card appears only after current card shrinks 30%.
 * Cards behave like pages: one scroll gesture → one card → stop.
 */
(function () {
	'use strict';

	var scrollTriggerInstance = null;
	var didInit = false;
	var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function getHeaderOffset() {
		var header = document.querySelector('.gt-header');
		if (!header) return 96;
		var rect = header.getBoundingClientRect();
		return Math.max(72, Math.round(rect.bottom > 0 ? rect.bottom + 12 : 96));
	}

	/** Pin/animate when tab row reaches the header band (img 2), not while desc is still visible (img 1). */
	function getMobileStackTriggerLine() {
		return getHeaderOffset();
	}

	function clamp01(value) {
		return Math.max(0, Math.min(1, value));
	}

	function smoothHandoffProgress(t) {
		var x = clamp01(t);
		return x * x * (3 - 2 * x);
	}

	/**
	 * Build a white-on-transparent mask from each tab icon so active tabs
	 * can use the brand gradient (banking PNG already has it; others don't).
	 */
	function prepareTabIconMasks(section) {
		var icons = section.querySelectorAll('.gt-industries__tab-icon');
		if (!icons.length) return;

		Array.prototype.forEach.call(icons, function (iconEl) {
			var img = iconEl.querySelector('img');
			if (!img) return;

			function applyMask() {
				try {
					var w = img.naturalWidth || img.width || 72;
					var h = img.naturalHeight || img.height || 72;
					if (!w || !h) return;

					var canvas = document.createElement('canvas');
					canvas.width = w;
					canvas.height = h;
					var ctx = canvas.getContext('2d', { willReadFrequently: true });
					if (!ctx) return;

					ctx.drawImage(img, 0, 0, w, h);
					var imageData = ctx.getImageData(0, 0, w, h);
					var data = imageData.data;
					var i;

					for (i = 0; i < data.length; i += 4) {
						var lum = 0.2126 * data[i] + 0.7152 * data[i + 1] + 0.0722 * data[i + 2];
						/* Black canvas bg ~0; navy strokes (~#121348) ~23; brand orange much higher */
						if (data[i + 3] < 10 || lum < 8) {
							data[i] = 0;
							data[i + 1] = 0;
							data[i + 2] = 0;
							data[i + 3] = 0;
						} else {
							data[i] = 255;
							data[i + 1] = 255;
							data[i + 2] = 255;
							data[i + 3] = 255;
						}
					}

					ctx.putImageData(imageData, 0, 0);
					iconEl.style.setProperty('--tab-icon-mask', 'url("' + canvas.toDataURL('image/png') + '")');
					iconEl.classList.add('has-mask');
				} catch (err) {
					/* Cross-origin or canvas tainted — keep <img> filter fallback */
				}
			}

			if (img.complete && img.naturalWidth) {
				applyMask();
			} else {
				img.addEventListener('load', applyMask, { once: true });
			}
		});
	}

	function initIndustriesMobile(section) {
		if (didInit) return;
		didInit = true;

		prepareTabIconMasks(section);

		var tabs = Array.prototype.slice.call(section.querySelectorAll('[data-tab]'));
		var panels = Array.prototype.slice.call(section.querySelectorAll('[data-tab-panel]'));
		var stackEl = section.querySelector('[data-industry-stack]');

		if (!tabs.length || !panels.length) return;

		section.classList.remove('gt-industries--scroll-stack');
		section.classList.add('gt-industries--mobile-tabs');

		if (stackEl) {
			stackEl.style.minHeight = 'auto';
			stackEl.style.height = 'auto';
		}

		function activate(index) {
			tabs.forEach(function (tab, i) {
				var on = i === index;
				tab.classList.toggle('is-active', on);
				tab.setAttribute('aria-selected', on ? 'true' : 'false');
			});

			panels.forEach(function (panel, i) {
				panel.classList.remove('is-stacked', 'is-entering');
				panel.style.removeProperty('--stack-depth');
				var on = i === index;
				panel.classList.toggle('is-active', on);
				panel.setAttribute('aria-hidden', on ? 'false' : 'true');
			});
		}

		tabs.forEach(function (tab, index) {
			tab.addEventListener('click', function () {
				activate(index);
			});
		});

		activate(Math.max(0, tabs.findIndex(function (tab) {
			return tab.classList.contains('is-active');
		})));

		window.dispatchEvent(new CustomEvent('growtele:industries-scroll-ready'));
	}

	function getMobileLenis() {
		return window.growteleLenis || null;
	}

	function initIndustriesMobileStack(section) {
		if (didInit) return;
		didInit = true;

		prepareTabIconMasks(section);

		var stage = section.querySelector('[data-industry-stage]');
		var tabsEl = section.querySelector('[data-tabs]');
		var tabs = Array.prototype.slice.call(section.querySelectorAll('[data-tab]'));
		var panels = Array.prototype.slice.call(section.querySelectorAll('[data-tab-panel]'));
		var stackEl = section.querySelector('[data-industry-stack]');
		var total = panels.length;
		var lastRenderedIndex = -1;
		var lastScrolledTabIndex = -1;
		var incomingPanel = null;
		var incomingEnter = 0;
		var panelHeights = [];
		var maxPanelHeight = 320;
		var stackHeightCache = 0;
		var DECK_STEP = 18;
		var DECK_SCALE_STEP = 0.03;
		var MAX_VISIBLE_PEEK = 2;
		var activePanelRef = null;
		var lastHandoffHighlightIdx = -1;
		var mobileScrollRaf = 0;
		var mobileScrollProgress = 0;
		var mobileStackSettled = false;

		if (!stage || !tabs.length || !panels.length || !stackEl) return;

		section.classList.remove('gt-industries--scroll-stack', 'gt-industries--mobile-tabs');
		section.classList.add('gt-industries--mobile-stack');
		section.style.setProperty('--stack-max', '0');
		section.style.setProperty('--deck-step', DECK_STEP + 'px');
		section.style.setProperty('--stack-band', DECK_STEP + 'px');

		panels.forEach(function (panel) {
			panel.style.filter = 'none';
			panel.style.removeProperty('visibility');
			var inner = panel.querySelector('.gt-industries__panel-inner');
			if (inner) {
				inner.style.filter = 'none';
			}
		});

		function getVisibleStackDepth(stackMax) {
			return Math.min(Math.max(0, stackMax), MAX_VISIBLE_PEEK);
		}

		function deckY(stackMax, depth) {
			var activeY = getVisibleStackDepth(stackMax) * DECK_STEP;
			if (depth === 0) {
				return activeY;
			}
			return activeY - depth * DECK_STEP;
		}

		function deckScale(depth) {
			return 1 - depth * DECK_SCALE_STEP;
		}

		function deckOpacity(depth) {
			return Math.max(0.65, 1 - depth * 0.15);
		}

		function getPanelStackDepth(panel) {
			if (!panel) {
				return 0;
			}

			var depth = parseInt(panel.style.getPropertyValue('--stack-depth'), 10);
			if (!isNaN(depth)) {
				return depth;
			}

			return parseInt(panel.dataset.stackDepth, 10) || 0;
		}

		function setPanelTransform(panel, values) {
			if (!panel) return;

			var y = values.y || 0;
			var scale = values.scale !== undefined ? values.scale : 1;
			var opacity = values.opacity !== undefined ? values.opacity : 1;
			var zIndex = values.zIndex !== undefined ? values.zIndex : 0;
			var cacheKey = y + '|' + scale + '|' + opacity + '|' + zIndex;

			if (panel._gtTransformKey === cacheKey) {
				return;
			}

			panel._gtTransformKey = cacheKey;

			if (typeof gsap !== 'undefined') {
				gsap.set(panel, {
					y: y,
					scale: scale,
					opacity: opacity,
					zIndex: zIndex,
					transformOrigin: 'center top',
					force3D: true,
					overwrite: 'auto'
				});
				return;
			}

			panel.style.transform = 'translate3d(0,' + y + 'px,0) scale(' + scale + ')';
			panel.style.opacity = String(opacity);
			panel.style.zIndex = String(zIndex);
		}

		function resetPanelTransform(panel) {
			if (!panel) return;
			delete panel._gtTransformKey;
			if (typeof gsap !== 'undefined') {
				gsap.killTweensOf(panel);
				gsap.set(panel, {
					clearProps: 'transform,opacity,zIndex'
				});
				return;
			}
			panel.style.removeProperty('transform');
			panel.style.removeProperty('opacity');
			panel.style.removeProperty('zIndex');
		}

		function measurePanelHeights() {
			section.classList.add('is-measuring');
			panelHeights = panels.map(function (panel) {
				panel.classList.add('is-measure');
				var height = panel.offsetHeight;
				panel.classList.remove('is-measure');
				return Math.max(height, 320);
			});
			maxPanelHeight = Math.max.apply(null, panelHeights.concat([320]));
			section.classList.remove('is-measuring');
			stackHeightCache = 0;
		}

		function getStackMetrics() {
			var computed = window.getComputedStyle(section);
			var stackMax = parseInt(computed.getPropertyValue('--stack-max'), 10) || 0;
			var deckStep = parseFloat(computed.getPropertyValue('--deck-step')) ||
				parseFloat(computed.getPropertyValue('--stack-band')) || 18;
			return {
				stackMax: stackMax,
				stackBand: deckStep,
				stackOffset: stackMax * deckStep
			};
		}

		function syncStackHeight(afterLayout, forceRefresh) {
			/* Fixed height avoids ScrollTrigger.refresh mid-scroll when stack index changes. */
			var height = getVisibleStackDepth(total - 1) * DECK_STEP + maxPanelHeight + 24;

			if (!forceRefresh && Math.abs(stackHeightCache - height) < 0.5) {
				if (afterLayout) {
					requestAnimationFrame(afterLayout);
				}
				return;
			}

			stackHeightCache = height;
			stackEl.style.minHeight = height + 'px';
			stackEl.style.height = height + 'px';

			if (typeof ScrollTrigger !== 'undefined') {
				requestAnimationFrame(function () {
					if (!section.classList.contains('is-scrubbing')) {
						ScrollTrigger.refresh();
					}
					if (afterLayout) {
						requestAnimationFrame(afterLayout);
					}
				});
				return;
			}

			if (afterLayout) {
				requestAnimationFrame(afterLayout);
			}
		}

		function wakeMobileStack() {
			if (!mobileStackSettled) {
				return;
			}

			mobileStackSettled = false;
			section.classList.remove('is-stack-settled');

			if (lastRenderedIndex >= 0) {
				layoutCommittedStack(lastRenderedIndex);
			}
		}

		function settleMobileStack() {
			if (mobileStackSettled) {
				return;
			}

			mobileStackSettled = true;
			section.classList.add('is-stack-settled');
			section.classList.remove('is-handoff');
			incomingPanel = null;
			incomingEnter = 0;

			panels.forEach(function (panel) {
				if (panel.classList.contains('is-stacked')) {
					resetPanelTransform(panel);
					return;
				}

				if (panel.classList.contains('is-active')) {
					setPanelTransform(panel, {
						y: 0,
						scale: 1,
						opacity: 1,
						zIndex: 40
					});
				}
			});
		}

		function clearIncoming(forceLayout) {
			var hadIncoming = !!incomingPanel || section.classList.contains('is-handoff');

			if (incomingPanel) {
				incomingPanel.classList.remove('is-incoming');
			}
			incomingPanel = null;
			incomingEnter = 0;
			section.classList.remove('is-handoff');

			if ((forceLayout || hadIncoming) && lastRenderedIndex >= 0 && !mobileStackSettled) {
				layoutCommittedStack(lastRenderedIndex);
				lastHandoffHighlightIdx = lastRenderedIndex;
				syncTabHighlight(lastRenderedIndex);
			}
		}

		function layoutCommittedStack(stackMax) {
			activePanelRef = null;

			panels.forEach(function (panel) {
				if (!panel.classList.contains('is-active') && !panel.classList.contains('is-stacked')) {
					resetPanelTransform(panel);
					return;
				}

				var depth = getPanelStackDepth(panel);

				if (panel.classList.contains('is-stacked') && depth > MAX_VISIBLE_PEEK) {
					resetPanelTransform(panel);
					return;
				}

				if (depth === 0) {
					activePanelRef = panel;
					setPanelTransform(panel, {
						y: deckY(stackMax, 0),
						scale: 1,
						opacity: 1,
						zIndex: 30 + stackMax
					});
					return;
				}

				setPanelTransform(panel, {
					y: deckY(stackMax, depth),
					scale: deckScale(depth),
					opacity: deckOpacity(depth),
					zIndex: 20 + stackMax - depth
				});
			});
		}

		function isTabFullyVisible(tab) {
			if (!tabsEl || !tab) {
				return true;
			}

			var pad = 8;
			var tabRect = tab.getBoundingClientRect();
			var navRect = tabsEl.getBoundingClientRect();

			return tabRect.left >= navRect.left + pad && tabRect.right <= navRect.right - pad;
		}

		function getTabScrollTarget(index) {
			var tab = tabs[index];
			if (!tabsEl || !tab) {
				return null;
			}

			if (isTabFullyVisible(tab)) {
				return tabsEl.scrollLeft;
			}

			var maxScroll = Math.max(0, tabsEl.scrollWidth - tabsEl.clientWidth);
			var tabRect = tab.getBoundingClientRect();
			var navRect = tabsEl.getBoundingClientRect();
			var targetScroll = tabsEl.scrollLeft;
			var pad = 8;

			if (tabRect.left < navRect.left + pad) {
				targetScroll -= navRect.left + pad - tabRect.left;
			} else if (tabRect.right > navRect.right - pad) {
				targetScroll += tabRect.right - (navRect.right - pad);
			}

			return Math.min(maxScroll, Math.max(0, targetScroll));
		}

		function scrollActiveTabIntoView(index, forceSmooth) {
			if (!tabsEl || !tabs[index]) {
				return;
			}

			var tab = tabs[index];
			if (index === lastScrolledTabIndex && isTabFullyVisible(tab)) {
				return;
			}

			var targetScroll = getTabScrollTarget(index);
			if (targetScroll === null || Math.abs(tabsEl.scrollLeft - targetScroll) < 2) {
				lastScrolledTabIndex = index;
				return;
			}

			lastScrolledTabIndex = index;
			var useSmooth = forceSmooth && !prefersReducedMotion && !section.classList.contains('is-scrubbing');
			tabsEl.scrollTo({
				left: targetScroll,
				behavior: useSmooth ? 'smooth' : 'auto'
			});
		}

		function syncTabHighlight(activeIdx) {
			tabs.forEach(function (tab, tabIndex) {
				var on = tabIndex === activeIdx;
				tab.classList.toggle('is-active', on);
				tab.setAttribute('aria-selected', on ? 'true' : 'false');
			});
		}

		function buildStackState(index) {
			var idx = Math.max(0, Math.min(total - 1, index));

			if (idx === lastRenderedIndex) {
				return;
			}

			lastRenderedIndex = idx;
			var stackKeys = [];

			for (var i = 0; i <= idx; i++) {
				stackKeys.push(panels[i].dataset.tabPanel);
			}

			panels.forEach(function (panel) {
				var key = panel.dataset.tabPanel;
				var keyIdx = stackKeys.indexOf(key);

				panel.classList.remove('is-active', 'is-stacked', 'is-stack-top', 'is-entering', 'is-incoming');
				panel.style.removeProperty('--stack-depth');
				delete panel.dataset.stackDepth;

				if (keyIdx === -1) {
					panel.setAttribute('aria-hidden', 'true');
					resetPanelTransform(panel);
					return;
				}

				var depthFromTop = stackKeys.length - 1 - keyIdx;
				var maxStackDepth = idx;
				var peekTopDepth = Math.min(maxStackDepth, MAX_VISIBLE_PEEK);
				panel.setAttribute('aria-hidden', depthFromTop === 0 ? 'false' : 'true');
				panel.style.setProperty('--stack-depth', String(depthFromTop));
				panel.dataset.stackDepth = String(depthFromTop);

				if (depthFromTop === 0) {
					panel.classList.add('is-active');
				} else if (depthFromTop <= MAX_VISIBLE_PEEK) {
					panel.classList.add('is-stacked');
					if (depthFromTop === peekTopDepth) {
						panel.classList.add('is-stack-top');
					}
				} else {
					panel.setAttribute('aria-hidden', 'true');
					resetPanelTransform(panel);
				}
			});

			syncTabHighlight(idx);

			section.style.setProperty('--stack-max', String(idx));
			layoutCommittedStack(idx);
			syncStackHeight(function () {
				scrollActiveTabIntoView(idx, false);
			});
		}

		function applyHandoffVisual(nextPanel, enter) {
			if (!nextPanel || !activePanelRef) {
				return;
			}

			var easedEnter = section.classList.contains('is-scrubbing')
				? clamp01(enter)
				: smoothHandoffProgress(enter);
			var stackMax = lastRenderedIndex;
			var activeY = deckY(stackMax, 0);
			var targetY = deckY(stackMax + 1, 0);
			var activeH = panelHeights[lastRenderedIndex] || maxPanelHeight;
			var startOffset = Math.max(0, activeY + activeH - targetY);
			var incomingY = targetY + startOffset * (1 - easedEnter);

			section.classList.toggle('is-handoff', easedEnter > 0.001);
			nextPanel.setAttribute('aria-hidden', easedEnter > 0.42 ? 'false' : 'true');

			setPanelTransform(activePanelRef, {
				y: activeY - easedEnter * 10,
				scale: 1 - easedEnter * 0.028,
				opacity: 1 - easedEnter * 0.1,
				zIndex: 30 + stackMax
			});

			setPanelTransform(nextPanel, {
				y: incomingY,
				scale: 0.978 + easedEnter * 0.022,
				opacity: 1,
				zIndex: 40 + stackMax
			});

			var incomingIdx = panels.indexOf(nextPanel);
			var highlightIdx = easedEnter > 0.42 ? incomingIdx : lastRenderedIndex;

			if (highlightIdx !== lastHandoffHighlightIdx) {
				lastHandoffHighlightIdx = highlightIdx;
				syncTabHighlight(highlightIdx);
			}
		}

		function setIncomingState(nextPanel, enter) {
			if (!nextPanel) {
				clearIncoming();
				return;
			}

			if (incomingPanel !== nextPanel) {
				if (incomingPanel) {
					incomingPanel.classList.remove('is-incoming');
					resetPanelTransform(incomingPanel);
				}
				incomingPanel = nextPanel;
				incomingPanel.classList.add('is-incoming');

				var incomingIdx = panels.indexOf(nextPanel);
				if (incomingIdx >= 4) {
					lastScrolledTabIndex = -1;
					requestAnimationFrame(function () {
						scrollActiveTabIntoView(incomingIdx, false);
					});
				}
			}

			incomingEnter = enter;
			applyHandoffVisual(nextPanel, enter);
		}

		function updateMobileStackScroll(progress) {
			if (mobileStackSettled) {
				return;
			}

			if (total <= 1) {
				clearIncoming(true);
				buildStackState(0);
				return;
			}

			var scaled = progress * (total - 1);
			var idx = Math.min(total - 1, Math.floor(scaled + 0.0001));
			var local = clamp01(scaled - idx);

			if (idx >= total - 1) {
				if (incomingPanel || section.classList.contains('is-handoff')) {
					clearIncoming(true);
				}
				if (lastRenderedIndex !== total - 1) {
					wakeMobileStack();
					buildStackState(total - 1);
				}
				return;
			}

			if (lastRenderedIndex !== idx) {
				clearIncoming(true);
				buildStackState(idx);
			}

			if (local <= 0.001) {
				if (incomingPanel) {
					clearIncoming(true);
				}
				return;
			}

			setIncomingState(panels[idx + 1], local);
		}

		function scrollToMobileCard(index) {
			lastScrolledTabIndex = -1;
			wakeMobileStack();
			if (!scrollTriggerInstance || total <= 1) {
				buildStackState(index);
				requestAnimationFrame(function () {
					scrollActiveTabIntoView(index, true);
				});
				return;
			}

			var targetProgress = index / (total - 1);
			var targetY = scrollTriggerInstance.start +
				(scrollTriggerInstance.end - scrollTriggerInstance.start) * targetProgress;
			var lenis = getMobileLenis();

			if (lenis && typeof lenis.scrollTo === 'function') {
				lenis.scrollTo(targetY, { duration: 1.15 });
				return;
			}

			window.scrollTo({ top: targetY, behavior: 'smooth' });
		}

		buildStackState(Math.max(0, tabs.findIndex(function (tab) {
			return tab.classList.contains('is-active');
		})));
		measurePanelHeights();

		tabs.forEach(function (tab, index) {
			tab.addEventListener('click', function () {
				scrollToMobileCard(index);
			});
		});

		if (
			!prefersReducedMotion &&
			typeof gsap !== 'undefined' &&
			typeof ScrollTrigger !== 'undefined'
		) {
			gsap.registerPlugin(ScrollTrigger);

			scrollTriggerInstance = ScrollTrigger.create({
				trigger: tabsEl,
				start: function () {
					return 'top ' + getMobileStackTriggerLine() + 'px';
				},
				end: function () {
					return '+=' + Math.max((total - 1) * 48, 260) + '%';
				},
				pin: stage,
				pinSpacing: true,
				scrub: true,
				anticipatePin: 1,
				invalidateOnRefresh: true,
				onEnter: function () {
					wakeMobileStack();
					section.classList.add('is-scrubbing');
				},
				onEnterBack: function () {
					wakeMobileStack();
					section.classList.add('is-scrubbing');
				},
				onLeave: function () {
					section.classList.remove('is-scrubbing');
					if (lastRenderedIndex !== total - 1) {
						buildStackState(total - 1);
					}
					clearIncoming(true);
					settleMobileStack();
				},
				onLeaveBack: function () {
					section.classList.remove('is-scrubbing');
					wakeMobileStack();
				},
				onUpdate: function (self) {
					mobileScrollProgress = self.progress;
					if (mobileScrollRaf) {
						return;
					}
					mobileScrollRaf = requestAnimationFrame(function () {
						mobileScrollRaf = 0;
						updateMobileStackScroll(mobileScrollProgress);
					});
				},
				onRefresh: function () {
					measurePanelHeights();
					syncStackHeight();
				},
			});
		}

		window.addEventListener('resize', function () {
			measurePanelHeights();
			syncStackHeight();
		}, { passive: true });

		requestAnimationFrame(function () {
			if (typeof ScrollTrigger !== 'undefined') {
				ScrollTrigger.refresh();
			}
			window.dispatchEvent(new CustomEvent('growtele:industries-scroll-ready'));
		});
	}

	function initIndustriesScroll() {
		if (didInit) {
			if (typeof ScrollTrigger !== 'undefined') {
				ScrollTrigger.refresh();
			}
			return;
		}

		var section = document.querySelector('.gt-industries');
		if (!section) return;

		if (window.matchMedia('(max-width: 1024px)').matches) {
			initIndustriesMobileStack(section);
			return;
		}

		prepareTabIconMasks(section);

		var stage = section.querySelector('[data-industry-stage]');
		var tabsEl = section.querySelector('[data-tabs]');
		var tabs = Array.prototype.slice.call(section.querySelectorAll('[data-tab]'));
		var panels = Array.prototype.slice.call(section.querySelectorAll('[data-tab-panel]'));
		var stackEl = section.querySelector('[data-industry-stack]');

		if (!stage || !tabsEl || !tabs.length || !panels.length || !stackEl) return;

		var total = panels.length;
		var currentIndex = 0;
		var pageIndex = 0;
		var isPaging = false;
		var pinActive = false;
		var phaseCount = Math.max(total - 1, 1) * 2;
		var PAGE_DURATION = 0.7;
		var touchStartY = null;
		var touchStartX = null;
		/*
		 * Wheel gate with a hard cap:
		 * - absorb trackpad inertia so one swipe ≠ multiple cards
		 * - never block the user forever (retries always work after MAX)
		 * NOTE: never call lenis.stop() — it freezes ScrollTrigger site-wide.
		 */
		var ignoreWheelUntil = 0;
		var pageStepAt = 0;
		var WHEEL_COOLDOWN_MS = 650;
		var WHEEL_INERTIA_EXTEND_MS = 140;
		var WHEEL_LOCK_MAX_MS = 950;

		section.classList.add('gt-industries--scroll-stack');

		function fitStackToViewport() {
			var headerOffset = getHeaderOffset();
			var tabsHeight = tabsEl.offsetHeight || 90;
			var gap = 16;
			var available = window.innerHeight - headerOffset - tabsHeight - gap;
			var height;

			height = Math.min(520, Math.max(340, available));

			stackEl.style.minHeight = height + 'px';
			stackEl.style.height = height + 'px';
			section.style.setProperty('--gt-industry-card-h', height + 'px');
		}

		function syncStackHeight() {
			fitStackToViewport();
		}

		function setTabActive(index) {
			tabs.forEach(function (tab, i) {
				var on = i === index;
				tab.classList.toggle('is-active', on);
				tab.setAttribute('aria-selected', on ? 'true' : 'false');
			});
		}

		function setPanelClasses(index) {
			panels.forEach(function (panel, i) {
				panel.classList.remove('is-active', 'is-stacked', 'is-entering');
				panel.style.removeProperty('--stack-depth');

				if (i === index) {
					panel.classList.add('is-active');
					panel.setAttribute('aria-hidden', 'false');
				} else if (i === index - 1) {
					panel.classList.add('is-stacked');
					panel.style.setProperty('--stack-depth', '1');
					panel.setAttribute('aria-hidden', 'true');
				} else {
					panel.setAttribute('aria-hidden', 'true');
				}
			});
		}

		function indexFromProgress(progress) {
			if (total <= 1) return 0;
			var raw = progress * phaseCount;
			return Math.min(total - 1, Math.max(0, Math.floor((raw + 1) / 2)));
		}

		function nearestIndexFromProgress(progress) {
			if (total <= 1) return 0;
			var steps = total - 1;
			return Math.min(total - 1, Math.max(0, Math.round(progress * steps)));
		}

		function progressForIndex(index) {
			return total <= 1 ? 0 : index / (total - 1);
		}

		function getLenis() {
			return window.growteleLenis || null;
		}

		function getScrollY() {
			var lenis = getLenis();
			if (lenis) return lenis.scroll;
			return window.scrollY || window.pageYOffset || 0;
		}

		function scrollYForIndex(index) {
			if (!scrollTriggerInstance) return 0;
			var start = scrollTriggerInstance.start;
			var end = scrollTriggerInstance.end;
			return start + (end - start) * progressForIndex(index);
		}

		var pageSafetyTimer = null;

		function isPinLive() {
			return !!(scrollTriggerInstance && scrollTriggerInstance.isActive);
		}

		/** Kill inertia without stopping Lenis (stop() breaks all ScrollTriggers). */
		function killLenisMomentum() {
			var lenis = getLenis();
			if (!lenis) return;
			try {
				lenis.scrollTo(lenis.scroll, { immediate: true });
			} catch (err) {
				/* ignore */
			}
		}

		function ensureLenisRunning() {
			var lenis = getLenis();
			if (!lenis) return;
			if (typeof lenis.isStopped === 'boolean' && lenis.isStopped) {
				lenis.start();
			}
		}

		function syncPinState() {
			if (isPinLive()) {
				pinActive = true;
				return true;
			}
			/* Left the pin — never keep wheel hijack alive */
			pinActive = false;
			isPaging = false;
			ignoreWheelUntil = 0;
			pageStepAt = 0;
			if (pageSafetyTimer) {
				clearTimeout(pageSafetyTimer);
				pageSafetyTimer = null;
			}
			ensureLenisRunning();
			return false;
		}

		function beginWheelLock() {
			pageStepAt = performance.now();
			ignoreWheelUntil = pageStepAt + WHEEL_COOLDOWN_MS;
		}

		function absorbWheelInertia() {
			var now = performance.now();
			var maxUntil = pageStepAt + WHEEL_LOCK_MAX_MS;
			if (now >= maxUntil) return false;
			ignoreWheelUntil = Math.min(now + WHEEL_INERTIA_EXTEND_MS, maxUntil);
			return true;
		}

		function isWheelBlocked() {
			return isPaging || performance.now() < ignoreWheelUntil;
		}

		function goToPage(index, immediate) {
			if (!scrollTriggerInstance) return;
			index = Math.max(0, Math.min(total - 1, index));

			if (isPaging && !immediate) return;

			var target = scrollYForIndex(index);
			pageIndex = index;
			isPaging = !immediate;

			var settled = false;
			function finish() {
				if (settled) return;
				settled = true;
				if (pageSafetyTimer) {
					clearTimeout(pageSafetyTimer);
					pageSafetyTimer = null;
				}
				isPaging = false;
				currentIndex = index;
				pageIndex = index;
				setTabActive(index);
				setPanelClasses(index);
				ensureLenisRunning();
				if (isPinLive()) {
					pinActive = true;
					killLenisMomentum();
				} else {
					syncPinState();
				}
				/* Cooldown only after a real page tween — not pin enter snap */
				if (!immediate) beginWheelLock();
			}

			if (immediate) {
				var lenisImm = getLenis();
				if (lenisImm) {
					ensureLenisRunning();
					lenisImm.scrollTo(target, { immediate: true });
					if (isPinLive()) pinActive = true;
				} else {
					window.scrollTo(0, target);
				}
				finish();
				return;
			}

			/* If Lenis never calls onComplete, unlock so the page can't soft-lock */
			pageSafetyTimer = setTimeout(finish, (PAGE_DURATION + 0.45) * 1000);

			var lenis = getLenis();
			if (lenis) {
				ensureLenisRunning();
				lenis.scrollTo(target, {
					duration: PAGE_DURATION,
					easing: function (t) {
						return 1 - Math.pow(1 - t, 3);
					},
					lock: true,
					onComplete: finish,
				});
			} else {
				var state = { y: getScrollY() };
				gsap.to(state, {
					y: target,
					duration: PAGE_DURATION,
					ease: 'power2.inOut',
					onUpdate: function () {
						window.scrollTo(0, state.y);
					},
					onComplete: finish,
				});
			}
		}

		function releasePin(direction) {
			pinActive = false;
			isPaging = false;
			ignoreWheelUntil = 0;
			pageStepAt = 0;
			if (pageSafetyTimer) {
				clearTimeout(pageSafetyTimer);
				pageSafetyTimer = null;
			}
			ensureLenisRunning();

			var lenis = getLenis();
			var st = scrollTriggerInstance;
			if (!st) return;

			if (direction > 0) {
				var downTarget = st.end + 24;
				if (lenis) {
					lenis.scrollTo(downTarget, { duration: 0.55 });
				} else {
					window.scrollTo({ top: downTarget, behavior: 'smooth' });
				}
			} else if (direction < 0) {
				var upTarget = Math.max(0, st.start - 24);
				if (lenis) {
					lenis.scrollTo(upTarget, { duration: 0.55 });
				} else {
					window.scrollTo({ top: upTarget, behavior: 'smooth' });
				}
			}
		}

		function tryPageStep(direction) {
			if (!scrollTriggerInstance || !direction) return false;
			if (!syncPinState()) return false;
			if (isWheelBlocked()) {
				absorbWheelInertia();
				return true;
			}

			var next = pageIndex + direction;

			if (next < 0) {
				releasePin(-1);
				return true;
			}
			if (next >= total) {
				releasePin(1);
				return true;
			}

			beginWheelLock();
			goToPage(next, false);
			return true;
		}

		// function onWheel(event) {
		// 	if (!scrollTriggerInstance || prefersReducedMotion) return;

		// 	/* Source of truth is ScrollTrigger — never hijack outside the pin */
		// 	if (!syncPinState()) return;

		// 	var direction = event.deltaY > 0 ? 1 : event.deltaY < 0 ? -1 : 0;
		// 	if (!direction) return;

		// 	/* Always take over wheel while pinned — one gesture = one card */
		// 	event.preventDefault();
		// 	event.stopImmediatePropagation();

		// 	tryPageStep(direction);
		// }

		function onTouchStart(event) {
			if (!event.touches || !event.touches[0]) return;
			touchStartY = event.touches[0].clientY;
			touchStartX = event.touches[0].clientX;
		}

		function onTouchEnd(event) {
			if (touchStartY === null || !scrollTriggerInstance || prefersReducedMotion) {
				touchStartY = null;
				return;
			}
			if (!syncPinState()) {
				touchStartY = null;
				return;
			}
			if (!event.changedTouches || !event.changedTouches[0]) {
				touchStartY = null;
				return;
			}

			var dy = touchStartY - event.changedTouches[0].clientY;
			var dx = touchStartX - event.changedTouches[0].clientX;
			touchStartY = null;
			touchStartX = null;

			if (Math.abs(dy) < 40 || Math.abs(dy) < Math.abs(dx)) return;

			var direction = dy > 0 ? 1 : -1;
			tryPageStep(direction);
		}

		function initTabFallback() {
			var stackOrder = [];

			function renderStack(targetKey, animate) {
				var existing = stackOrder.indexOf(targetKey);
				if (existing !== -1) stackOrder.splice(existing, 1);
				stackOrder.push(targetKey);

				var visible = stackOrder.slice(-3);

				panels.forEach(function (panel) {
					var key = panel.dataset.tabPanel;
					var idx = visible.indexOf(key);
					var depthFromTop = idx === -1 ? -1 : visible.length - 1 - idx;

					panel.classList.remove('is-active', 'is-stacked', 'is-entering');
					panel.style.removeProperty('--stack-depth');

					if (depthFromTop === -1) {
						panel.setAttribute('aria-hidden', 'true');
						return;
					}

					panel.setAttribute('aria-hidden', depthFromTop === 0 ? 'false' : 'true');
					panel.style.setProperty('--stack-depth', String(depthFromTop));

					if (depthFromTop === 0) {
						panel.classList.add('is-active');
						if (animate) {
							void panel.offsetWidth;
							panel.classList.add('is-entering');
						}
					} else {
						panel.classList.add('is-stacked');
					}
				});

				syncStackHeight();
			}

			var initial = section.querySelector('.gt-industries__tab.is-active');
			var initialKey = (initial && initial.dataset.tab) || panels[0].dataset.tabPanel;
			renderStack(initialKey, false);

			tabs.forEach(function (tab) {
				tab.addEventListener('click', function () {
					if (tab.dataset.tab === stackOrder[stackOrder.length - 1]) return;
					tabs.forEach(function (t) {
						t.classList.toggle('is-active', t === tab);
						t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
					});
					renderStack(tab.dataset.tab, true);
				});
			});

			window.addEventListener('resize', syncStackHeight, { passive: true });
			syncStackHeight();
		}

		if (
			prefersReducedMotion ||
			typeof gsap === 'undefined' ||
			typeof ScrollTrigger === 'undefined'
		) {
			section.classList.remove('gt-industries--scroll-stack');
			initTabFallback();
			didInit = true;
			return;
		}

		didInit = true;
		gsap.registerPlugin(ScrollTrigger);

		fitStackToViewport();

		panels.forEach(function (panel, i) {
			var inner = panel.querySelector('.gt-industries__panel-inner');
			panel._inner = inner;
			gsap.set(panel, {
				yPercent: i === 0 ? 0 : 130,
				scale: 1,
				opacity: 1,
				zIndex: i === 0 ? 40 : 1,
				visibility: i === 0 ? 'visible' : 'hidden',
				transformOrigin: '50% 50%',
				force3D: true,
			});
			if (inner) {
				gsap.set(inner, { filter: 'blur(0px)' });
			}
		});
		setTabActive(0);
		setPanelClasses(0);

		var tl = gsap.timeline({
			defaults: { ease: 'none' },
			scrollTrigger: {
				trigger: stage,
				start: 'top top',
				end: function () {
					return '+=' + Math.max(total * 110, 560) + '%';
				},
				pin: true,
				pinSpacing: true,
				scrub: true,
				anticipatePin: 1,
				invalidateOnRefresh: true,
				onRefresh: fitStackToViewport,
				onEnter: function () {
					pinActive = true;
					isPaging = false;
					ignoreWheelUntil = 0;
					pageStepAt = 0;
					ensureLenisRunning();
					goToPage(0, true);
					killLenisMomentum();
				},
				onEnterBack: function () {
					if (window.__growteleGoHero) {
						return;
					}
					pinActive = true;
					isPaging = false;
					ignoreWheelUntil = 0;
					pageStepAt = 0;
					ensureLenisRunning();
					goToPage(total - 1, true);
					killLenisMomentum();
				},
				onLeave: function () {
					pinActive = false;
					isPaging = false;
					ignoreWheelUntil = 0;
					pageStepAt = 0;
					if (pageSafetyTimer) {
						clearTimeout(pageSafetyTimer);
						pageSafetyTimer = null;
					}
					ensureLenisRunning();
				},
				onLeaveBack: function () {
					pinActive = false;
					isPaging = false;
					ignoreWheelUntil = 0;
					pageStepAt = 0;
					if (pageSafetyTimer) {
						clearTimeout(pageSafetyTimer);
						pageSafetyTimer = null;
					}
					ensureLenisRunning();
				},
				onToggle: function (self) {
					if (!self.isActive) {
						pinActive = false;
						isPaging = false;
						ignoreWheelUntil = 0;
						ensureLenisRunning();
					}
				},
				onUpdate: function (self) {
					var idx = indexFromProgress(self.progress);
					if (idx !== currentIndex) {
						currentIndex = idx;
						/* Keep page index aligned when not mid-tween */
						if (!isPaging) pageIndex = idx;
						setTabActive(idx);
						setPanelClasses(idx);
					}
				},
			},
		});

		scrollTriggerInstance = tl.scrollTrigger;

		for (var i = 0; i < total - 1; i++) {
			var current = panels[i];
			var next = panels[i + 1];
			var currentInner = current._inner;
			var nextInner = next._inner;
			var shrinkAt = i * 2;
			var revealAt = i * 2 + 1;

			tl.set(
				next,
				{
					yPercent: 130,
					scale: 1,
					opacity: 1,
					visibility: 'hidden',
					zIndex: 1,
				},
				shrinkAt
			);
			if (nextInner) {
				tl.set(nextInner, { filter: 'blur(0px)' }, shrinkAt);
			}

			tl.to(
				current,
				{
					yPercent: -4,
					scale: 0.82,
					opacity: 1,
					zIndex: 20,
					duration: 1,
				},
				shrinkAt
			);
			if (currentInner) {
				tl.to(currentInner, { filter: 'blur(0px)', duration: 1 }, shrinkAt);
			}

			for (var j = 0; j < i; j++) {
				var oldPanel = panels[j];
				var oldInner = oldPanel._inner;
				tl.set(
					oldPanel,
					{
						opacity: 0,
						visibility: 'hidden',
						zIndex: 1,
					},
					shrinkAt
				);
				if (oldInner) {
					tl.set(oldInner, { filter: 'blur(14px)' }, shrinkAt);
				}
			}

			/* Incoming slides in — stays sharp, full opacity */
			tl.set(
				next,
				{
					zIndex: 50,
					visibility: 'visible',
					opacity: 1,
				},
				revealAt
			);
			if (nextInner) {
				tl.set(nextInner, { filter: 'blur(0px)' }, revealAt);
			}

			tl.set(
				current,
				{
					zIndex: 8,
					visibility: 'visible',
					opacity: 1,
				},
				revealAt
			);

			tl.to(
				next,
				{
					yPercent: 0,
					scale: 1,
					duration: 1,
				},
				revealAt
			);

			/* Outgoing stays visible while incoming arrives, then blurs + fades out */
			tl.to(
				current,
				{
					yPercent: -6,
					scale: 0.76,
					opacity: 0.4,
					duration: 0.75,
				},
				revealAt
			);
			if (currentInner) {
				tl.to(currentInner, { filter: 'blur(8px)', duration: 0.75 }, revealAt);
			}

			tl.to(
				current,
				{
					yPercent: -10,
					scale: 0.68,
					opacity: 0,
					duration: 0.25,
				},
				revealAt + 0.75
			);
			if (currentInner) {
				tl.to(currentInner, { filter: 'blur(14px)', duration: 0.25 }, revealAt + 0.75);
			}

			tl.set(
				current,
				{
					visibility: 'hidden',
					zIndex: 1,
				},
				revealAt + 1
			);
		}

		tabs.forEach(function (tab, index) {
			tab.addEventListener('click', function () {
				if (!scrollTriggerInstance) return;
				if (index === pageIndex && !isPaging) return;
				pinActive = true;
				goToPage(index, false);
			});
		});

		// window.addEventListener('wheel', onWheel, { passive: false, capture: true });
		// window.addEventListener('touchstart', onTouchStart, { passive: true, capture: true });
		// window.addEventListener('touchend', onTouchEnd, { passive: true, capture: true });

		window.addEventListener(
			'resize',
			function () {
				fitStackToViewport();
				ScrollTrigger.refresh();
			},
			{ passive: true }
		);

		window.addEventListener('growtele:go-hero', function () {
			pinActive = false;
			isPaging = false;
			ignoreWheelUntil = 0;
			pageStepAt = 0;
			currentIndex = 0;
			pageIndex = 0;
			setTabActive(0);
			setPanelClasses(0);
		});

		ensureLenisRunning();
		ScrollTrigger.refresh();
		/* Let other scrub animations (channels) re-measure after pin-spacer exists */
		requestAnimationFrame(function () {
			ensureLenisRunning();
			ScrollTrigger.refresh();
			window.dispatchEvent(new CustomEvent('growtele:industries-scroll-ready'));
		});
	}

	function boot() {
		var started = false;

		function start() {
			if (started) return;
			started = true;
			initIndustriesScroll();
		}

		/* Prefer Lenis+scrollerProxy ready first so pin math matches smooth scroll */
		window.addEventListener('growtele:smooth-scroll-ready', start, { once: true });
		setTimeout(start, 600);

		if (typeof ScrollTrigger !== 'undefined') {
			window.addEventListener('load', function () {
				ScrollTrigger.refresh();
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
