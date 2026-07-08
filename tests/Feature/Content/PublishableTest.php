<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;

it('hides draft and future-scheduled content from the published scope', function () {
    Page::create(['title' => 'Draft Page', 'body' => [], 'status' => PublishStatus::Draft]);

    Page::create([
        'title' => 'Live Page',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now()->subHour(),
    ]);

    Page::create([
        'title' => 'Future Page',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now()->addDay(),
    ]);

    expect(Page::published()->pluck('title')->all())->toBe(['Live Page']);
});

it('sets first_published_at once and never clears it on later drafts', function () {
    $page = Page::create([
        'title' => 'A Page',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $firstPublishedAt = $page->first_published_at;
    expect($firstPublishedAt)->not->toBeNull();

    $page->update(['status' => PublishStatus::Draft]);

    expect($page->fresh()->first_published_at)->not->toBeNull()
        ->and($page->fresh()->first_published_at->equalTo($firstPublishedAt))->toBeTrue();
});
