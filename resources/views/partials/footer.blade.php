<footer class="lc-footer bg-dark text-white pt-5">
    <div class="container">
        <x-care-line variant="footer" />

        <div class="row g-4 py-5">
            <div class="col-md-3">
                <h2 class="h6 text-white">{{ $siteOrganisation->site_name }}</h2>
                <p class="small" style="color: rgba(255,255,255,.7);">{{ $siteOrganisation->strapline }}</p>
                <x-cqc-badge />
            </div>

            <div class="col-md-3">
                <h2 class="h6 text-white">Quick links</h2>
                <ul class="list-unstyled">
                    @foreach ($headerNavigation as $item)
                        <li class="mb-1"><a href="{{ $item->url }}" class="footer-link">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-3">
                <h2 class="h6 text-white">Contact</h2>
                <ul class="list-unstyled small">
                    @if ($siteContact->phone)
                        <li class="mb-1"><a href="tel:{{ preg_replace('/\s+/', '', $siteContact->phone) }}" class="footer-link">{{ $siteContact->phone }}</a></li>
                    @endif
                    @if ($siteContact->email_general)
                        <li class="mb-1"><a href="mailto:{{ $siteContact->email_general }}" class="footer-link">{{ $siteContact->email_general }}</a></li>
                    @endif
                    <li class="mt-2">{{ $siteContact->office_hours }}</li>
                </ul>
            </div>

            <div class="col-md-3">
                <h2 class="h6 text-white">Stay in touch</h2>
                <p class="small" style="color: rgba(255,255,255,.7);">Occasional updates from Liberty Centre. Unsubscribe any time.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex gap-2" novalidate>
                    @csrf
                    <label for="footer-newsletter-email" class="visually-hidden">Email address</label>
                    <input type="email" id="footer-newsletter-email" name="email" required class="form-control form-control-sm" placeholder="Email address">
                    <button type="submit" class="btn btn-sm fw-semibold" style="background-color: var(--lc-amber); color: var(--lc-ink);">Sign up</button>
                </form>
            </div>
        </div>

        <div class="border-top py-4 d-flex flex-wrap justify-content-between gap-3 small" style="border-color: rgba(255,255,255,.15); color: rgba(255,255,255,.6);">
            <p class="mb-0">&copy; {{ now()->year }} {{ $siteOrganisation->site_name }}. Company number {{ $siteOrganisation->company_number }}.</p>
            <ul class="list-inline mb-0">
                @foreach ($footerNavigation as $item)
                    <li class="list-inline-item"><a href="{{ $item->url }}" class="footer-link">{{ $item->label }}</a></li>
                @endforeach
                <li class="list-inline-item">
                    <button type="button" class="btn btn-link btn-sm p-0 footer-link" id="reopen-cookie-preferences">Cookie preferences</button>
                </li>
            </ul>
        </div>
    </div>
</footer>
