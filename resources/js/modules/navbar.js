import $ from 'jquery';

// Header shrink-on-scroll + off-canvas aria-expanded sync. Wired in Phase 3.
$(function () {
    const $header = $('#site-header');

    function updateScrollState() {
        $header.toggleClass('is-scrolled', window.scrollY > 24);
    }

    updateScrollState();
    $(window).on('scroll.lc', updateScrollState);

    const offcanvasEl = document.getElementById('mobileNav');
    const $toggler = $('.navbar-toggler');

    if (offcanvasEl) {
        offcanvasEl.addEventListener('show.bs.offcanvas', () => $toggler.attr('aria-expanded', 'true'));
        offcanvasEl.addEventListener('hidden.bs.offcanvas', () => $toggler.attr('aria-expanded', 'false'));
    }
});
