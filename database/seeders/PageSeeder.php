<?php

namespace Database\Seeders;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Liberty Centre Limited delivers compassionate, person-centred care tailored to the unique needs, abilities and aspirations of every individual we support. We take the time to understand each person beyond their condition, focusing on their strengths, preferences and personal goals.</p><p>We are regulated by the Care Quality Commission and were rated Good in 2026.</p>']],
                    ['type' => 'feature_list', 'data' => ['title' => 'What we stand for', 'items' => [
                        ['icon' => '', 'title' => 'Person-centred', 'description' => 'Every plan starts with the person, not a diagnosis.'],
                        ['icon' => '', 'title' => 'Honest and accountable', 'description' => 'We record what we do and welcome scrutiny — from families and regulators alike.'],
                        ['icon' => '', 'title' => 'Rooted in West Yorkshire', 'description' => 'A local team who know the area and its services.'],
                    ]]],
                ],
            ],
            [
                'title' => 'Our Approach',
                'slug' => 'our-approach',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>No two people are the same, and no two support plans should be either. Our approach is built on three pillars that shape everything we do.</p>']],
                    ['type' => 'steps', 'data' => ['title' => 'Three pillars', 'items' => [
                        ['title' => 'Person-centred', 'description' => 'Support built around the individual — their routines, preferences and goals.'],
                        ['title' => 'Strengths-based', 'description' => 'We start with what someone can do, and build their confidence and independence from there.'],
                        ['title' => 'Independence-focused', 'description' => 'Every plan works towards greater independence, however small the next step.'],
                    ]]],
                ],
            ],
            [
                'title' => 'Referrals',
                'slug' => 'referrals',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Referrals can come from families, local authorities, NHS professionals or the person themselves. We aim to acknowledge every referral within one working day.</p>']],
                    ['type' => 'steps', 'data' => ['title' => 'What happens next', 'items' => [
                        ['title' => 'We listen', 'description' => 'A member of our team will call to understand the support being sought.'],
                        ['title' => 'We assess', 'description' => 'Where appropriate, we carry out an assessment visit with the person and their family.'],
                        ['title' => 'We respond', 'description' => 'We confirm whether we can help and, if so, what support would look like.'],
                    ]]],
                    ['type' => 'rich_text', 'data' => ['content' => '<p>The structured referral form below will be enabled shortly. In the meantime, please <a href="/contact">contact us</a> directly.</p>']],
                ],
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>We would love to hear from you. Call, email, or use the form below and we will get back to you as soon as we can.</p>']],
                ],
            ],
            [
                'title' => 'Newsletter',
                'slug' => 'newsletter',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Sign up for occasional updates from Liberty Centre — news, vacancies and stories from the people and families we support. We will never share your details, and you can unsubscribe at any time.</p>']],
                ],
            ],
            [
                'title' => 'Privacy Notice',
                'slug' => 'privacy',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>This notice explains how Liberty Centre Limited collects, uses and protects personal information in line with UK GDPR.</p><h2>What we collect</h2><p>We collect information you provide directly, such as through our contact and referral forms, and information relating to job applications.</p><h2>How we use it</h2><p>We use your information to respond to enquiries, process referrals and applications, and — where you have opted in — to send our newsletter.</p><h2>Your rights</h2><p>You have the right to access, correct or request deletion of your personal data. Contact us to make a request.</p>']],
                ],
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookies',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>We use a small number of cookies to make this website work well. You can accept or reject non-essential cookies at any time using the cookie banner or the link in our footer.</p><table><thead><tr><th>Category</th><th>Purpose</th></tr></thead><tbody><tr><td>Essential</td><td>Required for the site to function — these cannot be switched off.</td></tr><tr><td>Analytics</td><td>Helps us understand how the site is used. Only set with your consent.</td></tr></tbody></table>']],
                ],
            ],
            [
                'title' => 'Accessibility Statement',
                'slug' => 'accessibility',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Liberty Centre Limited is committed to making this website accessible to everyone, in line with WCAG 2.2 AA. We test with automated tools and screen readers, and we welcome feedback if you find anything that does not work well for you.</p>']],
                ],
            ],
            [
                'title' => 'Terms of Use',
                'slug' => 'terms',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>These terms govern your use of this website. Content is provided for general information about Liberty Centre Limited\'s services and is not a substitute for professional advice.</p>']],
                ],
            ],
            [
                'title' => 'Safeguarding',
                'slug' => 'safeguarding',
                'body' => [
                    ['type' => 'rich_text', 'data' => ['content' => '<p>Safeguarding the people we support is at the centre of everything we do. All our staff are trained in safeguarding adults, and every concern is taken seriously and acted upon quickly.</p><h2>How to raise a concern</h2><p>If you are worried about the safety or wellbeing of someone we support, please contact us directly or speak to your local authority safeguarding team.</p>']],
                ],
            ],
        ];

        foreach ($pages as $page) {
            Page::create([
                'title' => $page['title'],
                'slug' => $page['slug'],
                'body' => $page['body'],
                'status' => PublishStatus::Published,
                'published_at' => now(),
            ]);
        }
    }
}
