<?php

namespace App\Domain\Content\Policies;

use App\Models\User;
use App\Policies\BasePolicy;

class NavigationItemPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('navigation.manage');
    }

    public function view(User $user, mixed $model = null): bool
    {
        return $user->can('navigation.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('navigation.manage');
    }

    public function update(User $user, mixed $model = null): bool
    {
        return $user->can('navigation.manage');
    }

    public function delete(User $user, mixed $model = null): bool
    {
        return $user->can('navigation.manage');
    }
}
