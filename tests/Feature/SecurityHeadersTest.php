<?php

it('sends strict security headers on the public homepage', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertHeader('X-Frame-Options', 'DENY');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->assertHeader('Strict-Transport-Security', 'max-age=15552000; includeSubDomains');
    $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

    expect($response->headers->get('Content-Security-Policy'))
        ->toContain("default-src 'self'")
        ->toContain("frame-ancestors 'none'")
        ->toContain("object-src 'none'");
});

it('sends strict security headers on the admin login page', function () {
    $response = $this->get('/admin/login');

    $response->assertOk();
    $response->assertHeader('X-Frame-Options', 'DENY');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('Strict-Transport-Security', 'max-age=15552000; includeSubDomains');
    expect($response->headers->get('Content-Security-Policy'))->toContain("default-src 'self'");
});

it('includes a nonce in the script-src and style-src directives', function () {
    $csp = $this->get('/')->headers->get('Content-Security-Policy');

    expect($csp)->toMatch("/script-src 'self' 'nonce-[A-Za-z0-9+\/=]+'/")
        ->toMatch("/style-src 'self' 'nonce-[A-Za-z0-9+\/=]+'/");
});

it('only grants the admin panel its Filament-required CSP relaxations, never the public site', function () {
    $publicCsp = $this->get('/')->headers->get('Content-Security-Policy');
    $adminCsp = $this->get('/admin/login')->headers->get('Content-Security-Policy');

    expect($publicCsp)->not->toContain('unsafe-eval')
        ->not->toContain('unsafe-inline')
        ->not->toContain('fonts.bunny.net')
        ->not->toContain('ui-avatars.com')
        ->and($adminCsp)->toContain("'unsafe-eval'")
        ->toContain("'unsafe-inline'")
        ->toContain('https://fonts.bunny.net')
        ->toContain('https://ui-avatars.com');
});

it('keeps a script-src nonce on the admin panel but drops the style-src nonce (unsafe-inline supersedes it)', function () {
    $adminCsp = $this->get('/admin/login')->headers->get('Content-Security-Policy');

    expect($adminCsp)->toMatch("/script-src 'self' 'nonce-[A-Za-z0-9+\/=]+' 'unsafe-eval'/")
        ->not->toMatch('/style-src[^;]*nonce-/');
});
