@extends('layouts.app')

@section('content')
    <article class="section-band bg-white">
        <div class="container content-measure">
            @include('public.partials.blocks', ['blocks' => $service->blocks ?? []])

            @if($faqs->isNotEmpty())
                <section class="content-block">
                    <h2>Service FAQs</h2>
                    @foreach($faqs as $faq)
                        <details class="faq-item">
                            <summary>{{ $faq->question }}</summary>
                            <p>{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </section>
            @endif

            <section class="cta-panel">
                <h2>Start a referral</h2>
                <p>Speak to us about whether {{ $service->title }} is right for the person you support.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-cta" href="{{ url('/referral') }}">Make a Referral</a>
                    <a class="btn btn-outline-primary" href="{{ url('/contact') }}">Contact Us</a>
                </div>
            </section>
        </div>
    </article>
@endsection
