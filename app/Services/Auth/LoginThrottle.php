<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;

class LoginThrottle
{
    public const MAX_ATTEMPTS = 5;

    public function recordFailedAttempt(User $user): void
    {
        $attempts = $user->failed_login_attempts + 1;

        $user->forceFill([
            'failed_login_attempts' => $attempts,
            'locked_until' => $attempts >= self::MAX_ATTEMPTS ? now()->addMinutes(15) : $user->locked_until,
        ])->save();
    }

    public function clear(User $user): void
    {
        $user->forceFill([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ])->save();
    }

    public function isLocked(User $user): bool
    {
        return $user->locked_until instanceof Carbon && $user->locked_until->isFuture();
    }
}
