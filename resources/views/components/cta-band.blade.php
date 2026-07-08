@props(['heading' => null, 'text' => null, 'buttonLabel' => 'Learn more', 'buttonUrl' => '#'])

<div class="lc-cta-band bg-primary text-white rounded-3 p-4 p-md-5 my-5 text-center">
    @if ($heading)
        <h3 class="text-white mb-2">{{ $heading }}</h3>
    @endif

    @if ($text)
        <p class="mb-4" style="color: rgba(255,255,255,.85);">{{ $text }}</p>
    @endif

    <a href="{{ $buttonUrl }}" class="btn btn-lg fw-semibold" style="background-color: var(--lc-amber); color: var(--lc-ink);">
        {{ $buttonLabel }}
    </a>
</div>
