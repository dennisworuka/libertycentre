<?php

namespace App\Domain\Content\Policies;

use App\Models\User;

class TeamMemberPolicy extends ContentPolicy
{
    protected static string $permissionPrefix = 'team';

    /**
     * No dedicated team.publish permission is seeded — publishing a team
     * member is folded into team.manage.
     */
    public function publish(User $user, mixed $model = null): bool
    {
        return $user->can('team.manage');
    }
}
