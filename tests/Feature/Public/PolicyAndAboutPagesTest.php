<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use App\Domain\Content\Models\TeamMember;

it('renders the about page with its custom template and leadership team', function () {
    Page::create([
        'title' => 'About Us',
        'slug' => 'about',
        'body' => [
            ['type' => 'rich_text', 'data' => ['content' => '<p>Liberty Centre has supported people across West Yorkshire for over a decade.</p>']],
        ],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    TeamMember::create([
        'name' => 'Beatrice Dankwa',
        'role' => 'Registered Manager',
        'order' => 0,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get('/about');

    $response->assertOk();
    $response->assertSee('About Us');
    $response->assertSee('supported people across West Yorkshire', false);
    $response->assertSee('Beatrice Dankwa');
    $response->assertSee('Registered Manager');
});

it('falls back to the generic page template for policy pages without a bespoke view', function () {
    Page::create([
        'title' => 'Privacy Policy',
        'slug' => 'privacy',
        'body' => [
            ['type' => 'rich_text', 'data' => ['content' => '<p>We take the privacy of the people we support seriously.</p>']],
        ],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get('/privacy');

    $response->assertOk();
    $response->assertSee('Privacy Policy');
    $response->assertSee('privacy of the people we support', false);
});

it('returns 404 for a draft page and for an unknown slug', function () {
    Page::create([
        'title' => 'Draft Page',
        'slug' => 'draft-page',
        'body' => [],
        'status' => PublishStatus::Draft,
    ]);

    $this->get('/draft-page')->assertNotFound();
    $this->get('/no-such-page')->assertNotFound();
});
