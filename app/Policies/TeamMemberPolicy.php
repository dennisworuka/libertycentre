<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function view(User $user, TeamMember $teamMember): bool
    {
        return $user->can('pages.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function update(User $user, TeamMember $teamMember): bool
    {
        return $user->can('pages.manage');
    }

    public function delete(User $user, TeamMember $teamMember): bool
    {
        return $user->can('pages.manage');
    }
}
