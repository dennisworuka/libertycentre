<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\Faq;
use App\Models\ServicePage;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    use LoadsPublicLayoutData;

    public function index(): View
    {
        return view('public.services.index', $this->publicLayoutData([
            'services' => ServicePage::published()->get(),
            'title' => 'Services | Liberty Centre Limited',
        ]));
    }

    public function show(string $slug): View
    {
        $service = ServicePage::published()->where('slug', $slug)->firstOrFail();

        return view('public.services.show', $this->publicLayoutData([
            'service' => $service,
            'faqs' => Faq::published()->where('service_slug', $service->slug)->get(),
            'title' => $service->title . ' | Liberty Centre Limited',
        ]));
    }
}
