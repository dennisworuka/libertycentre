<?php

use App\Services\Auth\LoginThrottle;

it('locks an account after the maximum attempts and clears on success', function () {
    $throttle = new LoginThrottle;
    $email = 'someone@example.com';

    expect($throttle->locked($email))->toBeFalse();

    for ($i = 0; $i < 5; $i++) {
        $throttle->hit($email);
    }

    expect($throttle->locked($email))->toBeTrue()
        ->and($throttle->secondsRemaining($email))->toBeGreaterThan(0);

    $throttle->clear($email);

    expect($throttle->locked($email))->toBeFalse()
        ->and($throttle->secondsRemaining($email))->toBe(0);
});

it('does not lock an account under the attempt threshold', function () {
    $throttle = new LoginThrottle;
    $email = 'someone-else@example.com';

    for ($i = 0; $i < 4; $i++) {
        $throttle->hit($email);
    }

    expect($throttle->locked($email))->toBeFalse();
});
