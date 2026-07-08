import $ from 'jquery';

// Staggered card/stat/timeline reveal on first IntersectionObserver hit.
// Wired in Phase 3. Namespace: .on('*.lc', ...).
$(function () {
    $('[data-reveal-stagger]').each(function () {
        $(this)
            .children()
            .each(function (index) {
                $(this)
                    .addClass('lc-reveal')
                    .css('transition-delay', `${index * 80}ms`);
            });
    });

    $('.lc-reveal-single').addClass('lc-reveal');

    const $targets = $('.lc-reveal');

    if (window.LC?.prefersReducedMotion || !('IntersectionObserver' in window)) {
        $targets.addClass('is-revealed');
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 },
    );

    $targets.each(function () {
        observer.observe(this);
    });
});
