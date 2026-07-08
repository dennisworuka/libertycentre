<?php

namespace App\Policies;

use App\Models\User;

/**
 * Deny-by-default base: every concrete policy extends this and only gains
 * access by overriding a method to return true (or via an explicit
 * permission check). Nothing is implicitly allowed.
 *
 * Model parameters are typed `mixed` (not omitted) so concrete policies can
 * narrow them to a specific model class without violating PHP's parameter
 * variance rules.
 */
abstract class BasePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('super_admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, mixed $model = null): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, mixed $model = null): bool
    {
        return false;
    }

    public function delete(User $user, mixed $model = null): bool
    {
        return false;
    }

    public function restore(User $user, mixed $model = null): bool
    {
        return false;
    }

    public function forceDelete(User $user, mixed $model = null): bool
    {
        return false;
    }
}
