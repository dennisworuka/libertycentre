import $ from 'jquery';

// Stat-number count-up animation, once per element on first reveal. Wired in Phase 3.
function animateCounter($el, target, duration) {
    if (window.LC?.prefersReducedMotion) {
        $el.text(target.toLocaleString());

        return;
    }

    const start = performance.now();

    function step(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        $el.text(Math.round(target * eased).toLocaleString());

        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            $el.text(target.toLocaleString());
        }
    }

    requestAnimationFrame(step);
}

$(function () {
    const $counters = $('[data-counter]');
    if (!$counters.length) return;

    const reveal = ($counter) => {
        const target = parseInt($counter.data('counter-target'), 10) || 0;
        animateCounter($counter.find('[data-counter-value]'), target, 800);
    };

    if (!('IntersectionObserver' in window)) {
        $counters.each(function () {
            reveal($(this));
        });

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    reveal($(entry.target));
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.5 },
    );

    $counters.each(function () {
        observer.observe(this);
    });
});
