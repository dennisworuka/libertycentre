@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container content-measure">
            <h1>FAQs</h1>
            @forelse($faqsByCategory as $category => $faqs)
                <section class="content-block">
                    <h2>{{ $category }}</h2>
                    @foreach($faqs as $faq)
                        <details class="faq-item">
                            <summary>{{ $faq->question }}</summary>
                            <p>{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </section>
            @empty
                <p class="empty-state">FAQs will appear here.</p>
            @endforelse
        </div>
    </section>
@endsection
