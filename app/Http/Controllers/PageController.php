<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Page;
use App\Domain\Content\Models\TeamMember;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        $view = view()->exists("pages.{$page->slug}") ? "pages.{$page->slug}" : 'pages.generic';

        $extra = [];

        if ($page->slug === 'about') {
            $extra['teamMembers'] = TeamMember::published()->orderBy('order')->get();
        }

        return view($view, array_merge([
            'title' => $page->meta_title ?: $page->title,
            'metaDescription' => $page->meta_description,
            'page' => $page,
        ], $extra));
    }
}
