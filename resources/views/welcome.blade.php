<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <main class="d-flex align-items-center justify-content-center min-vh-100 text-center px-3">
            <div>
                <h1>{{ config('app.name') }}</h1>
                <p class="text-measure mx-auto">
                    The public site is under construction. This placeholder will be replaced
                    by the full Steady Hands design system in Phase 3.
                </p>
            </div>
        </main>
    </body>
</html>
