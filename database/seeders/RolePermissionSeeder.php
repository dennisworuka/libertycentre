<?php

namespace Database\Seeders;

use App\Support\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (array_keys(Permissions::MAP) as $permissionName) {
            Permission::findOrCreate($permissionName);
        }

        foreach (Permissions::ROLES as $roleName) {
            $role = Role::findOrCreate($roleName);
            $role->syncPermissions(
                collect(Permissions::MAP)
                    ->filter(fn (array $roles): bool => in_array($roleName, $roles, true))
                    ->keys()
                    ->all()
            );
        }
    }
}
