<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Post;
use App\Domain\Content\Models\Service;
use App\Domain\Content\Models\Testimonial;

it('renders the homepage with published services, testimonials and news', function () {
    $service = Service::create([
        'title' => 'Autism Support',
        'summary' => 'One-to-one support.',
        'body' => [],
        'order' => 0,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Testimonial::create([
        'quote' => 'They changed our lives.',
        'attribution' => 'A family member',
        'consent_on_file' => true,
        'service_id' => $service->id,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Post::create([
        'title' => 'Liberty Centre rated Good by the CQC',
        'category' => 'Company news',
        'author_name' => 'Liberty Centre Team',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Service::create([
        'title' => 'Draft Service',
        'summary' => 'Should not appear.',
        'body' => [],
        'order' => 1,
        'status' => PublishStatus::Draft,
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Autism Support');
    $response->assertSee('They changed our lives.', false);
    $response->assertSee('Liberty Centre rated Good by the CQC');
    $response->assertDontSee('Draft Service');
    $response->assertSee('Skip to main content', false);
});

it('includes organisation JSON-LD structured data on the homepage', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('application/ld+json', false);
    $response->assertSee('"@type":"Organization"', false);
});

it('renders the hero slider with all three slides, one h1 and an accessible pause control', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('id="heroSlider"', false);
    $response->assertSee('Specialist care that starts with the person, not the diagnosis');
    $response->assertSee('Rated Good by the CQC');
    $response->assertSee('Join a team that makes a real difference');

    $content = $response->getContent();
    expect(substr_count($content, '<h1'))->toBe(1);
    expect($content)->toContain('data-hero-slider-toggle')
        ->toContain('aria-pressed="false"');
});
