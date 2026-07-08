<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('users.view');
    }

    public function view(User $user, mixed $model = null): bool
    {
        return $user->can('users.view');
    }

    public function create(User $user): bool
    {
        return $user->can('users.manage');
    }

    public function update(User $user, mixed $model = null): bool
    {
        return $user->can('users.manage');
    }

    public function delete(User $user, mixed $model = null): bool
    {
        return $user->can('users.manage') && $model instanceof User && $user->isNot($model);
    }
}
