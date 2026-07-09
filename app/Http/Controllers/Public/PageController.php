<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\Page;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    use LoadsPublicLayoutData;

    public function about(): View
    {
        return $this->renderBySlug('about');
    }

    public function missionVisionValues(): View
    {
        return $this->renderBySlug('about/mission-vision-values');
    }

    public function show(string $slug): View
    {
        return $this->renderBySlug($slug);
    }

    private function renderBySlug(string $slug): View
    {
        $page = Page::query()->where('slug', $slug)->where('status', 'published')->firstOrFail();

        return view('public.pages.show', $this->publicLayoutData([
            'page' => $page,
            'title' => $page->title . ' | Liberty Centre Limited',
        ]));
    }
}
