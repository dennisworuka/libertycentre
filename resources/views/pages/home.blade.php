@extends('layouts.app')

@section('content')

    {{-- Hero slider --}}
    <x-hero-slider :slides="[
        [
            'heading' => 'Specialist care that starts with the person, not the diagnosis',
            'text' => $siteOrganisation->strapline,
            'cta' => 'Make an enquiry',
            'url' => route('contact'),
            'secondaryCta' => 'Our services',
            'secondaryUrl' => route('services.index'),
        ],
        [
            'heading' => 'Rated Good by the CQC',
            'text' => 'Independent, regulated care you can trust — read our latest inspection report in full.',
            'cta' => 'Read the CQC report',
            'url' => route('cqc-quality'),
        ],
        [
            'heading' => 'Join a team that makes a real difference',
            'text' => 'We\'re growing our care team across West Yorkshire — training, support and real career progression from day one.',
            'cta' => 'See current roles',
            'url' => route('careers'),
        ],
    ]" />
    <x-care-line variant="hero" />

    {{-- Trust bar --}}
    <x-section background="surface">
        <div class="row g-4" data-reveal-stagger>
            <div class="col-md-4">
                <x-stat :value="40" suffix="+" label="People supported across West Yorkshire" />
            </div>
            <div class="col-md-4">
                <x-stat :value="12" label="Years of specialist care" />
            </div>
            <div class="col-md-4">
                <div class="lc-stat text-center">
                    <p class="display-5 fw-bold text-primary mb-1">24/7</p>
                    <p class="mb-0">Support available</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <x-cqc-badge />
        </div>
    </x-section>

    {{-- Services overview --}}
    <x-section>
        <div class="text-center mb-5 lc-reveal-single">
            <h2>How we can help</h2>
            <p class="text-measure mx-auto">Five specialist services, one consistent standard of care.</p>
        </div>
        <div class="row g-4" data-reveal-stagger>
            @foreach ($services as $service)
                <div class="col-md-6 col-lg-4">
                    <x-card.service :service="$service" />
                </div>
            @endforeach
        </div>
    </x-section>

    {{-- Our approach strip --}}
    <x-section background="surface" divider>
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2>Our approach</h2>
                <p class="text-measure">Person-centred, strengths-based, and always focused on building independence — whatever that looks like for each person we support.</p>
                <a href="{{ route('pages.show', 'our-approach') }}" class="btn btn-outline-primary">Read about our approach</a>
            </div>
            <div class="col-lg-6">
                <div class="row g-4" data-reveal-stagger>
                    <div class="col-4 text-center">
                        <h3 class="h6">Person-centred</h3>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="h6">Strengths-based</h3>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="h6">Independence-focused</h3>
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
        <x-section>
            <h2 class="text-center mb-5">What families and partners tell us</h2>
            <x-testimonial-carousel :testimonials="$testimonials" />
        </x-section>
    @endif

    {{-- Latest news --}}
    @if ($posts->isNotEmpty())
        <x-section background="surface">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <h2 class="mb-0">Latest news</h2>
                <a href="{{ route('news.index') }}" class="btn btn-outline-primary">All news</a>
            </div>
            <div class="row g-4" data-reveal-stagger>
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <x-card.post :post="$post" />
                    </div>
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- Careers band --}}
    <x-section>
        <x-cta-band
            heading="Join our team"
            text="We're always looking for warm, reliable people to join our care team across West Yorkshire."
            button-label="See current roles"
            :button-url="route('careers')"
        />
    </x-section>

    {{-- Newsletter CTA --}}
    <x-section background="surface">
        <div class="text-center">
            <h2>Stay in touch</h2>
            <p class="text-measure mx-auto mb-4">Occasional updates from Liberty Centre — news, vacancies and stories from the people we support.</p>
            <a href="{{ route('pages.show', 'newsletter') }}" class="btn btn-primary">Sign up to our newsletter</a>
        </div>
    </x-section>

@endsection
