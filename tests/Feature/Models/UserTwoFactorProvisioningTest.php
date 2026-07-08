<?php

use App\Models\User;

it('always provisions 2FA when a user is created, with no way to opt out', function () {
    $user = User::factory()->create([
        'two_factor_secret' => null,
        'two_factor_confirmed_at' => null,
    ]);

    expect($user->hasTwoFactorEnabled())->toBeTrue()
        ->and($user->two_factor_secret)->not->toBeEmpty()
        ->and($user->two_factor_recovery_codes)->toHaveCount(8);
});

it('does not overwrite an explicitly provided 2FA secret', function () {
    $user = User::factory()->create([
        'two_factor_secret' => 'EXPLICIT-SECRET',
        'two_factor_recovery_codes' => ['ONE-CODE'],
        'two_factor_confirmed_at' => now(),
    ]);

    expect($user->two_factor_secret)->toBe('EXPLICIT-SECRET')
        ->and($user->two_factor_recovery_codes)->toBe(['ONE-CODE']);
});
