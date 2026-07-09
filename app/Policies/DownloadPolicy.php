<?php

namespace App\Policies;

use App\Models\Download;
use App\Models\User;

class DownloadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function view(User $user, Download $download): bool
    {
        return $user->can('pages.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function update(User $user, Download $download): bool
    {
        return $user->can('pages.manage');
    }

    public function delete(User $user, Download $download): bool
    {
        return $user->can('pages.manage');
    }
}
