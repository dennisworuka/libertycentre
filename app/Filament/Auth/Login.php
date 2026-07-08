<?php

namespace App\Filament\Auth;

use App\Models\User;
use App\Services\Auth\LoginThrottle;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

/**
 * Two-step login: password first, then a mandatory TOTP (or recovery) code.
 * No account is authenticated (no session/remember cookie is set) until the
 * code step passes — see CLAUDE.md non-negotiable #10.
 */
class Login extends BaseLogin
{
    // A precomputed hash checked when no user exists, so a missing account
    // takes the same time as a wrong password and can't be timed out.
    protected const DUMMY_HASH = '$2y$12$Uu8VP1AOJ.EFf3v0G7z9Y.ycT0Sm1D8j0y0m0e4tX8vQZ1fW6bWWG';

    public bool $awaitingCode = false;

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        return $this->awaitingCode
            ? $this->verifyCode()
            : $this->verifyCredentials();
    }

    protected function verifyCredentials(): ?LoginResponse
    {
        $data = $this->form->getState();
        $email = $data['email'];

        $throttle = app(LoginThrottle::class);

        if ($throttle->locked($email)) {
            $this->throwLockedValidationException($throttle->secondsRemaining($email));
        }

        $user = User::where('email', $email)->first();

        // Always hash-check, even for a non-existent user, so a missing
        // account can't be distinguished from a wrong password by timing.
        $passwordMatches = Hash::check($data['password'], $user->password ?? self::DUMMY_HASH);

        if (! $user || ! $passwordMatches) {
            $throttle->hit($email);
            $this->logAttempt($email, 'failed login (bad credentials)');
            $this->throwFailureValidationException();
        }

        if (! $user->canAccessPanel(Filament::getCurrentPanel())) {
            $throttle->hit($email);
            $this->logAttempt($email, 'failed login (panel access denied)');
            $this->throwFailureValidationException();
        }

        if (! $user->hasTwoFactorEnabled()) {
            // No exceptions: every account must already have 2FA provisioned.
            // If this ever fires, provisioning was skipped — fail closed.
            $throttle->hit($email);
            $this->logAttempt($email, 'failed login (2FA not provisioned)');
            $this->throwFailureValidationException();
        }

        session(['two_factor.pending_user_id' => $user->getKey()]);
        $this->awaitingCode = true;
        $this->form->fill(['email' => $email, 'password' => '', 'code' => '']);

        return null;
    }

    protected function verifyCode(): ?LoginResponse
    {
        $userId = session('two_factor.pending_user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user) {
            $this->awaitingCode = false;
            $this->throwFailureValidationException();
        }

        $throttle = app(LoginThrottle::class);

        if ($throttle->locked($user->email)) {
            $this->throwLockedValidationException($throttle->secondsRemaining($user->email));
        }

        $data = $this->form->getState();
        $code = trim((string) ($data['code'] ?? ''));

        $validCode = $code !== '' && (new Google2FA)->verifyKey($user->two_factor_secret, $code);

        if (! $validCode && $code !== '') {
            $recoveryCodes = $user->two_factor_recovery_codes ?? [];

            if (in_array($code, $recoveryCodes, true)) {
                $validCode = true;
                $user->forceFill([
                    'two_factor_recovery_codes' => array_values(array_diff($recoveryCodes, [$code])),
                ])->save();
            }
        }

        if (! $validCode) {
            $throttle->hit($user->email);
            $this->logAttempt($user->email, 'failed login (invalid 2FA code)');

            throw ValidationException::withMessages([
                'data.code' => __('That code is not valid.'),
            ]);
        }

        $throttle->clear($user->email);
        session()->forget('two_factor.pending_user_id');

        Auth::guard(Filament::getAuthGuard())->login($user);

        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ])->saveQuietly();

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function logAttempt(string $email, string $description): void
    {
        activity('auth')
            ->withProperties(['email' => $email, 'ip' => request()->ip()])
            ->log($description);
    }

    protected function throwLockedValidationException(int $secondsRemaining): never
    {
        $minutes = max(1, (int) ceil($secondsRemaining / 60));

        throw ValidationException::withMessages([
            'data.email' => __('Too many failed attempts on this account. Try again in :minutes minute(s).', ['minutes' => $minutes]),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema($this->awaitingCode
                        ? [$this->getCodeFormComponent()]
                        : [$this->getEmailFormComponent(), $this->getPasswordFormComponent()])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getCodeFormComponent(): Component
    {
        return TextInput::make('code')
            ->label(__('Authentication code'))
            ->helperText(__('Enter the 6-digit code from your authenticator app, or a recovery code.'))
            ->required()
            ->autofocus()
            ->extraInputAttributes([
                'autocomplete' => 'one-time-code',
                'inputmode' => 'numeric',
                'tabindex' => 1,
            ]);
    }
}
