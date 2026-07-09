@extends('layouts.app')

@section('content')
    <article class="section-band bg-white">
        <div class="container content-measure">
            <h1>{{ $page->title }}</h1>
            <p class="review-date">Last reviewed: {{ $page->last_reviewed_at->format('j F Y') }}</p>
            @if($page->summary)
                <p>{{ $page->summary }}</p>
            @endif

            @foreach($page->content ?? [] as $section)
                <section class="content-block">
                    <h2>{{ $section['heading'] }}</h2>
                    <p>{{ $section['body'] }}</p>
                </section>
            @endforeach

            @if($page->slug === 'privacy-policy')
                <section class="content-block" data-retention-source="settings">
                    <h2>Retention periods</h2>
                    <p>Referrals are retained for {{ $retention['referrals_months'] ?? 84 }} months, enquiries for {{ $retention['enquiries_months'] ?? 36 }} months, recruitment applications for {{ $retention['applications_months'] ?? 12 }} months, and talent-pool records for {{ $retention['talent_pool_months'] ?? 24 }} months.</p>
                </section>
            @endif

            @if($page->slug === 'cookie-policy')
                <section class="content-block">
                    <h2>Cookie categories</h2>
                    <p>The cookie category table will be generated from the consent tool categories in Phase 9.</p>
                </section>
            @endif
        </div>
    </article>
@endsection
