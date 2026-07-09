@php
    $contact = $settings?->contact ?? [];
    $cqc = $settings?->cqc ?? [];
@endphp

<footer class="site-footer border-top mt-auto">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h2 class="h5">{{ $settings?->site_name ?? 'Liberty Centre Limited' }}</h2>
                <p>{{ $settings?->strapline ?? 'Empowering Lives. Supporting Independence. Inspiring Possibilities.' }}</p>
                <a class="cqc-badge" href="{{ $cqc['report_url'] ?? 'https://www.cqc.org.uk/' }}">CQC Good 2026</a>
            </div>
            <div class="col-lg-3">
                <h2 class="h6">Quick links</h2>
                <ul class="list-unstyled">
                    @forelse ($footerMenu as $item)
                        <li><a href="{{ $item->type === 'internal' ? url($item->page_slug ?? '/') : $item->url }}">{{ $item->label }}</a></li>
                    @empty
                        <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('/cookies') }}">Cookie Policy</a></li>
                        <li><a href="{{ url('/accessibility') }}">Accessibility Statement</a></li>
                    @endforelse
                </ul>
            </div>
            <div class="col-lg-3">
                <h2 class="h6">Contact</h2>
                <p class="mb-1">{{ $contact['address'] ?? 'Address to be added in Settings' }}</p>
                <p class="mb-1">{{ $contact['phone'] ?? 'Phone to be added' }}</p>
                <p>{{ $contact['email'] ?? 'Email to be added' }}</p>
            </div>
            <div class="col-lg-2">
                <h2 class="h6">Newsletter</h2>
                <form class="stack-form" action="{{ url('/newsletter') }}" method="get">
                    <label for="footer-email">Email</label>
                    <input id="footer-email" class="form-control" type="email" autocomplete="email">
                    <button class="btn btn-primary mt-2" type="submit">Sign up</button>
                </form>
            </div>
        </div>
        <p class="small mt-4 mb-0">Company registration and CQC provider ID will be managed from Settings.</p>
    </div>
</footer>
