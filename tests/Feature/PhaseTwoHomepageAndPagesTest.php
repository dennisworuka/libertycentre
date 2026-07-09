<?php

namespace Tests\Feature;

use App\Models\HomepageSection;
use App\Models\HomepageSlide;
use App\Models\Page;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PhaseTwoHomepageAndPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_page_blocks_must_have_one_h1_and_sequential_headings(): void
    {
        $this->expectException(ValidationException::class);

        Page::create([
            'title' => 'Broken page',
            'slug' => 'broken-page',
            'status' => 'draft',
            'blocks' => [
                ['type' => 'hero', 'heading_level' => 1, 'heading' => 'Broken page'],
                ['type' => 'rich_text', 'heading_level' => 3, 'heading' => 'Skipped heading'],
            ],
        ]);
    }

    public function test_valid_page_creates_a_revision(): void
    {
        $page = Page::create([
            'title' => 'About Liberty Centre',
            'slug' => 'about-liberty-centre',
            'status' => 'draft',
            'blocks' => [
                ['type' => 'hero', 'heading_level' => 1, 'heading' => 'About Liberty Centre'],
                ['type' => 'rich_text', 'heading_level' => 2, 'heading' => 'Our support'],
                ['type' => 'rich_text', 'heading_level' => 3, 'heading' => 'How we help'],
            ],
        ]);

        $this->assertDatabaseHas('page_revisions', [
            'page_id' => $page->id,
        ]);
    }

    public function test_homepage_slide_requires_alt_text(): void
    {
        $this->expectException(ValidationException::class);

        HomepageSlide::create([
            'heading' => 'Support that starts with the person',
            'subheading' => 'Person-centred care and independence.',
            'image_path' => 'images/hero-care.svg',
            'image_alt' => '',
        ]);
    }

    public function test_homepage_renders_gracefully_when_all_sections_are_hidden(): void
    {
        HomepageSection::ensureDefaults();
        HomepageSection::query()->update(['is_enabled' => false]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Liberty Centre Limited')
            ->assertSee('Homepage sections are currently hidden in the CMS.')
            ->assertDontSee('Quick Service Links');
    }

    public function test_homepage_renders_all_sections_in_spec_order(): void
    {
        HomepageSection::ensureDefaults();

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('data-reduced-motion-static="true"', false)
            ->assertSee('data-slider-pause', false)
            ->assertSee('CQC Good Rating 2026')
            ->assertSee('Quick Service Links')
            ->assertSee('Make a Referral')
            ->assertSee("Years' Experience", false)
            ->assertSee('CQC & Quality Assurance', false)
            ->assertSee('Family Feedback')
            ->assertSee('Latest News & Events', false)
            ->assertSee('Coverage Map')
            ->assertSee('Newsletter Signup')
            ->assertSee('Emergency or urgent concern?');

        $content = $response->getContent();
        $orderedNeedles = [
            'data-home-section="hero_slider"',
            'data-home-section="intro_strip"',
            'data-home-section="service_links"',
            'data-home-section="referral_cta"',
            'data-home-section="stats_strip"',
            'data-home-section="cqc_quality"',
            'data-home-section="testimonials"',
            'data-home-section="latest_news_events"',
            'data-home-section="coverage_map"',
            'data-home-section="newsletter_signup"',
            'data-home-section="urgent_contact"',
        ];

        $previousPosition = -1;

        foreach ($orderedNeedles as $needle) {
            $position = strpos($content, $needle);

            $this->assertNotFalse($position, "{$needle} was not rendered.");
            $this->assertGreaterThan($previousPosition, $position, "{$needle} rendered out of order.");

            $previousPosition = $position;
        }
    }

    public function test_service_card_images_render_with_alt_text(): void
    {
        $content = $this->get('/')->assertOk()->getContent();

        foreach ([
            'Calm activity planning for autism support',
            'Supported living home skills session',
            'Domiciliary care support at home',
            'Community life skills support outdoors',
            'Relaxed respite and short breaks activity',
        ] as $altText) {
            $this->assertStringContainsString('alt="' . $altText . '"', $content);
        }
    }

    public function test_homepage_script_honours_reduced_motion(): void
    {
        $script = file_get_contents(public_path('js/homepage.js'));

        $this->assertStringContainsString('prefers-reduced-motion: reduce', $script);
        $this->assertStringContainsString('data-slider-pause', $script);
    }
}
