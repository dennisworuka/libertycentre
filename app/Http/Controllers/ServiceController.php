<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Service;
use App\Domain\Content\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'title' => 'Our Services',
            'services' => Service::published()->orderBy('order')->get(),
        ]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $service = Service::published()->where('slug', $slug)->first();

        if (! $service) {
            return $this->redirectOrAbort("/services/{$slug}");
        }

        return view('pages.services.show', [
            'title' => $service->meta_title ?: $service->title,
            'metaDescription' => $service->meta_description ?: $service->summary,
            'service' => $service,
            'testimonials' => Testimonial::published()->where('service_id', $service->id)->get(),
        ]);
    }
}
