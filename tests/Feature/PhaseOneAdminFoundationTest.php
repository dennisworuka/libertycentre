<?php

namespace Tests\Feature;

use App\Models\MediaAsset;
use App\Models\MenuItem;
use App\Models\HomepageSection;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\Auth\LoginThrottle;
use App\Support\Permissions;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class PhaseOneAdminFoundationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_role_permission_matrix_is_enforced_by_policies(): void
    {
        $models = [
            'users.manage' => User::class,
            'settings.manage' => SiteSetting::class,
            'media.manage' => MediaAsset::class,
            'menus.manage' => MenuItem::class,
            'pages.manage' => Page::class,
            'homepage.manage' => HomepageSection::class,
            'audit.view' => Activity::class,
        ];

        foreach (Permissions::ROLES as $role) {
            $user = User::factory()->create(['mfa_confirmed_at' => now()]);
            $user->assignRole($role);

            foreach ($models as $permission => $model) {
                $expected = Permissions::roleCan($role, $permission);

                $this->assertSame($expected, $user->can('viewAny', $model), "{$role} / {$permission}");
            }
        }
    }

    public function test_admin_panel_requires_mfa_enrolment(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $this->actingAs($user)->get('/admin')->assertForbidden();

        $user->forceFill(['mfa_confirmed_at' => now(), 'google2fa_secret' => 'secret'])->save();

        $this->actingAs($user)->get('/admin')->assertOk();
    }

    public function test_media_upload_requires_alt_text(): void
    {
        $this->expectException(ValidationException::class);

        MediaAsset::create([
            'folder' => '/',
            'name' => 'Care support image',
        ]);
    }

    public function test_audit_log_records_create_update_and_delete(): void
    {
        $user = User::factory()->create(['mfa_confirmed_at' => now()]);
        $user->assignRole('Super Admin');
        $this->actingAs($user);

        $menuItem = MenuItem::create([
            'menu' => 'header',
            'label' => 'Contact',
            'type' => 'external',
            'url' => 'https://example.test/contact',
        ]);

        $menuItem->update(['label' => 'Contact us']);
        $menuItem->delete();

        $this->assertDatabaseHas('activity_log', ['event' => 'created']);
        $this->assertDatabaseHas('activity_log', ['event' => 'updated']);
        $this->assertDatabaseHas('activity_log', ['event' => 'deleted']);
    }

    public function test_settings_contrast_checker_flags_bad_colour_pair(): void
    {
        $this->expectException(ValidationException::class);

        SiteSetting::current()->update([
            'branding' => [
                'primary' => '#FFFFFF',
                'on_primary' => '#FFFFFF',
            ],
        ]);
    }

    public function test_login_throttle_locks_account_after_five_failures(): void
    {
        $user = User::factory()->create();
        $throttle = app(LoginThrottle::class);

        foreach (range(1, 5) as $attempt) {
            $throttle->recordFailedAttempt($user->refresh());
        }

        $this->assertTrue($throttle->isLocked($user->refresh()));
        $this->assertTrue($user->locked_until->greaterThan(now()->addMinutes(14)));
    }
}
