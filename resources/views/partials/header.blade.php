<header class="lc-header sticky-top bg-white border-bottom" id="site-header">
    <nav class="navbar navbar-expand-lg container py-3" aria-label="Primary">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            {{ $siteOrganisation->site_name }}
        </a>

        <div class="d-flex align-items-center gap-3 order-lg-3">
            @if ($siteContact->phone)
                <a href="tel:{{ preg_replace('/\s+/', '', $siteContact->phone) }}" class="d-none d-md-inline-flex text-decoration-none text-body fw-semibold">
                    {{ $siteContact->phone }}
                </a>
            @endif

            <a href="{{ route('contact') }}" class="btn btn-primary">Make an enquiry</a>

            <button
                class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileNav"
                aria-controls="mobileNav"
                aria-expanded="false"
                aria-label="Toggle navigation menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse d-none d-lg-flex order-lg-2">
            <ul class="navbar-nav ms-auto">
                @foreach ($headerNavigation as $item)
                    @if ($item->children->isNotEmpty())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ $item->url }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $item->label }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($item->children as $child)
                                    <li><a class="dropdown-item" href="{{ $child->url }}">{{ $child->label }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item->url }}">{{ $item->label }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </nav>
</header>

<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h5" id="mobileNavLabel">Menu</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            @foreach ($headerNavigation as $item)
                <li class="nav-item">
                    <a class="nav-link" href="{{ $item->url }}">{{ $item->label }}</a>
                </li>
                @foreach ($item->children as $child)
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="{{ $child->url }}">{{ $child->label }}</a>
                    </li>
                @endforeach
            @endforeach
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-primary w-100 mt-3">Make an enquiry</a>
    </div>
</div>
