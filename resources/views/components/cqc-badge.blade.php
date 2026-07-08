@props(['compact' => false])

@php
    $cqc = app(\App\Settings\CqcSettings::class);
@endphp

@if ($cqc->badge_enabled)
    <a
        href="{{ $cqc->report_url }}"
        target="_blank"
        rel="noopener"
        class="lc-cqc-badge d-inline-flex align-items-center gap-2 text-decoration-none"
    >
        <span class="badge rounded-pill px-3 py-2" style="background-color: var(--lc-amber); color: var(--lc-ink);">
            CQC {{ $cqc->rating_label }}
        </span>
        @unless ($compact)
            <span class="small text-body">Read the CQC report</span>
        @endunless
    </a>
@endif
