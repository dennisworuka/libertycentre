<?php

namespace App\Policies;

use App\Models\ServicePage;
use App\Models\User;

class ServicePagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function view(User $user, ServicePage $servicePage): bool
    {
        return $user->can('pages.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function update(User $user, ServicePage $servicePage): bool
    {
        return $user->can('pages.manage');
    }

    public function delete(User $user, ServicePage $servicePage): bool
    {
        return $user->can('pages.manage');
    }
}
