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
