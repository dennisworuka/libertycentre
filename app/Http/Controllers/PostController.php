<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $posts = Post::published()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $categories = Post::published()->select('category')->distinct()->pluck('category')->filter()->values();

        return view('pages.news.index', [
            'title' => 'News & Updates',
            'posts' => $posts,
            'categories' => $categories,
            'activeCategory' => $category,
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($query) => $query->where('category', $post->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.news.show', [
            'title' => $post->meta_title ?: $post->title,
            'metaDescription' => $post->meta_description,
            'post' => $post,
            'related' => $related,
        ]);
    }

    public function feed(): Response
    {
        $posts = Post::published()->latest('published_at')->take(20)->get();

        return response()
            ->view('feeds.news', ['posts' => $posts])
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }
}
