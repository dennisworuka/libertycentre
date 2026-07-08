<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Page;
use App\Domain\Content\Models\Post;
use App\Domain\Content\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            ['loc' => url('/'), 'lastmod' => now()],
        ];

        foreach (Service::published()->get() as $service) {
            $urls[] = ['loc' => url("/services/{$service->slug}"), 'lastmod' => $service->updated_at ?? now()];
        }

        foreach (Post::published()->get() as $post) {
            $urls[] = ['loc' => url("/news/{$post->slug}"), 'lastmod' => $post->updated_at ?? now()];
        }

        foreach (Page::published()->get() as $page) {
            $urls[] = ['loc' => url("/{$page->slug}"), 'lastmod' => $page->updated_at ?? now()];
        }

        return response()
            ->view('feeds.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
