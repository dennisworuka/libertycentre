<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\CompliancePage;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class ComplianceController extends Controller
{
    use LoadsPublicLayoutData;

    public function show(string $slug): View
    {
        $page = CompliancePage::published()->where('slug', $slug)->firstOrFail();

        return view('public.compliance.show', $this->publicLayoutData([
            'page' => $page,
            'retention' => SiteSetting::current()->retention ?? [],
            'title' => $page->title . ' | Liberty Centre Limited',
        ]));
    }
}
