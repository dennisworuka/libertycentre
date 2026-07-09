<?php

namespace App\Support;

final class Permissions
{
    public const ROLES = [
        'Super Admin',
        'Admin',
        'Content Editor',
        'HR / Recruitment',
        'Care Manager',
    ];

    public const MAP = [
        'users.manage' => ['Super Admin'],
        'settings.manage' => ['Super Admin', 'Admin'],
        'media.manage' => ['Super Admin', 'Admin', 'Content Editor'],
        'menus.manage' => ['Super Admin', 'Admin', 'Content Editor'],
        'audit.view' => ['Super Admin', 'Admin'],
        'dashboard.view' => ['Super Admin', 'Admin', 'Content Editor', 'HR / Recruitment', 'Care Manager'],
    ];

    public static function roleCan(string $role, string $permission): bool
    {
        return in_array($role, self::MAP[$permission] ?? [], true);
    }
}
