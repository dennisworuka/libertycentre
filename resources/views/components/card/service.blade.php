@props(['service'])

@php
    $cardImageUrl = $service->getFirstMediaUrl(\App\Domain\Content\Models\Service::CARD_IMAGE_COLLECTION, '480');
    $cardImageAlt = $service->getFirstMedia(\App\Domain\Content\Models\Service::CARD_IMAGE_COLLECTION)?->getCustomProperty('alt');
@endphp

<div {{ $attributes->class(['card h-100 position-relative overflow-hidden']) }}>
    @if ($cardImageUrl)
        <div class="lc-card-image-wrap">
            <img src="{{ $cardImageUrl }}" alt="{{ $cardImageAlt }}" class="lc-card-image" loading="lazy">
        </div>
    @endif

    <div class="card-body d-flex flex-column">
        @if ($service->icon)
            <div class="lc-card-icon mb-3 text-primary">
                <x-icon :name="$service->icon" class="lc-icon" />
            </div>
        @endif

        <h3 class="h5">
            <a href="{{ route('services.show', $service->slug) }}" class="stretched-link text-decoration-none text-body">
                {{ $service->title }}
            </a>
        </h3>

        <p class="mb-0 flex-grow-1">{{ $service->summary }}</p>
    </div>
</div>
