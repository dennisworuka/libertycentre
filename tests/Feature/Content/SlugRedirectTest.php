<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use App\Domain\Content\Models\Redirect;
use App\Domain\Content\Models\Service;

it('auto-generates a unique slug from the title', function () {
    $page = Page::create(['title' => 'Our Approach', 'body' => [], 'status' => PublishStatus::Draft]);

    expect($page->slug)->toBe('our-approach');

    $duplicate = Page::create(['title' => 'Our Approach', 'body' => [], 'status' => PublishStatus::Draft]);

    expect($duplicate->slug)->toBe('our-approach-1');
});

it('creates a 301 redirect when a previously published page changes slug', function () {
    $page = Page::create([
        'title' => 'About Us',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    expect($page->wasEverPublished())->toBeTrue();

    $page->update(['slug' => 'about']);

    $redirect = Redirect::where('from_path', '/about-us')->first();

    expect($redirect)->not->toBeNull()
        ->and($redirect->to_path)->toBe('/about')
        ->and($redirect->status_code)->toBe(301);
});

it('does not create a redirect when a never-published record changes slug', function () {
    $page = Page::create(['title' => 'Draft Page', 'body' => [], 'status' => PublishStatus::Draft]);

    $page->update(['slug' => 'renamed-draft-page']);

    expect(Redirect::count())->toBe(0);
});

it('builds the correct public path per content type', function () {
    $service = Service::create([
        'title' => 'Autism Support',
        'summary' => 'Support for autistic people.',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $service->update(['slug' => 'autism-help']);

    $redirect = Redirect::where('from_path', '/services/autism-support')->first();

    expect($redirect->to_path)->toBe('/services/autism-help');
});
