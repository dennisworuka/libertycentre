@props(['testimonials'])

@if ($testimonials->isNotEmpty())
    <div
        id="testimonialCarousel"
        class="carousel slide lc-testimonial-carousel"
        data-bs-ride="carousel"
        data-bs-interval="6000"
        aria-live="polite"
    >
        <div class="carousel-indicators">
            @foreach ($testimonials as $testimonial)
                <button
                    type="button"
                    data-bs-target="#testimonialCarousel"
                    data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}"
                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                    aria-label="Testimonial {{ $loop->iteration }}"
                ></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach ($testimonials as $testimonial)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <blockquote class="blockquote text-center mx-auto text-measure">
                        <p class="mb-3 fs-5">&ldquo;{{ $testimonial->quote }}&rdquo;</p>
                        <footer class="blockquote-footer">{{ $testimonial->attribution }}</footer>
                    </blockquote>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous testimonial</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next testimonial</span>
        </button>
    </div>
@endif
