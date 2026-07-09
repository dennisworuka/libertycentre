@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Services', 'url' => route('services.index')],
        ['label' => $service->title],
    ]" />

    <x-section>
        <div class="row g-5">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $service->title }}</h1>
                <p class="fs-5 text-measure">{{ $service->summary }}</p>

                <x-blocks :blocks="$service->body" />

                @if ($testimonials->isNotEmpty())
                    <div class="mt-5">
                        <x-testimonial-carousel :testimonials="$testimonials" />
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="h5">Interested in {{ $service->title }}?</h2>
                        <p>Tell us a little about the support being sought and we'll get back to you within one working day.</p>
                        <a href="{{ route('contact') }}?service={{ $service->slug }}" class="btn btn-primary w-100">
                            Enquire about this service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    <x-json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service->title,
        'description' => $service->summary,
        'areaServed' => 'West Yorkshire',
        'provider' => [
            '@type' => 'Organization',
            'name' => $siteOrganisation->site_name,
        ],
    ]" />

@endsection
