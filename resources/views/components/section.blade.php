@props(['background' => 'white', 'divider' => false])

@php
    $bgClass = $background === 'surface' ? 'bg-surface' : 'bg-white';
@endphp

<section {{ $attributes->class(['lc-section', $bgClass]) }}>
    <div class="container">
        {{ $slot }}
    </div>

    @if ($divider)
        <x-care-line variant="divider" />
    @endif
</section>
