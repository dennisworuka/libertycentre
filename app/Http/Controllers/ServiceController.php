<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Service;
use App\Domain\Content\Models\Testimonial;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'title' => 'Our Services',
            'services' => Service::published()->orderBy('order')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::published()->where('slug', $slug)->firstOrFail();

        return view('pages.services.show', [
            'title' => $service->meta_title ?: $service->title,
            'metaDescription' => $service->meta_description ?: $service->summary,
            'service' => $service,
            'testimonials' => Testimonial::published()->where('service_id', $service->id)->get(),
        ]);
    }
}
