<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

it('grants every CMS role access to the admin panel', function (string $role) {
    $user = User::factory()->create();
    $user->assignRole($role);

    expect($user->canAccessPanel(Filament::getPanel('admin')))->toBeTrue();
})->with(['super_admin', 'editor', 'recruiter', 'newsletter_manager', 'viewer']);

it('only lets super_admin manage CMS user accounts', function (string $role, bool $expected) {
    $user = User::factory()->create();
    $user->assignRole($role);

    expect($user->can('viewAny', User::class))->toBe($expected)
        ->and($user->can('create', User::class))->toBe($expected);
})->with([
    ['super_admin', true],
    ['editor', false],
    ['recruiter', false],
    ['newsletter_manager', false],
    ['viewer', false],
]);

it('gives editor content permissions but not recruiter or newsletter permissions', function () {
    $editor = User::factory()->create();
    $editor->assignRole('editor');

    expect($editor->can('pages.manage'))->toBeTrue()
        ->and($editor->can('vacancies.manage'))->toBeFalse()
        ->and($editor->can('campaigns.send'))->toBeFalse();
});

it('gives recruiter vacancy and CV permissions but not content or newsletter permissions', function () {
    $recruiter = User::factory()->create();
    $recruiter->assignRole('recruiter');

    expect($recruiter->can('vacancies.manage'))->toBeTrue()
        ->and($recruiter->can('cv.download'))->toBeTrue()
        ->and($recruiter->can('pages.manage'))->toBeFalse()
        ->and($recruiter->can('campaigns.send'))->toBeFalse();
});

it('gives newsletter_manager subscriber and campaign permissions but never export', function () {
    $manager = User::factory()->create();
    $manager->assignRole('newsletter_manager');

    expect($manager->can('campaigns.send'))->toBeTrue()
        ->and($manager->can('subscribers.manage'))->toBeTrue()
        ->and($manager->can('exports.create'))->toBeFalse();
});

it('keeps viewer to read-only content and form permissions', function () {
    $viewer = User::factory()->create();
    $viewer->assignRole('viewer');

    expect($viewer->can('pages.view'))->toBeTrue()
        ->and($viewer->can('forms.view'))->toBeTrue()
        ->and($viewer->can('pages.manage'))->toBeFalse()
        ->and($viewer->can('forms.manage'))->toBeFalse();
});

it('blocks a non-super-admin from opening the users resource over HTTP', function () {
    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $this->actingAs($editor)
        ->get('/admin/users')
        ->assertForbidden();
});
