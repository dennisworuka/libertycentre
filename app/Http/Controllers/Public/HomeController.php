<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\Event;
use App\Models\HomepageSection;
use App\Models\HomepageSlide;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    use LoadsPublicLayoutData;

    public function __invoke(): View
    {
        HomepageSection::ensureDefaults();

        return view('public.home', $this->publicLayoutData([
            'sections' => HomepageSection::query()->where('is_enabled', true)->orderBy('sort_order')->pluck('key')->all(),
            'slides' => $this->slides(),
            'serviceCards' => $this->serviceCards(),
            'testimonials' => Testimonial::query()->where('is_published', true)->where('consent_confirmed', true)->orderBy('sort_order')->limit(6)->get(),
            'posts' => Post::query()->where('status', 'published')->latest('published_at')->limit(3)->get(),
            'events' => Event::query()->where('is_published', true)->where('starts_at', '>=', now())->orderBy('starts_at')->limit(2)->get(),
        ]));
    }

    private function slides()
    {
        $slides = HomepageSlide::visible()->limit(5)->get();

        if ($slides->isNotEmpty()) {
            return $slides;
        }

        return collect([
            new HomepageSlide([
                'heading' => 'Empowering Lives. Supporting Independence.',
                'subheading' => 'Specialist support for people with autism, learning disabilities and complex care needs.',
                'image_path' => 'images/hero-care.svg',
                'image_alt' => 'Support worker and service user planning independent living goals',
                'overlay_opacity' => 0.58,
                'buttons' => [
                    ['label' => 'Make a Referral', 'url' => '/referral', 'style' => 'cta'],
                    ['label' => 'Explore Services', 'url' => '/services', 'style' => 'secondary'],
                ],
            ]),
        ]);
    }

    private function serviceCards(): array
    {
        return [
            ['title' => 'Autism Support', 'summary' => 'Structured, person-centred support that respects communication, sensory and routine needs.', 'url' => '/services/autism-support', 'image' => 'images/service-autism.svg', 'alt' => 'Calm activity planning for autism support', 'icon' => 'A'],
            ['title' => 'Supported Living', 'summary' => 'Practical help to build independence at home, in routines and in the local community.', 'url' => '/services/supported-living', 'image' => 'images/service-living.svg', 'alt' => 'Supported living home skills session', 'icon' => 'L'],
            ['title' => 'Domiciliary Care', 'summary' => 'Personal care and daily living support delivered with dignity and consistency.', 'url' => '/services/domiciliary-care', 'image' => 'images/service-care.svg', 'alt' => 'Domiciliary care support at home', 'icon' => 'D'],
            ['title' => 'Community & Life Skills', 'summary' => 'Confidence-building support for travel, appointments, volunteering and social connection.', 'url' => '/services/community-life-skills', 'image' => 'images/service-community.svg', 'alt' => 'Community life skills support outdoors', 'icon' => 'C'],
            ['title' => 'Respite & Short Breaks', 'summary' => 'Safe short breaks that support the person and give family carers time to rest.', 'url' => '/services/respite-short-breaks', 'image' => 'images/service-respite.svg', 'alt' => 'Relaxed respite and short breaks activity', 'icon' => 'R'],
        ];
    }
}
