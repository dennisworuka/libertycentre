@props(['slides'])

<div
    id="heroSlider"
    class="carousel slide lc-hero-slider"
    data-bs-ride="carousel"
    data-bs-interval="7000"
    aria-roledescription="carousel"
    aria-label="Highlights"
>
    <div class="carousel-indicators">
        @foreach ($slides as $slide)
            <button
                type="button"
                data-bs-target="#heroSlider"
                data-bs-slide-to="{{ $loop->index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                aria-current="{{ $loop->first ? 'true' : 'false' }}"
                aria-label="Slide {{ $loop->iteration }} of {{ $loop->count }}: {{ $slide['heading'] }}"
            ></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach ($slides as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="lc-hero-slide d-flex align-items-center">
                    <div class="container text-center">
                        <div class="text-measure mx-auto">
                            @if ($loop->first)
                                <h1 class="display-2 mb-3 text-white">{{ $slide['heading'] }}</h1>
                            @else
                                <h2 class="display-2 mb-3 text-white">{{ $slide['heading'] }}</h2>
                            @endif

                            <p class="fs-5 mb-4 lc-hero-slide-text">{{ $slide['text'] }}</p>

                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <a href="{{ $slide['url'] }}" class="btn btn-lg {{ $loop->first ? 'btn-primary' : 'btn-light' }}">
                                    {{ $slide['cta'] }}
                                </a>
                                @if (! empty($slide['secondaryUrl']))
                                    <a href="{{ $slide['secondaryUrl'] }}" class="btn btn-outline-light btn-lg">
                                        {{ $slide['secondaryCta'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous slide</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next slide</span>
    </button>

    <button type="button" class="lc-hero-slider-toggle" data-hero-slider-toggle aria-pressed="false">
        <x-icon name="heroicon-o-pause" class="lc-icon-sm" data-icon-pause />
        <x-icon name="heroicon-o-play" class="lc-icon-sm d-none" data-icon-play />
        <span class="visually-hidden" data-toggle-label>Pause slideshow</span>
    </button>
</div>
