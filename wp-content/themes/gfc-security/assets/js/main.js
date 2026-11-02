/* GFC Security — main.js */
(function () {
	'use strict';
	var d = document;

	/* Header đổ bóng khi cuộn */
	var header = d.querySelector('.gfc-header');
	function onScroll() { if (header) header.classList.toggle('is-scrolled', window.scrollY > 10); }
	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();

	/* Menu mobile */
	var nav = d.getElementById('gfc-nav');
	var burger = d.querySelector('.gfc-burger');
	var overlay = d.querySelector('.gfc-overlay');
	function setNav(open) {
		if (!nav) return;
		nav.classList.toggle('is-open', open);
		if (burger) burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (overlay) overlay.hidden = !open;
		d.body.style.overflow = open ? 'hidden' : '';
	}
	if (burger) burger.addEventListener('click', function () { setNav(true); });
	var closeBtn = d.querySelector('.gfc-nav__close');
	if (closeBtn) closeBtn.addEventListener('click', function () { setNav(false); });
	if (overlay) overlay.addEventListener('click', function () { setNav(false); });
	d.addEventListener('keydown', function (e) { if (e.key === 'Escape') setNav(false); });
	d.querySelectorAll('.sub-toggle').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			e.preventDefault();
			var li = btn.closest('li');
			if (li) li.classList.toggle('is-open');
		});
	});

	/* Video YouTube: chỉ tải khi bấm */
	d.querySelectorAll('.gfc-yt').forEach(function (el) {
		el.addEventListener('click', function () {
			var id = el.getAttribute('data-yt');
			if (!id || el.querySelector('iframe')) return;
			var f = d.createElement('iframe');
			f.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0';
			f.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
			f.allowFullscreen = true;
			f.title = 'Video giới thiệu GFC Security';
			el.appendChild(f);
		});
	});

	/* Đếm số */
	function fmt(n) { return n >= 10000 ? n.toLocaleString('de-DE') : String(n); }
	var counters = d.querySelectorAll('.js-count');
	if ('IntersectionObserver' in window && counters.length) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (!en.isIntersecting) return;
				io.unobserve(en.target);
				var el = en.target, to = parseInt(el.getAttribute('data-to'), 10) || 0;
				var from = to > 1900 && to < 2100 ? 1900 : 0; // năm thành lập đếm từ 1900
				var t0 = null, dur = 1600;
				function step(ts) {
					if (!t0) t0 = ts;
					var p = Math.min((ts - t0) / dur, 1);
					var e = 1 - Math.pow(1 - p, 3);
					el.textContent = fmt(Math.round(from + (to - from) * e));
					if (p < 1) requestAnimationFrame(step);
				}
				requestAnimationFrame(step);
			});
		}, { threshold: 0.4 });
		counters.forEach(function (c) { io.observe(c); });
	}

	/* Sliders */
	if (typeof Swiper !== 'undefined') {
		if (d.querySelector('.js-hero')) {
			new Swiper('.js-hero', { loop: true, effect: 'fade', fadeEffect: { crossFade: true }, autoplay: { delay: 4000, disableOnInteraction: false }, speed: 800 });
		}
		if (d.querySelector('.js-awards')) {
			new Swiper('.js-awards', {
				slidesPerView: 1.4, spaceBetween: 16, loop: true,
				autoplay: { delay: 3000, disableOnInteraction: false },
				navigation: { prevEl: '.js-awards-prev', nextEl: '.js-awards-next' },
				breakpoints: { 640: { slidesPerView: 2.5 }, 1024: { slidesPerView: 4, spaceBetween: 20 } }
			});
		}
		if (d.querySelector('.js-fb')) {
			new Swiper('.js-fb', {
				slidesPerView: 1.1, spaceBetween: 16,
				navigation: { prevEl: '.js-fb-prev', nextEl: '.js-fb-next' },
				breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 4, spaceBetween: 20 } }
			});
		}
	}
})();

/* Khối nội dung trang dịch vụ: thu gọn + nút Xem thêm */
(function () {
	var COLLAPSED = 600;
	document.querySelectorAll('.js-collapse').forEach(function (box) {
		var body = box.querySelector('.gfc-collapse__body');
		var fade = box.querySelector('.gfc-collapse__fade');
		var wrap = box.nextElementSibling;
		var btn = wrap && wrap.querySelector('.js-collapse-toggle');
		if (!body || !btn || body.scrollHeight <= COLLAPSED) return;
		var open = false;
		function render() {
			body.style.maxHeight = open ? 'none' : COLLAPSED + 'px';
			fade.hidden = open;
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			btn.querySelector('span').textContent = open ? 'Thu gọn' : 'Xem thêm';
		}
		wrap.hidden = false;
		render();
		btn.addEventListener('click', function () { open = !open; render(); });
	});
})();

/* Lọc danh sách chi nhánh */
(function () {
	document.querySelectorAll('.js-branch-finder').forEach(function (box) {
		var select = box.querySelector('.js-branch-select');
		var search = box.querySelector('.js-branch-search');
		var items = box.querySelectorAll('li[data-branch]');
		function apply() {
			var picked = select.value;
			var q = search.value.trim().toLowerCase();
			items.forEach(function (li) {
				li.hidden = (picked && li.getAttribute('data-branch') !== picked) || (q && li.textContent.toLowerCase().indexOf(q) === -1);
			});
		}
		select.addEventListener('change', apply);
		search.addEventListener('input', apply);
		box.querySelector('form').addEventListener('submit', function (e) { e.preventDefault(); apply(); });
	});
})();

/* Slider bài viết liên quan */
(function () {
	if (!document.querySelector('.js-related') || typeof Swiper === 'undefined') return;
	new Swiper('.js-related', {
		slidesPerView: 1.1, spaceBetween: 16,
		navigation: { prevEl: '.js-related-prev', nextEl: '.js-related-next' },
		breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 4, spaceBetween: 20 } }
	});
})();
