<?php

namespace Database\Seeders;

use App\Models\CompliancePage;
use App\Models\Download;
use App\Models\Faq;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\ServicePage;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class PhaseThreeSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedServices();
        $this->seedPages();
        $this->seedCompliancePages();
        $this->seedFaqs();
        $this->seedDownloads();
        $this->seedTeam();
        $this->seedMenus();
    }

    private function seedServices(): void
    {
        foreach ([
            ['Autism Support', 'autism-support', 'Structured support that respects communication, sensory and routine needs.'],
            ['Supported Living', 'supported-living', 'Support to build independence at home and in the community.'],
            ['Domiciliary Care', 'domiciliary-care', 'Personal care and daily living support delivered with dignity.'],
            ['Community & Life Skills', 'community-life-skills', 'Confidence-building support for everyday community life.'],
            ['Respite & Short Breaks', 'respite-short-breaks', 'Safe short breaks for people and family carers.'],
        ] as $index => [$title, $slug, $summary]) {
            ServicePage::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'summary' => $summary,
                    'status' => 'published',
                    'sort_order' => $index + 1,
                    'published_at' => now(),
                    'blocks' => $this->serviceBlocks($title, $summary),
                ]
            );
        }
    }

    private function serviceBlocks(string $title, string $summary): array
    {
        return [
            ['type' => 'hero', 'heading_level' => 1, 'heading' => $title, 'body' => $summary],
            ['type' => 'overview', 'heading_level' => 2, 'heading' => 'Overview', 'body' => 'Support is planned around the person, their routines, preferences, communication and goals.'],
            ['type' => 'who_for', 'heading_level' => 2, 'heading' => 'Who it is for', 'body' => 'This service is for adults who need specialist, person-centred support.'],
            ['type' => 'support', 'heading_level' => 2, 'heading' => 'What support looks like', 'body' => 'Support can include daily routines, personal care, appointments, communication and community access.'],
            ['type' => 'personalised', 'heading_level' => 2, 'heading' => 'How care is personalised', 'body' => 'Plans are strengths-based and reviewed with the person, families and professionals.'],
            ['type' => 'eligibility', 'heading_level' => 2, 'heading' => 'Eligibility and access', 'body' => 'Access may be through local authority funding, NHS continuing healthcare, or private arrangements.'],
            ['type' => 'referral', 'heading_level' => 2, 'heading' => 'Referral process', 'body' => 'Make a referral, share key information, arrange an assessment, agree the plan, and start support.'],
            ['type' => 'benefits', 'heading_level' => 2, 'heading' => 'Benefits', 'body' => 'People are supported to build confidence, independence, safety and meaningful routines.'],
            ['type' => 'involvement', 'heading_level' => 2, 'heading' => 'Family and professional involvement', 'body' => 'We work transparently with families, advocates, commissioners and health professionals.'],
            ['type' => 'cta', 'heading_level' => 2, 'heading' => 'Talk to us', 'body' => 'Contact Liberty Centre or make a referral to discuss next steps.'],
        ];
    }

    private function seedPages(): void
    {
        foreach ([
            ['About', 'about', 'About Liberty Centre', 'We provide regulated, person-centred support with dignity, respect and practical ambition.'],
            ['Mission, Vision & Values', 'about/mission-vision-values', 'Mission, vision and values', 'Our work is guided by independence, safety, inclusion and transparent partnership.'],
        ] as [$title, $slug, $heading, $body]) {
            Page::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'template' => 'default',
                    'status' => 'published',
                    'published_at' => now(),
                    'blocks' => [
                        ['type' => 'hero', 'heading_level' => 1, 'heading' => $heading, 'body' => $body],
                        ['type' => 'rich_text', 'heading_level' => 2, 'heading' => 'How we work', 'body' => 'We keep information clear and involve people in decisions about their support.'],
                    ],
                ]
            );
        }

        foreach ([
            ['Easy Read: About us', 'easy-read/about-us', 'About us', 'Liberty Centre supports people.\nWe listen.\nWe help people make choices.'],
            ['Easy Read: Our services', 'easy-read/our-services', 'Our services', 'We can help at home.\nWe can help in the community.\nWe make a plan with you.'],
            ['Easy Read: How to complain', 'easy-read/how-to-complain', 'How to complain', 'Tell us what went wrong.\nWe will listen.\nWe will reply clearly.'],
            ['Easy Read: Keeping safe', 'easy-read/keeping-safe', 'Keeping you safe', 'You have the right to feel safe.\nTell someone if you are worried.'],
            ['Easy Read: Contact us', 'easy-read/contact-us', 'Contact us', 'You can phone us.\nYou can email us.\nYou can ask someone to help you contact us.'],
        ] as [$title, $slug, $heading, $body]) {
            Page::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'template' => 'easy_read',
                    'status' => 'published',
                    'published_at' => now(),
                    'blocks' => [
                        ['type' => 'hero', 'heading_level' => 1, 'heading' => $heading, 'body' => $body],
                        ['type' => 'image_text', 'heading_level' => 2, 'heading' => 'Plain English information', 'body' => 'Short sentences and one idea at a time.'],
                    ],
                ]
            );
        }
    }

    private function seedCompliancePages(): void
    {
        $reviewed = now()->toDateString();

        foreach ([
            ['Privacy Policy', 'privacy-policy', 'How Liberty Centre handles personal information.', 'Lawful bases include provision of health and social care under Article 9(2)(h), recruitment pre-contract necessity, and newsletter consent. DSAR requests can be made using the contact details on this website. Complaints can be raised with the ICO.'],
            ['Cookie Policy', 'cookie-policy', 'How cookies and similar technologies are managed.', 'Non-essential cookies remain blocked until consent. The full category table is generated from the consent tool.'],
            ['Safeguarding Statement', 'safeguarding-statement', 'How Liberty Centre helps keep people safe.', 'Raise urgent danger with 999. Safeguarding concerns can be raised internally or with the relevant local authority safeguarding team.'],
            ['Complaints Procedure', 'complaints-procedure', 'How to complain and what happens next.', 'Complaints are acknowledged, investigated and responded to. Escalation routes include the Local Government and Social Care Ombudsman and CQC.'],
            ['Whistleblowing Statement', 'whistleblowing-statement', 'How workers can raise concerns.', 'Concerns can be raised without fear of retaliation and will be handled fairly.'],
            ['Modern Slavery Statement', 'modern-slavery-statement', 'Our commitment to preventing exploitation.', 'We expect safe, lawful and ethical practice from staff, suppliers and partners.'],
            ['Equality, Diversity & Inclusion', 'equality-diversity-inclusion', 'Our commitment to fair treatment.', 'We work to remove barriers and respect identity, culture, communication and choice.'],
            ['Accessibility Statement', 'accessibility-statement', 'Accessibility information for this website.', 'This website aims to conform to WCAG 2.2 AA. Known limitations and audit evidence will be updated during the accessibility audit phase. Alternative formats are available on request.'],
        ] as [$title, $slug, $summary, $body]) {
            CompliancePage::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'summary' => $summary,
                    'last_reviewed_at' => $reviewed,
                    'is_published' => true,
                    'content' => [
                        ['heading' => 'Overview', 'body' => $body],
                    ],
                ]
            );
        }
    }

    private function seedFaqs(): void
    {
        foreach ([
            ['Referrals', 'How do I make a referral?', 'Use the referral form or contact us for a conversation about support.', null],
            ['Services', 'Can support be personalised?', 'Yes. Support plans are based on needs, strengths, communication and outcomes.', 'autism-support'],
            ['Safeguarding', 'What should I do in an emergency?', 'Call 999 if someone is in immediate danger.', null],
        ] as [$category, $question, $answer, $serviceSlug]) {
            Faq::query()->updateOrCreate(
                ['question' => $question],
                ['category' => $category, 'answer' => $answer, 'service_slug' => $serviceSlug, 'is_published' => true]
            );
        }
    }

    private function seedDownloads(): void
    {
        Download::query()->updateOrCreate(
            ['title' => 'Service brochure'],
            ['description' => 'A downloadable overview of Liberty Centre services.', 'category' => 'Brochures', 'file_path' => 'downloads/service-brochure.pdf', 'is_published' => true]
        );
    }

    private function seedTeam(): void
    {
        TeamMember::query()->updateOrCreate(
            ['name' => 'Registered Manager'],
            ['role' => 'Registered Manager', 'bio' => 'Leads regulated care, quality and safeguarding practice.', 'dbs_checked' => true, 'leadership' => true, 'is_published' => true]
        );
    }

    private function seedMenus(): void
    {
        foreach ([
            ['footer', 'Privacy Policy', '/privacy-policy', 1],
            ['footer', 'Cookie Policy', '/cookie-policy', 2],
            ['footer', 'Accessibility Statement', '/accessibility-statement', 3],
            ['footer', 'Downloads', '/downloads', 4],
            ['header', 'FAQs', '/faqs', 5],
        ] as [$menu, $label, $url, $order]) {
            MenuItem::query()->firstOrCreate(
                ['menu' => $menu, 'label' => $label],
                ['type' => 'external', 'url' => $url, 'sort_order' => $order]
            );
        }
    }
}
