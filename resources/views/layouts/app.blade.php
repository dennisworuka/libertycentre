<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Liberty Centre Limited' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer+R7WNrnN4cx6usw13IEXD1a6c5H9eYohX0j1rZQ" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    <div class="site-shell d-flex flex-column">
        @include('partials.header', ['settings' => $settings ?? null, 'headerMenu' => $headerMenu ?? collect()])

        <main id="main-content" class="flex-grow-1">
            @yield('content')
        </main>

        @include('partials.footer', ['settings' => $settings ?? null, 'footerMenu' => $footerMenu ?? collect()])
    </div>

    @include('partials.cookie-consent')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/homepage.js') }}" defer></script>
</body>
</html>
