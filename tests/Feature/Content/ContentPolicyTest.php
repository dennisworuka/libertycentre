<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

it('lets editor publish pages but not viewer', function () {
    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $viewer = User::factory()->create();
    $viewer->assignRole('viewer');

    $page = Page::create(['title' => 'Some Page', 'body' => [], 'status' => PublishStatus::Draft]);

    expect($editor->can('publish', $page))->toBeTrue()
        ->and($viewer->can('publish', $page))->toBeFalse();
});

it('lets viewer view pages but not manage them', function () {
    $viewer = User::factory()->create();
    $viewer->assignRole('viewer');

    $page = Page::create(['title' => 'Some Page', 'body' => [], 'status' => PublishStatus::Draft]);

    expect($viewer->can('view', $page))->toBeTrue()
        ->and($viewer->can('update', $page))->toBeFalse()
        ->and($viewer->can('delete', $page))->toBeFalse();
});

it('lets recruiter and newsletter_manager do nothing with pages', function (string $role) {
    $user = User::factory()->create();
    $user->assignRole($role);

    $page = Page::create(['title' => 'Some Page', 'body' => [], 'status' => PublishStatus::Draft]);

    expect($user->can('view', $page))->toBeFalse()
        ->and($user->can('publish', $page))->toBeFalse();
})->with(['recruiter', 'newsletter_manager']);
