<?php

namespace Tests\Feature;

use App\Models\CompliancePage;
use App\Models\ServicePage;
use App\Models\SiteSetting;
use Database\Seeders\PhaseThreeSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PhaseThreeContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(PhaseThreeSeeder::class);
    }

    public function test_all_five_service_pages_are_live(): void
    {
        $this->assertSame(5, ServicePage::query()->where('status', 'published')->count());

        foreach ([
            'autism-support',
            'supported-living',
            'domiciliary-care',
            'community-life-skills',
            'respite-short-breaks',
        ] as $slug) {
            $this->get("/services/{$slug}")
                ->assertOk()
                ->assertSee('Referral process')
                ->assertSee('Make a Referral');
        }
    }

    public function test_service_page_heading_hierarchy_is_enforced(): void
    {
        $this->expectException(ValidationException::class);

        ServicePage::create([
            'title' => 'Broken service',
            'slug' => 'broken-service',
            'summary' => 'Broken heading structure.',
            'blocks' => [
                ['type' => 'hero', 'heading_level' => 1, 'heading' => 'Broken service'],
                ['type' => 'overview', 'heading_level' => 3, 'heading' => 'Skipped heading'],
            ],
        ]);
    }

    public function test_all_compliance_pages_display_last_reviewed_dates(): void
    {
        $this->assertSame(8, CompliancePage::query()->count());

        foreach (CompliancePage::query()->pluck('slug') as $slug) {
            $this->get("/{$slug}")
                ->assertOk()
                ->assertSee('Last reviewed:')
                ->assertSee(now()->format('j F Y'));
        }
    }

    public function test_privacy_policy_retention_values_come_from_settings(): void
    {
        SiteSetting::current()->update([
            'retention' => [
                'referrals_months' => 91,
                'enquiries_months' => 37,
                'applications_months' => 13,
                'talent_pool_months' => 25,
            ],
        ]);

        $this->get('/privacy-policy')
            ->assertOk()
            ->assertSee('data-retention-source="settings"', false)
            ->assertSee('91 months')
            ->assertSee('37 months')
            ->assertSee('13 months')
            ->assertSee('25 months');
    }

    public function test_faqs_render_native_keyboard_operable_accordion(): void
    {
        $this->get('/faqs')
            ->assertOk()
            ->assertSee('<details class="faq-item">', false)
            ->assertSee('<summary>How do I make a referral?</summary>', false);
    }

    public function test_branded_error_pages_render(): void
    {
        $this->assertStringContainsString('Page not found', View::make('errors.404')->render());
        $this->assertStringContainsString('Access restricted', View::make('errors.403')->render());
        $this->assertStringContainsString('Something went wrong', View::make('errors.500')->render());

        $this->get('/not-a-real-page')->assertNotFound()->assertSee('Page not found');
    }
}
