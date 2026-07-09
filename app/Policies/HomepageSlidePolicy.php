<?php

namespace App\Policies;

use App\Models\HomepageSlide;
use App\Models\User;

class HomepageSlidePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('homepage.manage');
    }

    public function view(User $user, HomepageSlide $homepageSlide): bool
    {
        return $user->can('homepage.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('homepage.manage');
    }

    public function update(User $user, HomepageSlide $homepageSlide): bool
    {
        return $user->can('homepage.manage');
    }

    public function delete(User $user, HomepageSlide $homepageSlide): bool
    {
        return $user->can('homepage.manage');
    }
}
