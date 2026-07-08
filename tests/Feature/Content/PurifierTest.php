<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use App\Support\Html\Purifier;

it('strips script tags and event handler attributes but keeps allowed markup', function () {
    $dirty = '<p onclick="alert(1)">Hello <script>alert(2)</script><strong>world</strong></p>';
    $clean = Purifier::clean($dirty);

    expect($clean)->not->toContain('<script')
        ->not->toContain('onclick')
        ->toContain('<strong>world</strong>')
        ->toContain('Hello');
});

it('purifies rich_text block content when a page is saved', function () {
    $page = Page::create([
        'title' => 'Test Page',
        'body' => [
            ['type' => 'rich_text', 'data' => ['content' => '<p>Safe</p><script>alert(1)</script>']],
        ],
        'status' => PublishStatus::Draft,
    ]);

    $content = $page->fresh()->body[0]['data']['content'];

    expect($content)->not->toContain('<script')
        ->toContain('Safe');
});

it('purifies nested repeater fields such as FAQ answers', function () {
    $page = Page::create([
        'title' => 'FAQ Page',
        'body' => [
            ['type' => 'faq', 'data' => ['items' => [
                ['question' => 'Is it safe?', 'answer' => '<p onclick="evil()">Yes</p><script>bad()</script>'],
            ]]],
        ],
        'status' => PublishStatus::Draft,
    ]);

    $answer = $page->fresh()->body[0]['data']['items'][0]['answer'];

    expect($answer)->not->toContain('<script')
        ->not->toContain('onclick')
        ->toContain('Yes');
});

it('leaves non-html block fields untouched', function () {
    $page = Page::create([
        'title' => 'CTA Page',
        'body' => [
            ['type' => 'cta', 'data' => ['heading' => 'Get in touch', 'button_label' => 'Contact us', 'button_url' => 'https://example.com']],
        ],
        'status' => PublishStatus::Draft,
    ]);

    expect($page->fresh()->body[0]['data']['button_url'])->toBe('https://example.com');
});
