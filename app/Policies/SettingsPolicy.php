<?php

namespace App\Policies;

use App\Models\User;

/**
 * Shared policy for every Spatie settings group (App\Settings\*). Registered
 * against each settings class in AppServiceProvider — only super_admin
 * passes BasePolicy::before(); every other role is denied by default.
 */
class SettingsPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function update(User $user, mixed $model = null): bool
    {
        return false;
    }
}
