@props(['variant' => 'divider'])

@php
    $height = match ($variant) {
        'hero' => 32,
        'footer' => 24,
        default => 40,
    };
@endphp

@if ($variant === 'hero')
    <svg class="lc-care-line lc-care-line--hero" viewBox="0 0 1200 {{ $height }}" preserveAspectRatio="none" width="100%" height="{{ $height }}" aria-hidden="true" focusable="false">
        <path d="M0,{{ $height / 2 }} C 200,{{ $height * 0.1 }} 400,{{ $height * 0.9 }} 600,{{ $height / 2 }} S 1000,{{ $height * 0.1 }} 1200,{{ $height / 2 }}" fill="none" stroke="var(--lc-mist)" stroke-width="2" stroke-linecap="round" />
        <circle cx="600" cy="{{ $height / 2 }}" r="5" fill="var(--lc-amber)" />
    </svg>
@elseif ($variant === 'footer')
    <svg class="lc-care-line lc-care-line--footer" viewBox="0 0 1200 {{ $height }}" preserveAspectRatio="none" width="100%" height="{{ $height }}" aria-hidden="true" focusable="false">
        <path d="M0,{{ $height / 2 }} C 300,{{ $height * 0.2 }} 900,{{ $height * 0.8 }} 1200,{{ $height / 2 }}" fill="none" stroke="var(--lc-mist)" stroke-width="2" stroke-linecap="round" />
    </svg>
@else
    <svg class="lc-care-line lc-care-line--divider" viewBox="0 0 1200 {{ $height }}" preserveAspectRatio="none" width="100%" height="{{ $height }}" aria-hidden="true" focusable="false">
        <path d="M0,{{ $height / 2 }} C 150,{{ $height * 0.15 }} 300,{{ $height * 0.85 }} 450,{{ $height / 2 }} S 750,{{ $height * 0.15 }} 900,{{ $height / 2 }} S 1150,{{ $height * 0.85 }} 1200,{{ $height / 2 }}" fill="none" stroke="var(--lc-mist)" stroke-width="2" stroke-linecap="round" />
        <circle cx="900" cy="{{ $height / 2 }}" r="4" fill="var(--lc-amber)" />
    </svg>
@endif
