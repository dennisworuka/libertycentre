<?php

use App\Filament\Auth\Login;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

function createTwoFactorUser(string $password = 'Correct-Password-123!'): array
{
    $google2fa = new Google2FA;
    $secret = $google2fa->generateSecretKey();

    $user = User::factory()->create([
        'password' => $password,
        'two_factor_secret' => $secret,
        'two_factor_recovery_codes' => ['AAAA-1111', 'BBBB-2222'],
        'two_factor_confirmed_at' => now(),
    ]);
    $user->assignRole('viewer');

    return [$user, $secret, $google2fa];
}

it('does not authenticate on password alone — a code step is required', function () {
    [$user] = createTwoFactorUser();

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'Correct-Password-123!')
        ->call('authenticate');

    expect(auth()->check())->toBeFalse();
});

it('rejects an invalid TOTP code and keeps the user logged out', function () {
    [$user] = createTwoFactorUser();

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'Correct-Password-123!')
        ->call('authenticate')
        ->set('data.code', '000000')
        ->call('authenticate')
        ->assertHasErrors(['data.code']);

    expect(auth()->check())->toBeFalse();
});

it('logs in once the correct TOTP code is supplied', function () {
    [$user, $secret, $google2fa] = createTwoFactorUser();

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'Correct-Password-123!')
        ->call('authenticate')
        ->set('data.code', $google2fa->getCurrentOtp($secret))
        ->call('authenticate');

    expect(auth()->check())->toBeTrue()
        ->and(auth()->id())->toBe($user->id);
});

it('accepts a recovery code once and then rejects it on reuse', function () {
    [$user] = createTwoFactorUser();

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'Correct-Password-123!')
        ->call('authenticate')
        ->set('data.code', 'AAAA-1111')
        ->call('authenticate');

    expect(auth()->check())->toBeTrue();

    auth()->logout();

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'Correct-Password-123!')
        ->call('authenticate')
        ->set('data.code', 'AAAA-1111')
        ->call('authenticate')
        ->assertHasErrors(['data.code']);

    expect(auth()->check())->toBeFalse();
});

it('rejects a wrong password before the 2FA step is ever reached', function () {
    [$user] = createTwoFactorUser();

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'totally-wrong-password')
        ->call('authenticate')
        ->assertHasErrors(['data.email']);

    expect(auth()->check())->toBeFalse();
});
