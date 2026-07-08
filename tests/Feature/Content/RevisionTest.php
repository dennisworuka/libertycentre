<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;

it('snapshots a revision on every save and can restore an earlier one', function () {
    $page = Page::create(['title' => 'Original Title', 'body' => [], 'status' => PublishStatus::Draft]);

    $page->update(['title' => 'Changed Title']);

    expect($page->fresh()->title)->toBe('Changed Title')
        ->and($page->revisions()->count())->toBe(2);

    $originalRevision = $page->revisions()->get()->last();
    expect($originalRevision->payload['title'])->toBe('Original Title');

    $page->restoreRevision($originalRevision);

    expect($page->fresh()->title)->toBe('Original Title');
});
