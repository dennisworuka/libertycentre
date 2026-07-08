<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Every seeded account — including local dev — gets 2FA pre-provisioned
     * (non-negotiable #10), since login requires TOTP with no exceptions.
     */
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (! $email || ! $password) {
            $this->command?->warn('ADMIN_EMAIL / ADMIN_PASSWORD are not set in .env — skipping super admin seed.');

            return;
        }

        $google2fa = new Google2FA;
        $secret = $google2fa->generateSecretKey();

        $recoveryCodes = collect(range(1, 8))
            ->map(fn () => Str::upper(Str::random(4).'-'.Str::random(4)))
            ->all();

        $user = User::withTrashed()->updateOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name'),
                'password' => $password,
                'deleted_at' => null,
                'two_factor_secret' => $secret,
                'two_factor_recovery_codes' => $recoveryCodes,
                'two_factor_confirmed_at' => now(),
            ]
        );

        $user->syncRoles(['super_admin']);

        $this->command?->info("Super admin seeded: {$email}");
        $this->command?->warn("TOTP secret (add to an authenticator app): {$secret}");
        $this->command?->warn('Recovery codes, shown once: '.implode(', ', $recoveryCodes));
    }
}
