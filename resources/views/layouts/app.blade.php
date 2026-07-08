<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('partials.meta')

    <link rel="icon" href="/favicon.ico" sizes="any">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <x-json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteOrganisation->site_name,
        'url' => url('/'),
        'telephone' => $siteContact->phone,
        'email' => $siteContact->email_general,
    ]" />

    @stack('head')
</head>
<body>
    <a href="#main-content" class="visually-hidden-focusable skip-link">Skip to main content</a>

    @if ($siteAnnouncement->enabled)
        <div class="bg-primary text-white text-center py-2 small">
            <div class="container">{{ $siteAnnouncement->message }}</div>
        </div>
    @endif

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.cookie-consent')
</body>
</html>
