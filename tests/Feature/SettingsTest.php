<?php

use App\Settings\ComplianceSettings;
use App\Settings\OrganisationSettings;

it('persists a settings change to the database and cache-busts the resolved instance', function () {
    $settings = app(OrganisationSettings::class);
    $settings->site_name = 'Updated Organisation Name';
    $settings->save();

    $this->assertDatabaseHas('settings', [
        'group' => 'organisation',
        'name' => 'site_name',
    ]);

    app()->forgetInstance(OrganisationSettings::class);

    expect(app(OrganisationSettings::class)->site_name)->toBe('Updated Organisation Name');
});

it('loads the seeded compliance retention defaults used by future purge jobs', function () {
    $settings = app(ComplianceSettings::class);

    expect($settings->retention_contact_months)->toBe(12)
        ->and($settings->retention_referral_months)->toBe(6)
        ->and($settings->retention_cv_months)->toBe(6);
});
