<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\Download;
use Illuminate\Contracts\View\View;

class DownloadController extends Controller
{
    use LoadsPublicLayoutData;

    public function index(): View
    {
        return view('public.downloads.index', $this->publicLayoutData([
            'downloadsByCategory' => Download::published()->get()->groupBy('category'),
            'title' => 'Downloads | Liberty Centre Limited',
        ]));
    }
}
