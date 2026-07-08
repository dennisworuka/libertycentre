<?php

namespace Database\Seeders;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Liberty Centre rated Good by the CQC',
                'category' => 'Company news',
                'author_name' => 'Liberty Centre Team',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>We are delighted to share that Liberty Centre has been rated Good by the Care Quality Commission following our latest inspection. The rating reflects the dedication of our staff and the trust our families place in us every day.</p>']],
                ],
            ],
            [
                'title' => 'What to expect from your first referral call',
                'category' => 'Guidance',
                'author_name' => 'Beatrice Dankwa',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Making a referral can feel daunting. Here is exactly what happens after you get in touch, and how quickly you can expect to hear back from us.</p>']],
                ],
            ],
            [
                'title' => 'Meet the team: our new senior support workers',
                'category' => 'Company news',
                'author_name' => 'Liberty Centre Team',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>We are growing our senior support team this year. Here is a short introduction to the people joining us, and what drew them to care work.</p>']],
                ],
            ],
            [
                'title' => 'Five ways we make sensory-friendly spaces at home',
                'category' => 'Guidance',
                'author_name' => 'Dr. Rolland Dankwa',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Small changes to lighting, sound and layout can make a huge difference for autistic people at home. Here are five practical adjustments our support workers use every day.</p>']],
                ],
            ],
            [
                'title' => 'Celebrating Learning Disability Week with our community',
                'category' => 'Events',
                'author_name' => 'Liberty Centre Team',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>This year we marked Learning Disability Week with a community open day, bringing together the people we support, their families, and local partners across West Yorkshire.</p>']],
                ],
            ],
            [
                'title' => 'How supported living funding actually works',
                'category' => 'Guidance',
                'author_name' => 'Beatrice Dankwa',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Funding for supported living can come from a local authority, the NHS, or a mix of both. We break down the basics so families know what to ask when planning next steps.</p>']],
                ],
            ],
        ];

        foreach ($posts as $index => $post) {
            Post::create([
                'title' => $post['title'],
                'category' => $post['category'],
                'author_name' => $post['author_name'],
                'body' => $post['body'],
                'status' => PublishStatus::Published,
                'published_at' => now()->subDays($index),
            ]);
        }
    }
}
