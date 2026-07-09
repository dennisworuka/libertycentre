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

        /**
         * Filament's admin panel is built on Livewire 3, which bundles
         * Alpine.js internally. Every Alpine directive (x-show, x-on:click,
         * x-bind:*, ...) is evaluated by constructing a `Function()` from
         * the expression string — this is CSP `unsafe-eval`, not
         * `unsafe-inline`, and no nonce can permit it. There is no
         * CSP-compliant way to run Filament without it (Alpine's separate
         * "CSP build" avoids this but isn't what Livewire bundles, and
         * doesn't support the expressions Filament's own views use).
         * Scoped to /admin only — the public site has no Livewire/Alpine
         * and keeps the stricter policy. User-confirmed trade-off; see
         * docs/decisions.md.
         */
        $adminPath = config('admin.path');
        $scriptSrc = $request->is($adminPath, "{$adminPath}/*")
            ? "script-src 'self' 'nonce-{$nonce}' 'unsafe-eval'"
            : "script-src 'self' 'nonce-{$nonce}'";

        $csp = implode('; ', [
            "default-src 'self'",
            $scriptSrc,
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
