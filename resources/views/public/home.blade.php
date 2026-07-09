@extends('layouts.app')

@section('content')
    @forelse ($sections as $section)
        @switch($section)
            @case('hero_slider')
                <section class="home-hero" aria-label="Homepage highlights" data-home-section="hero_slider">
                    <div id="homeHeroSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000" data-reduced-motion-static="true">
                        <div class="carousel-inner">
                            @foreach ($slides as $slide)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <div class="hero-frame">
                                        <img src="{{ asset($slide->image_path ?: 'images/hero-care.svg') }}" alt="{{ $slide->image_alt }}" class="hero-image">
                                        <div class="hero-overlay" style="--hero-overlay: {{ $slide->overlay_opacity ?? 0.55 }}"></div>
                                        <div class="container hero-content">
                                            @if($loop->first)
                                                <h1>{{ $slide->heading }}</h1>
                                            @else
                                                <h2>{{ $slide->heading }}</h2>
                                            @endif
                                            <p>{{ $slide->subheading }}</p>
                                            <div class="d-flex flex-wrap gap-3">
                                                @foreach (($slide->buttons ?? []) as $button)
                                                    <a class="btn btn-{{ $button['style'] === 'cta' ? 'cta' : 'primary' }}" href="{{ $button['url'] }}">{{ $button['label'] }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#homeHeroSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous slide</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#homeHeroSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next slide</span>
                        </button>
                        <button type="button" class="slider-pause" data-slider-pause aria-controls="homeHeroSlider" aria-pressed="false">Pause</button>
                    </div>
                </section>
                @break

            @case('intro_strip')
                <section class="section-band bg-white" data-home-section="intro_strip">
                    <div class="container intro-strip">
                        <div>
                            <h2>Empowering Lives. Supporting Independence. Inspiring Possibilities.</h2>
                            <p>Liberty Centre provides regulated, person-centred support for people with autism, learning disabilities and complex care needs.</p>
                        </div>
                        <a class="cqc-badge" href="{{ url('/cqc-quality') }}">CQC Good Rating 2026</a>
                    </div>
                </section>
                @break

            @case('service_links')
                <section class="section-band" data-home-section="service_links">
                    <div class="container">
                        <h2>Quick Service Links</h2>
                        <div class="service-grid">
                            @foreach ($serviceCards as $card)
                                <article class="service-card">
                                    <img src="{{ asset($card['image']) }}" alt="{{ $card['alt'] }}" loading="lazy">
                                    <div class="service-card-body">
                                        <span class="service-icon" aria-hidden="true">{{ $card['icon'] }}</span>
                                        <h3>{{ $card['title'] }}</h3>
                                        <p>{{ $card['summary'] }}</p>
                                        <a href="{{ $card['url'] }}" aria-label="Learn more about {{ $card['title'] }}">Learn more</a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('referral_cta')
                <section class="cta-band" data-home-section="referral_cta">
                    <div class="container d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h2>Make a Referral</h2>
                            <p>Start a secure referral and we will guide you through the next steps.</p>
                        </div>
                        <div class="d-flex gap-3">
                            <a class="btn btn-cta" href="{{ url('/referral') }}">Make a Referral</a>
                            <a class="btn btn-outline-light" href="{{ url('/contact') }}">Contact Us</a>
                        </div>
                    </div>
                </section>
                @break

            @case('stats_strip')
                <section class="section-band bg-white" data-home-section="stats_strip">
                    <div class="container stats-strip">
                        <div><strong data-counter data-target="20">20</strong><span>Years' Experience</span></div>
                        <div><strong data-counter data-target="50">50+</strong><span>Service Users</span></div>
                        <div><strong>CQC Good</strong><span>2026 rating</span></div>
                        <div><strong>5</strong><span>Boroughs served</span></div>
                    </div>
                </section>
                @break

            @case('cqc_quality')
                <section class="section-band" data-home-section="cqc_quality">
                    <div class="container two-col">
                        <div>
                            <h2>CQC & Quality Assurance</h2>
                            <p>We work to clear quality standards, safeguarding duties and transparent information for families, commissioners and professionals.</p>
                        </div>
                        <a class="cqc-panel" href="{{ url('/cqc-quality') }}">Read the full CQC report</a>
                    </div>
                </section>
                @break

            @case('testimonials')
                <section class="section-band bg-white" data-home-section="testimonials">
                    <div class="container">
                        <h2>Family Feedback</h2>
                        @forelse ($testimonials as $testimonial)
                            <blockquote class="quote-card">
                                <p>{{ $testimonial->quote }}</p>
                                <footer>{{ $testimonial->attribution ?: 'Anonymous feedback' }}</footer>
                            </blockquote>
                        @empty
                            <p class="empty-state">Testimonials with confirmed consent will appear here.</p>
                        @endforelse
                    </div>
                </section>
                @break

            @case('latest_news_events')
                <section class="section-band" data-home-section="latest_news_events">
                    <div class="container">
                        <h2>Latest News & Events</h2>
                        <div class="news-grid">
                            @forelse ($posts as $post)
                                <article><h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p></article>
                            @empty
                                <p class="empty-state">News and events will appear here once published.</p>
                            @endforelse
                            @foreach ($events as $event)
                                <article><h3>{{ $event->title }}</h3><p>{{ $event->starts_at->format('j M Y') }} {{ $event->location }}</p></article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('coverage_map')
                <section class="section-band bg-white" data-home-section="coverage_map">
                    <div class="container two-col">
                        <div>
                            <h2>Coverage Map</h2>
                            <p>Barking & Dagenham, Havering, Waltham Forest, Bromley, and parts of Essex.</p>
                        </div>
                        <div class="consent-gate" data-consent-gate="maps">Map loads after cookie consent.</div>
                    </div>
                </section>
                @break

            @case('newsletter_signup')
                <section class="section-band" data-home-section="newsletter_signup">
                    <div class="container newsletter-panel">
                        <h2>Newsletter Signup</h2>
                        <form method="get" action="{{ url('/newsletter') }}" class="inline-form">
                            <label for="newsletter-email">Email address</label>
                            <input id="newsletter-email" type="email" class="form-control" autocomplete="email">
                            <label class="form-check"><input type="checkbox" class="form-check-input"> I consent to receive updates.</label>
                            <button class="btn btn-primary" type="submit">Sign up</button>
                        </form>
                    </div>
                </section>
                @break

            @case('urgent_contact')
                <section class="urgent-strip" data-home-section="urgent_contact">
                    <div class="container">
                        <h2>Emergency or urgent concern?</h2>
                        <p>For immediate danger call 999. For urgent care questions, contact the office or your local authority emergency duty team.</p>
                    </div>
                </section>
                @break
        @endswitch
    @empty
        <section class="section-band bg-white">
            <div class="container">
                <h1>Liberty Centre Limited</h1>
                <p>Homepage sections are currently hidden in the CMS.</p>
            </div>
        </section>
    @endforelse
@endsection
