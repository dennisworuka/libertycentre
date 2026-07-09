<?php

namespace App\Policies;

use App\Models\CompliancePage;
use App\Models\User;

class CompliancePagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function view(User $user, CompliancePage $compliancePage): bool
    {
        return $user->can('pages.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('pages.manage');
    }

    public function update(User $user, CompliancePage $compliancePage): bool
    {
        return $user->can('pages.manage');
    }

    public function delete(User $user, CompliancePage $compliancePage): bool
    {
        return $user->can('pages.manage');
    }
}
