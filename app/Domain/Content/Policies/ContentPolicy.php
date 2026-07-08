<?php

namespace App\Domain\Content\Policies;

use App\Models\User;
use App\Policies\BasePolicy;

/**
 * Shared shape for the view/manage/publish permission triad used by every
 * publishable content type. Concrete policies just set $permissionPrefix.
 */
abstract class ContentPolicy extends BasePolicy
{
    protected static string $permissionPrefix;

    public function viewAny(User $user): bool
    {
        return $user->can(static::$permissionPrefix.'.view');
    }

    public function view(User $user, mixed $model = null): bool
    {
        return $user->can(static::$permissionPrefix.'.view');
    }

    public function create(User $user): bool
    {
        return $user->can(static::$permissionPrefix.'.manage');
    }

    public function update(User $user, mixed $model = null): bool
    {
        return $user->can(static::$permissionPrefix.'.manage');
    }

    public function delete(User $user, mixed $model = null): bool
    {
        return $user->can(static::$permissionPrefix.'.manage');
    }

    public function publish(User $user, mixed $model = null): bool
    {
        return $user->can(static::$permissionPrefix.'.publish');
    }
}
