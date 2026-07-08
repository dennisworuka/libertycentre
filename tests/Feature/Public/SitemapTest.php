<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use App\Domain\Content\Models\Post;
use App\Domain\Content\Models\Service;

it('includes the homepage plus every published service, post and page in the sitemap', function () {
    $service = Service::create([
        'title' => 'Autism Support',
        'summary' => 'One-to-one support.',
        'body' => [],
        'order' => 0,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $post = Post::create([
        'title' => 'Liberty Centre rated Good by the CQC',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $page = Page::create([
        'title' => 'Privacy Policy',
        'slug' => 'privacy',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Service::create([
        'title' => 'Draft Service',
        'summary' => 'Not live.',
        'body' => [],
        'order' => 1,
        'status' => PublishStatus::Draft,
    ]);

    $response = $this->get('/sitemap.xml');

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    $response->assertSee(url('/'), false);
    $response->assertSee(url("/services/{$service->slug}"), false);
    $response->assertSee(url("/news/{$post->slug}"), false);
    $response->assertSee(url("/{$page->slug}"), false);
});
