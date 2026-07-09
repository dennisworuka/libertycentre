<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use App\Models\HomepageSlide;
use App\Models\MenuItem;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class PhaseTwoSeeder extends Seeder
{
    public function run(): void
    {
        HomepageSection::ensureDefaults();

        HomepageSlide::query()->firstOrCreate(
            ['heading' => 'Empowering Lives. Supporting Independence.'],
            [
                'subheading' => 'Specialist support for people with autism, learning disabilities and complex care needs.',
                'image_path' => 'images/hero-care.svg',
                'image_alt' => 'Support worker and service user planning independent living goals',
                'buttons' => [
                    ['label' => 'Make a Referral', 'url' => '/referral', 'style' => 'cta'],
                    ['label' => 'Explore Services', 'url' => '/services', 'style' => 'primary'],
                ],
                'sort_order' => 1,
            ]
        );

        foreach ([
            ['Services', '/services', 1],
            ['About', '/about', 2],
            ['Careers', '/careers', 3],
            ['Contact', '/contact', 4],
        ] as [$label, $url, $order]) {
            MenuItem::query()->firstOrCreate(
                ['menu' => 'header', 'label' => $label],
                ['type' => 'external', 'url' => $url, 'sort_order' => $order]
            );
        }

        Testimonial::query()->firstOrCreate(
            ['quote' => 'Liberty Centre listened carefully and built support around our family member as a person.'],
            ['attribution' => 'Family feedback', 'consent_confirmed' => true, 'is_published' => true]
        );

        Post::query()->firstOrCreate(
            ['slug' => 'cqc-good-rating-2026'],
            ['title' => 'Liberty Centre rated Good by the CQC', 'excerpt' => 'A short update about our 2026 CQC rating.', 'status' => 'published', 'published_at' => now()]
        );
    }
}
