<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permission matrix from the Web Application Specification, Section 6.1.
     * super_admin is granted everything implicitly via BasePolicy::before(),
     * but is synced with the full list too so the matrix stays auditable
     * from the Filament Roles screen.
     */
    public function run(): void
    {
        $permissions = [
            'settings.view', 'settings.update',
            'users.view', 'users.manage',
            'activity-log.view',
            'pages.view', 'pages.manage', 'pages.publish',
            'services.view', 'services.manage', 'services.publish',
            'news.view', 'news.manage', 'news.publish',
            'testimonials.view', 'testimonials.manage', 'testimonials.publish',
            'media.view', 'media.manage',
            'team.view', 'team.manage',
            'navigation.manage', 'redirects.manage',
            'vacancies.view', 'vacancies.manage',
            'applications.view', 'applications.manage', 'cv.download',
            'forms.view', 'forms.manage',
            'subscribers.view', 'subscribers.manage',
            'campaigns.view', 'campaigns.manage', 'campaigns.send',
            'exports.create',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $roles = [
            'super_admin' => $permissions,

            'editor' => [
                'pages.view', 'pages.manage', 'pages.publish',
                'services.view', 'services.manage', 'services.publish',
                'news.view', 'news.manage', 'news.publish',
                'testimonials.view', 'testimonials.manage', 'testimonials.publish',
                'media.view', 'media.manage',
                'team.view', 'team.manage',
                'navigation.manage', 'redirects.manage',
            ],

            'recruiter' => [
                'vacancies.view', 'vacancies.manage',
                'applications.view', 'applications.manage',
                'cv.download',
            ],

            'newsletter_manager' => [
                'subscribers.view', 'subscribers.manage',
                'campaigns.view', 'campaigns.manage', 'campaigns.send',
            ],

            'viewer' => [
                'pages.view', 'services.view', 'news.view',
                'testimonials.view', 'media.view', 'team.view',
                'forms.view',
            ],
        ];

        foreach ($roles as $name => $rolePermissions) {
            $role = Role::findOrCreate($name, 'web');
            $role->syncPermissions($rolePermissions);
        }
    }
}
