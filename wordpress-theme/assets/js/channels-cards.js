/**
 * Channels cards — fan opens to flat row, scrubbed to scroll (no pin)
 *
 * @package Growtele
 */
(function () {
	'use strict';

	var didInit = false;
	var channelTriggers = [];
	var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var MOBILE_MQ = window.matchMedia('(max-width: 1024px)');
	var CARD_W = 290;
	var CARD_H = 420;

	function isMobileViewport() {
		return MOBILE_MQ.matches;
	}

	function lerp(a, b, t) {
		return a + (b - a) * t;
	}

	function killChannelTriggers() {
		channelTriggers.forEach(function (entry) {
			if (entry && entry.trigger && typeof entry.trigger.kill === 'function') {
				entry.trigger.kill();
			}
		});
		channelTriggers = [];
	}

	function refreshChannels() {
		if (isMobileViewport()) {
			resetChannelsMobileLayout();
			return;
		}

		if (typeof ScrollTrigger === 'undefined') return;
		if (didInit) {
			didInit = false;
			killChannelTriggers();
			initChannelsCards();
			return;
		}
		ScrollTrigger.refresh();
	}

	function resetChannelsMobileLayout() {
		document.querySelectorAll('.gt-channels .cards-wrapper').forEach(function (wrapper) {
			var section = wrapper.closest('.gt-channels');
			if (section) {
				section.style.marginBottom = '40px';
			}

			wrapper.style.height = 'auto';
			wrapper.style.minHeight = '0';
			wrapper.style.perspective = 'none';
			wrapper.style.transform = 'none';
			wrapper.style.display = 'flex';
			wrapper.style.flexDirection = 'row';
			wrapper.style.alignItems = 'stretch';
			wrapper.style.gap = '16px';
			wrapper.style.overflowX = 'auto';
			wrapper.style.overflowY = 'hidden';
			wrapper.style.webkitOverflowScrolling = 'touch';
			wrapper.style.scrollSnapType = 'x mandatory';
			wrapper.style.padding = '4px var(--gt-container-padding, 20px) 16px';
			wrapper.style.scrollbarWidth = 'none';
			wrapper.classList.add('is-mobile-layout');

			wrapper.querySelectorAll('.card').forEach(function (card) {
				if (typeof gsap !== 'undefined') {
					gsap.killTweensOf(card);
					gsap.set(card, { clearProps: 'transform,left,top,right,bottom,width,height,scale,x,y,rotation' });
				}

				card.removeAttribute('style');
				card.style.position = 'relative';
				card.style.flex = '0 0 min(82vw, 280px)';
				card.style.scrollSnapAlign = 'center';
				card.style.left = 'auto';
				card.style.top = 'auto';
				card.style.right = 'auto';
				card.style.transform = 'none';
				card.style.width = 'min(82vw, 280px)';
				card.style.maxWidth = '280px';
				card.style.minWidth = '0';
				card.style.height = 'auto';
				card.style.minHeight = '0';
				card.style.margin = '0';
			});
		});
	}

	function initChannelsCards() {
		if (didInit) return;

		if (
			prefersReducedMotion ||
			isMobileViewport() ||
			typeof gsap === 'undefined' ||
			typeof ScrollTrigger === 'undefined'
		) {
			resetChannelsMobileLayout();
			didInit = true;
			return;
		}

		var wrappers = document.querySelectorAll('.gt-channels .cards-wrapper');
		if (!wrappers.length) return;

		didInit = true;
		gsap.registerPlugin(ScrollTrigger);
		channelTriggers = [];

		wrappers.forEach(function (wrapper) {
			var card1 = wrapper.querySelector('.card-1');
			var card2 = wrapper.querySelector('.card-2');
			var active = wrapper.querySelector('.active');
			var card4 = wrapper.querySelector('.card-4');
			var card5 = wrapper.querySelector('.card-5');

			if (!card1 || !card2 || !active || !card4 || !card5) return;

			var map = [
				{ el: card1, key: 'card1' },
				{ el: card2, key: 'card2' },
				{ el: active, key: 'active' },
				{ el: card4, key: 'card4' },
				{ el: card5, key: 'card5' },
			];

			/* Lock box size so GSAP scale never "squishes" a single card */
			map.forEach(function (item) {
				item.el.style.width = CARD_W + 'px';
				item.el.style.height = CARD_H + 'px';
				item.el.style.maxWidth = CARD_W + 'px';
				item.el.style.flexShrink = '0';
			});

			function layout() {
				var WRAPPER_W = wrapper.offsetWidth || 1200;
				var STEP_FAN = Math.min(180, Math.max(110, (WRAPPER_W - CARD_W) / 4.6));
				var fanStart = (WRAPPER_W - (STEP_FAN * 4 + CARD_W)) / 2;

				/*
				 * Open row: smaller cards + clear gaps (like reference).
				 * Scale from center — compensate left so visual gaps stay even.
				 */
				var OPEN_SCALE = 0.88;
				var OPEN_GAP = 20;
				var maxRow = WRAPPER_W - 32;
				var needed = CARD_W * OPEN_SCALE * 5 + OPEN_GAP * 4;
				if (needed > maxRow) {
					OPEN_SCALE = Math.max(0.68, (maxRow - OPEN_GAP * 4) / (CARD_W * 5));
				}
				var visualW = CARD_W * OPEN_SCALE;
				var stackStep = visualW + OPEN_GAP;
				var totalStackWidth = visualW * 5 + OPEN_GAP * 4;
				var stackStart = Math.max(16, (WRAPPER_W - totalStackWidth) / 2);
				/* Keep open row near the top — avoid a large gap under the heading */
				var stackTop = 12;

				function stackPos(index, zIndex) {
					var visualLeft = stackStart + index * stackStep;
					var left = visualLeft - (CARD_W * (1 - OPEN_SCALE)) / 2;
					return {
						left: left,
						top: stackTop,
						rotation: 0,
						scale: OPEN_SCALE,
						zIndex: zIndex,
					};
				}

				return {
					fan: {
						card1: { left: fanStart, top: 70, rotation: -10, scale: 1, zIndex: 1 },
						card2: { left: fanStart + STEP_FAN, top: 35, rotation: -5, scale: 1, zIndex: 2 },
						active: { left: fanStart + STEP_FAN * 2, top: 0, rotation: 0, scale: 1.08, zIndex: 5 },
						card4: { left: fanStart + STEP_FAN * 3, top: 35, rotation: 5, scale: 1, zIndex: 2 },
						card5: { left: fanStart + STEP_FAN * 4, top: 70, rotation: 10, scale: 1, zIndex: 1 },
					},
					stack: {
						card1: stackPos(0, 1),
						card2: stackPos(1, 2),
						active: stackPos(2, 5),
						card4: stackPos(3, 2),
						card5: stackPos(4, 1),
					},
				};
			}

			function setCardProps(el, p, animate, duration) {
				var props = {
					left: p.left,
					top: p.top,
					rotation: p.rotation,
					scaleX: p.scale,
					scaleY: p.scale,
					zIndex: p.zIndex,
					width: CARD_W,
					height: CARD_H,
					x: 0,
					y: 0,
					force3D: true,
				};

				if (animate) {
					return gsap.to(el, Object.assign({}, props, {
						duration: duration,
						ease: 'power2.inOut',
						overwrite: true,
					}));
				}

				gsap.set(el, props);
				return null;
			}

			function applyState(stateKey) {
				var pos = layout()[stateKey];
				map.forEach(function (item) {
					setCardProps(item.el, pos[item.key], false);
					item.el.dataset.layoutScale = String(pos[item.key].scale);
				});
			}

			function applyProgress(progress) {
				var t = gsap.utils.clamp(0, 1, progress);
				var fanPos = layout().fan;
				var stackPos = layout().stack;

				map.forEach(function (item) {
					var from = fanPos[item.key];
					var to = stackPos[item.key];
					var current = {
						left: lerp(from.left, to.left, t),
						top: lerp(from.top, to.top, t),
						rotation: lerp(from.rotation, to.rotation, t),
						scale: lerp(from.scale, to.scale, t),
						zIndex: t >= 0.5 ? to.zIndex : from.zIndex,
					};

					setCardProps(item.el, current, false);
					item.el.dataset.layoutScale = String(current.scale);
				});

				wrapper.dataset.channelsProgress = String(t);
			}

			/* Start as stacked fan; scrub open as cards scroll into view */
			applyState('fan');

			var trigger = ScrollTrigger.create({
				trigger: wrapper,
				start: 'top bottom',
				end: 'center center',
				scrub: 0.35,
				invalidateOnRefresh: true,
				onUpdate: function (self) {
					applyProgress(self.progress);
				},
				onRefresh: function (self) {
					applyProgress(self.progress);
				},
			});

			channelTriggers.push({ trigger: trigger });
		});

		bindHover();
		ScrollTrigger.refresh();
	}

	function bindHover() {
		document.querySelectorAll('.gt-channels .card').forEach(function (card) {
			if (card.dataset.hoverBound === 'true') return;
			card.dataset.hoverBound = 'true';

			card.addEventListener('mouseenter', function () {
				var base = parseFloat(card.dataset.layoutScale || '1') || 1;
				card.style.zIndex = '100';
				gsap.to(card, {
					y: -18,
					scaleX: base * 1.04,
					scaleY: base * 1.04,
					duration: 0.25,
					overwrite: 'auto',
				});
			});

			card.addEventListener('mouseleave', function () {
				var base = parseFloat(card.dataset.layoutScale || '1') || 1;
				card.style.zIndex = '';
				gsap.to(card, {
					y: 0,
					scaleX: base,
					scaleY: base,
					width: CARD_W,
					height: CARD_H,
					duration: 0.25,
					overwrite: 'auto',
				});
			});
		});
	}

	function boot() {
		function tryInit() {
			var lenis = window.growteleLenis;
			if (lenis && typeof lenis.isStopped === 'boolean' && lenis.isStopped) {
				lenis.start();
			}
			initChannelsCards();
		}

		window.addEventListener(
			'growtele:smooth-scroll-ready',
			function () {
				setTimeout(tryInit, 80);
			},
			{ once: true }
		);

		window.addEventListener('growtele:industries-scroll-ready', function () {
			setTimeout(function () {
				tryInit();
				refreshChannels();
			}, 120);
		});

		setTimeout(function () {
			if (!didInit) tryInit();
			else refreshChannels();
		}, 450);

		setTimeout(function () {
			if (!didInit) tryInit();
			else refreshChannels();
		}, 1400);

		window.addEventListener('load', function () {
			if (isMobileViewport()) {
				resetChannelsMobileLayout();
				return;
			}
			if (!didInit) tryInit();
			refreshChannels();
		});

		window.addEventListener('resize', function () {
			if (!isMobileViewport()) return;
			killChannelTriggers();
			didInit = false;
			initChannelsCards();
		}, { passive: true });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
