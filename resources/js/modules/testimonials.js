import $ from 'jquery';

// Testimonial carousel: pause on hover/focus, prev/next aria state. Wired in Phase 3.
$(function () {
    const el = document.getElementById('testimonialCarousel');
    if (!el || !window.bootstrap) return;

    const carousel = window.bootstrap.Carousel.getOrCreateInstance(el);

    // Bootstrap already pauses on hover (data-bs-ride default); this adds
    // keyboard-focus parity so tabbing into the carousel also stops it.
    $(el).on('focusin.lc', () => carousel.pause());
    $(el).on('focusout.lc', () => carousel.cycle());
});
