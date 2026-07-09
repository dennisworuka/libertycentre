<?php

namespace App\Http\Middleware;

use App\Support\Csp\Nonce;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $nonce = app(Nonce::class)->value();

        $adminPath = config('admin.path');
        $isAdmin = $request->is($adminPath, "{$adminPath}/*");

        /**
         * Filament's admin panel (Livewire 3 + bundled Alpine.js) needs two
         * relaxations the public site does not, both structural
         * requirements of the framework rather than gaps in this policy —
         * user-confirmed trade-off, see docs/decisions.md:
         *
         * 1. script-src 'unsafe-eval' — every Alpine directive (x-show,
         *    x-on:click, x-bind:*, ...) is evaluated by constructing a
         *    `Function()` from the expression string. No nonce can permit
         *    that; it's a different CSP keyword entirely. The nonce stays
         *    alongside it (nonce + unsafe-eval compose fine — one governs
         *    which <script> tags run, the other whether string-to-code
         *    execution is allowed).
         *
         * 2. style-src 'unsafe-inline' — Filament/Alpine write inline
         *    style="" attributes at runtime throughout the UI (per-instance
         *    colour theming via CSS custom properties, dynamic grid
         *    column-spans, computed heights, sidebar scroll behaviour).
         *    These are unpredictable per render, so hashing every value
         *    isn't practical. Per the CSP spec, 'unsafe-inline' is ignored
         *    outright whenever a nonce is present in the same directive, so
         *    the nonce is dropped from style-src for admin only — the
         *    nonce still applies to script-src.
         *
         * Plus two specific external hosts Filament's default UI needs:
         * fonts.bunny.net (its self-hosted-Google-Fonts-alternative CSS,
         * used for the Inter UI font) and ui-avatars.com (its fallback
         * generated-initials avatar image when a user has no photo).
         */
        $csp = $isAdmin
            ? implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'nonce-{$nonce}' 'unsafe-eval'",
                "style-src 'self' 'unsafe-inline' https://fonts.bunny.net",
                "img-src 'self' data: https://ui-avatars.com",
                "font-src 'self' https://fonts.bunny.net",
                "connect-src 'self'",
                "frame-src 'self'",
                "frame-ancestors 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "object-src 'none'",
            ])
            : implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'nonce-{$nonce}'",
                "style-src 'self' 'nonce-{$nonce}'",
                "img-src 'self' data:",
                "font-src 'self'",
                "connect-src 'self'",
                "frame-src 'self'",
                "frame-ancestors 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "object-src 'none'",
            ]);

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('Strict-Transport-Security', 'max-age=15552000; includeSubDomains');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
