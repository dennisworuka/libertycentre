<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Liberty Centre Limited') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer+R7WNrnN4cx6usw13IEXD1a6c5H9eYohX0j1rZQ" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    <div class="site-shell d-flex flex-column">
        <header class="site-header border-bottom">
            <nav class="navbar navbar-expand-lg" aria-label="Primary navigation">
                <div class="container py-2">
                    <a class="navbar-brand text-wrap" href="{{ url('/') }}">Liberty Centre Limited</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navigation" aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="primary-navigation">
                        <ul class="navbar-nav ms-auto gap-lg-2">
                            <li class="nav-item"><a class="nav-link" href="#main-content">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin') }}">Admin</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main id="main-content" class="flex-grow-1">
            @yield('content')
        </main>

        <footer class="site-footer border-top mt-auto">
            <div class="container py-4">
                <p class="mb-1 fw-semibold">Liberty Centre Limited</p>
                <p class="mb-0 text-secondary">Footer, compliance links, CQC details, contact information, and newsletter signup will be CMS-managed in later phases.</p>
            </div>
        </footer>
    </div>

    @include('partials.cookie-consent')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
