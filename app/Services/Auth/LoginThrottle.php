<?php

namespace App\Services\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Per-account progressive lockout, on top of Filament's built-in per-IP
 * rate limit (5/min via WithRateLimiting on the login page). Keyed by
 * email so a distributed attack against one account still gets locked out
 * even when spread across many IPs.
 */
class LoginThrottle
{
    protected const MAX_ATTEMPTS = 5;

    protected const MAX_LOCK_MINUTES = 60;

    public function locked(string $email): bool
    {
        return $this->lockedUntil($email)?->isFuture() ?? false;
    }

    public function secondsRemaining(string $email): int
    {
        $until = $this->lockedUntil($email);

        return $until ? max(0, (int) now()->diffInSeconds($until, false)) : 0;
    }

    public function hit(string $email): void
    {
        $attemptsKey = $this->attemptsKey($email);

        Cache::add($attemptsKey, 0, now()->addHour());
        $attempts = Cache::increment($attemptsKey);

        if ($attempts >= self::MAX_ATTEMPTS) {
            $lockMinutes = min(2 ** ($attempts - self::MAX_ATTEMPTS), self::MAX_LOCK_MINUTES);
            $until = now()->addMinutes($lockMinutes);

            Cache::put($this->lockKey($email), $until, $until);
        }
    }

    public function clear(string $email): void
    {
        Cache::forget($this->attemptsKey($email));
        Cache::forget($this->lockKey($email));
    }

    protected function lockedUntil(string $email): ?Carbon
    {
        return Cache::get($this->lockKey($email));
    }

    protected function attemptsKey(string $email): string
    {
        return 'login-attempts:'.sha1(strtolower($email));
    }

    protected function lockKey(string $email): string
    {
        return 'login-lockout:'.sha1(strtolower($email));
    }
}
