<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Service;
use App\Domain\Content\Models\Testimonial;

it('lists only published services on the services index', function () {
    Service::create([
        'title' => 'Autism Support',
        'summary' => 'One-to-one support.',
        'body' => [],
        'order' => 0,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Service::create([
        'title' => 'Draft Service',
        'summary' => 'Not yet live.',
        'body' => [],
        'order' => 1,
        'status' => PublishStatus::Draft,
    ]);

    $response = $this->get('/services');

    $response->assertOk();
    $response->assertSee('Autism Support');
    $response->assertDontSee('Draft Service');
});

it('renders a published service detail page with its testimonials', function () {
    $service = Service::create([
        'title' => 'Autism Support',
        'summary' => 'One-to-one support.',
        'body' => [
            ['type' => 'rich_text', 'data' => ['content' => '<p>We support autistic people to live life on their own terms.</p>']],
        ],
        'order' => 0,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $otherService = Service::create([
        'title' => 'Supported Living',
        'summary' => 'Your own front door.',
        'body' => [],
        'order' => 1,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Testimonial::create([
        'quote' => 'The autism team really understood him.',
        'attribution' => 'A parent',
        'consent_on_file' => true,
        'service_id' => $service->id,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Testimonial::create([
        'quote' => 'Supported living gave her independence.',
        'attribution' => 'A sibling',
        'consent_on_file' => true,
        'service_id' => $otherService->id,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get("/services/{$service->slug}");

    $response->assertOk();
    $response->assertSee('Autism Support');
    $response->assertSee('live life on their own terms', false);
    $response->assertSee('The autism team really understood him.', false);
    $response->assertDontSee('Supported living gave her independence.', false);
});

it('returns 404 for a draft or unpublished service slug', function () {
    $draft = Service::create([
        'title' => 'Draft Service',
        'summary' => 'Not yet live.',
        'body' => [],
        'order' => 0,
        'status' => PublishStatus::Draft,
    ]);

    $this->get("/services/{$draft->slug}")->assertNotFound();
    $this->get('/services/does-not-exist')->assertNotFound();
});
