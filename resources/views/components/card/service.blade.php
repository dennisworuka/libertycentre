@props(['service'])

<div {{ $attributes->class(['card h-100 position-relative']) }}>
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
