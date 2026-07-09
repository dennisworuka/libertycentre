<?php

namespace App\Policies;

use App\Models\Faq;
use App\Models\User;

class FaqPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function view(User $user, Faq $faq): bool
    {
        return $user->can('pages.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function update(User $user, Faq $faq): bool
    {
        return $user->can('pages.manage');
    }

    public function delete(User $user, Faq $faq): bool
    {
        return $user->can('pages.manage');
    }
}
