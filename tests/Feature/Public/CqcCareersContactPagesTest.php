<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;

it('renders the CQC and quality page with the current rating and question breakdown', function () {
    $response = $this->get('/cqc-quality');

    $response->assertOk();
    $response->assertSee('Rated Good by the CQC');
    $response->assertSee('Is it safe?');
    $response->assertSee('Is it well-led?');
});

it('renders the careers page', function () {
    $response = $this->get('/careers');

    $response->assertOk();
    $response->assertSee('Join our team');
    $response->assertSee(route('contact'), false);
});

it('renders the contact page via the dedicated contact route using the contact Page record', function () {
    Page::create([
        'title' => 'Contact',
        'slug' => 'contact',
        'body' => [
            ['type' => 'rich_text', 'data' => ['content' => '<p>Get in touch with our referrals team.</p>']],
        ],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get(route('contact'));

    $response->assertOk();
    $response->assertSee('Get in touch with our referrals team.', false);
    $response->assertSee('safeguarding commitment', false);
});
