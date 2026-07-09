document.addEventListener('DOMContentLoaded', () => {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const slider = document.querySelector('#homeHeroSlider');
    const pause = document.querySelector('[data-slider-pause]');

    if (slider && window.bootstrap?.Carousel) {
        const carousel = window.bootstrap.Carousel.getOrCreateInstance(slider);

        if (prefersReduced) {
            carousel.pause();
            slider.removeAttribute('data-bs-ride');
        }

        pause?.addEventListener('click', () => {
            const pressed = pause.getAttribute('aria-pressed') === 'true';
            pause.setAttribute('aria-pressed', String(!pressed));
            pause.textContent = pressed ? 'Pause' : 'Play';
            pressed ? carousel.cycle() : carousel.pause();
        });
    }

    if (!prefersReduced) {
        document.querySelectorAll('[data-counter]').forEach((counter) => {
            counter.textContent = counter.getAttribute('data-target') || counter.textContent;
        });
    }
});
