<?php

it('accepts a valid email and redirects back with an acknowledgement', function () {
    $response = $this->from('/newsletter')->post('/newsletter/subscribe', ['email' => 'family@example.com']);

    $response->assertRedirect('/newsletter');
    $response->assertSessionHas('status');
});

it('rejects an invalid email address', function () {
    $response = $this->from('/newsletter')->post('/newsletter/subscribe', ['email' => 'not-an-email']);

    $response->assertRedirect('/newsletter');
    $response->assertSessionHasErrors('email');
});

it('throttles repeated subscription attempts', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->post('/newsletter/subscribe', ['email' => 'family@example.com']);
    }

    $response = $this->post('/newsletter/subscribe', ['email' => 'family@example.com']);

    $response->assertStatus(429);
});
