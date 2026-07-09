@php
    $contact = $settings?->contact ?? [];
    $phone = $contact['phone'] ?? '';
@endphp

<header class="site-header border-bottom">
    <nav class="navbar navbar-expand-lg" aria-label="Primary navigation">
        <div class="container py-2">
            <a class="navbar-brand text-wrap" href="{{ url('/') }}">{{ $settings?->site_name ?? 'Liberty Centre Limited' }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navigation" aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primary-navigation">
                <ul class="navbar-nav ms-auto gap-lg-2 align-items-lg-center">
                    @forelse ($headerMenu as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item->type === 'internal' ? url($item->page_slug ?? '/') : $item->url }}" @if($item->opens_in_new_tab) target="_blank" rel="noopener" @endif @if($item->aria_label) aria-label="{{ $item->aria_label }}" @endif>{{ $item->label }}</a>
                        </li>
                    @empty
                        <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                    @endforelse
                    @if ($phone)
                        <li class="nav-item"><a class="nav-link" href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></li>
                    @endif
                    <li class="nav-item"><a class="btn btn-cta" href="{{ url('/referral') }}">Make a Referral</a></li>
                    <li class="nav-item"><a class="btn btn-outline-primary" href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
