<?php

namespace App\Policies;

use App\Models\HomepageSection;
use App\Models\User;

class HomepageSectionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('homepage.manage');
    }

    public function view(User $user, HomepageSection $homepageSection): bool
    {
        return $user->can('homepage.manage');
    }

    public function update(User $user, HomepageSection $homepageSection): bool
    {
        return $user->can('homepage.manage');
    }
}
