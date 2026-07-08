<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Post;

it('lists published posts and filters by category on the news index', function () {
    Post::create([
        'title' => 'Company update one',
        'category' => 'Company news',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    Post::create([
        'title' => 'A guidance article',
        'category' => 'Guidance',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    Post::create([
        'title' => 'Draft article',
        'category' => 'Guidance',
        'body' => [],
        'status' => PublishStatus::Draft,
    ]);

    $response = $this->get('/news');
    $response->assertOk();
    $response->assertSee('Company update one');
    $response->assertSee('A guidance article');
    $response->assertDontSee('Draft article');

    $filtered = $this->get('/news?category=Guidance');
    $filtered->assertOk();
    $filtered->assertSee('A guidance article');
    $filtered->assertDontSee('Company update one');
});

it('renders a published article with related posts in the same category', function () {
    $post = Post::create([
        'title' => 'Liberty Centre rated Good by the CQC',
        'category' => 'Company news',
        'author_name' => 'Liberty Centre Team',
        'body' => [
            ['type' => 'rich_text', 'data' => ['content' => '<p>We are delighted to share our latest CQC rating.</p>']],
        ],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $related = Post::create([
        'title' => 'Meet the team: our new senior support workers',
        'category' => 'Company news',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get("/news/{$post->slug}");

    $response->assertOk();
    $response->assertSee('Liberty Centre rated Good by the CQC');
    $response->assertSee('Liberty Centre Team');
    $response->assertSee('our latest CQC rating', false);
    $response->assertSee('Meet the team: our new senior support workers');
    $response->assertSee('"@type":"Article"', false);
});

it('returns 404 for a draft article', function () {
    $draft = Post::create([
        'title' => 'Draft article',
        'body' => [],
        'status' => PublishStatus::Draft,
    ]);

    $this->get("/news/{$draft->slug}")->assertNotFound();
});

it('serves the news RSS feed with the correct content type', function () {
    Post::create([
        'title' => 'Liberty Centre rated Good by the CQC',
        'body' => [],
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get('/news/feed');

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
    $response->assertSee('<rss version="2.0">', false);
    $response->assertSee('Liberty Centre rated Good by the CQC');
});
