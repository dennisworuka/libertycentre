import $ from 'jquery';

// Hero slider: pause on hover/focus (Bootstrap default + keyboard parity),
// a visible play/pause toggle (WCAG 2.2.2 — this is the page's most
// prominent auto-advancing content), and reduced-motion starts paused.
$(function () {
    const el = document.getElementById('heroSlider');
    if (!el || !window.bootstrap) return;

    const carousel = window.bootstrap.Carousel.getOrCreateInstance(el);
    const $toggle = $(el).find('[data-hero-slider-toggle]');
    let isPaused = false;

    function setPaused(paused) {
        isPaused = paused;
        paused ? carousel.pause() : carousel.cycle();

        $toggle.attr('aria-pressed', String(paused));
        $toggle.find('[data-icon-pause]').toggleClass('d-none', paused);
        $toggle.find('[data-icon-play]').toggleClass('d-none', !paused);
        $toggle.find('[data-toggle-label]').text(paused ? 'Play slideshow' : 'Pause slideshow');
    }

    $toggle.on('click.lc', () => setPaused(!isPaused));

    $(el).on('focusin.lc', () => { if (!isPaused) carousel.pause(); });
    $(el).on('focusout.lc', () => { if (!isPaused) carousel.cycle(); });

    if (window.LC?.prefersReducedMotion) {
        setPaused(true);
    }
});
