<?php

namespace Database\Seeders;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Service;
use App\Domain\Content\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'quote' => 'The team took the time to understand our son properly, not just read his file. He is calmer and more confident than we have seen him in years.',
                'attribution' => 'Parent of a person supported',
                'service' => 'Autism Support',
            ],
            [
                'quote' => 'As a commissioner, what stands out is how consistent Liberty Centre is. The same staff, the same standards, every single visit.',
                'attribution' => 'Local authority commissioner',
                'service' => 'Supported Living',
            ],
            [
                'quote' => 'My support worker helped me get my first volunteering placement. I never thought that would be possible for me.',
                'attribution' => 'Person supported by Liberty Centre',
                'service' => 'Community Outreach',
            ],
            [
                'quote' => 'Respite care used to feel like a risk. With Liberty Centre it feels like a relief — for both of us.',
                'attribution' => 'Family carer',
                'service' => 'Respite & Short Breaks',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            $service = Service::where('title', $testimonial['service'])->first();

            Testimonial::create([
                'quote' => $testimonial['quote'],
                'attribution' => $testimonial['attribution'],
                'service_id' => $service?->id,
                'consent_on_file' => true,
                'status' => PublishStatus::Published,
                'published_at' => now(),
            ]);
        }
    }
}
