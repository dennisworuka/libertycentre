@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container">
            <h1>Our Services</h1>
            <p>Specialist, person-centred support for people with autism, learning disabilities and complex needs.</p>
            <div class="service-grid">
                @forelse ($services as $service)
                    <article class="service-card">
                        <div class="service-card-body">
                            <h2 class="h3">{{ $service->title }}</h2>
                            <p>{{ $service->summary }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" aria-label="Learn more about {{ $service->title }}">Learn more</a>
                        </div>
                    </article>
                @empty
                    <p class="empty-state">Published services will appear here.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
