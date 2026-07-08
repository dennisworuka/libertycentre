<?php

use App\Domain\Content\Models\Redirect;

it('redirects and increments the hit counter when a matching path is requested', function () {
    $redirect = Redirect::create([
        'from_path' => '/old-page',
        'to_path' => '/new-page',
        'status_code' => 301,
    ]);

    $response = $this->get('/old-page');

    $response->assertRedirect('/new-page');
    $response->assertStatus(301);

    expect($redirect->fresh()->hits)->toBe(1);
});

it('returns a 404 when no route or redirect matches', function () {
    $this->get('/this-does-not-exist-anywhere')->assertNotFound();
});
