<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\Page;
use Illuminate\Contracts\View\View;

class EasyReadController extends Controller
{
    use LoadsPublicLayoutData;

    public function __invoke(): View
    {
        return view('public.easy-read.index', $this->publicLayoutData([
            'pages' => Page::query()->where('template', 'easy_read')->where('status', 'published')->orderBy('title')->get(),
            'title' => 'Easy Read | Liberty Centre Limited',
        ]));
    }
}
