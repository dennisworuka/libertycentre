<?php

namespace Database\Seeders;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Autism Support',
                'icon' => 'heroicon-o-puzzle-piece',
                'summary' => 'One-to-one support built around how each person actually experiences the world, at home or out in the community.',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>We support autistic people to live life on their own terms. That starts with understanding sensory needs, communication preferences and routines — not fitting someone into a standard plan.</p>']],
                    ['type' => 'feature_list', 'data' => ['title' => 'What we provide', 'items' => [
                        ['icon' => '', 'title' => 'Personalised routines', 'description' => 'Daily support built around the person\'s own pace and preferences.'],
                        ['icon' => '', 'title' => 'Sensory-aware environments', 'description' => 'Homes and activities adapted to reduce sensory overload.'],
                        ['icon' => '', 'title' => 'Communication support', 'description' => 'Including AAC, Makaton and visual schedules where helpful.'],
                    ]]],
                ],
            ],
            [
                'title' => 'Learning Disability Support',
                'icon' => 'heroicon-o-academic-cap',
                'summary' => 'Practical, person-centred support that builds skills and independence at a pace that works for each individual.',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>We focus on what someone can do, and build from there. Support plans are written with the person and their family, and reviewed regularly so they keep pace with changing goals.</p>']],
                    ['type' => 'feature_list', 'data' => ['title' => 'What we provide', 'items' => [
                        ['icon' => '', 'title' => 'Daily living skills', 'description' => 'Cooking, budgeting and household routines, taught step by step.'],
                        ['icon' => '', 'title' => 'Community access', 'description' => 'Support to get out, try new things and build confidence.'],
                        ['icon' => '', 'title' => 'Health coordination', 'description' => 'Working alongside GPs, therapists and specialists.'],
                    ]]],
                ],
            ],
            [
                'title' => 'Supported Living',
                'icon' => 'heroicon-o-home',
                'summary' => 'Your own home, your own front door — with the right level of support to make that work day to day.',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Supported living means having a tenancy in your own name, with support visits tailored to what you need — from a few hours a week to round-the-clock care.</p>']],
                    ['type' => 'steps', 'data' => ['title' => 'How we work', 'items' => [
                        ['title' => 'Getting to know you', 'description' => 'We start with a full assessment of what independence looks like for you.'],
                        ['title' => 'Building your support', 'description' => 'A tailored rota, reviewed as your needs change.'],
                        ['title' => 'Staying connected', 'description' => 'Regular check-ins with you, your family and your local authority.'],
                    ]]],
                ],
            ],
            [
                'title' => 'Respite & Short Breaks',
                'icon' => 'heroicon-o-sun',
                'summary' => 'Short breaks that give everyone a change of scene — and give family carers a proper rest.',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Whether it\'s a planned weekend or an emergency break, our short breaks are run by the same familiar, trained staff — so the person we support always sees a friendly face.</p>']],
                ],
            ],
            [
                'title' => 'Community Outreach',
                'icon' => 'heroicon-o-user-group',
                'summary' => 'Support to get out into West Yorkshire — clubs, volunteering, education and just being part of local life.',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Independence isn\'t just about the home — it\'s about being part of a community. We support people to access clubs, classes, volunteering and paid work across the local area.</p>']],
                ],
            ],
        ];

        foreach ($services as $index => $service) {
            Service::create([
                'title' => $service['title'],
                'icon' => $service['icon'],
                'summary' => $service['summary'],
                'body' => $service['body'],
                'order' => $index,
                'status' => PublishStatus::Published,
                'published_at' => now(),
            ]);
        }
    }
}
