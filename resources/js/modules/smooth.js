import $ from 'jquery';

// Smooth-scroll same-page anchors with header offset + focus management. Wired in Phase 3.
$(function () {
    $('a[href^="#"]:not([href="#"])').on('click.lc', function (event) {
        const targetId = $(this).attr('href');
        const $target = $(targetId);
        if (!$target.length) return;

        event.preventDefault();

        const headerOffset = document.getElementById('site-header')?.offsetHeight ?? 0;
        const top = $target.offset().top - headerOffset - 16;

        window.scrollTo({
            top,
            behavior: window.LC?.prefersReducedMotion ? 'auto' : 'smooth',
        });

        $target.attr('tabindex', '-1').trigger('focus');
    });
});
