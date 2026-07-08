<?php

it('renders the branded 404 page for an unknown path', function () {
    $response = $this->get('/this-does-not-exist-anywhere');

    $response->assertNotFound();
    $response->assertSee('Page not found');
    $response->assertSee('Return home');
});
