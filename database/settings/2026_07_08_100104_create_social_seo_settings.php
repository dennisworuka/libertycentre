<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('social_seo.facebook_url', null);
        $this->migrator->add('social_seo.twitter_url', null);
        $this->migrator->add('social_seo.linkedin_url', null);
        $this->migrator->add('social_seo.instagram_url', null);
        $this->migrator->add('social_seo.default_meta_title', 'Liberty Centre Limited — Specialist Care');
        $this->migrator->add('social_seo.default_meta_description', 'CQC-rated Good specialist care provider supporting people with autism and learning disabilities.');
        $this->migrator->add('social_seo.default_share_image_media_uuid', null);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('social_seo.facebook_url');
        $this->migrator->deleteIfExists('social_seo.twitter_url');
        $this->migrator->deleteIfExists('social_seo.linkedin_url');
        $this->migrator->deleteIfExists('social_seo.instagram_url');
        $this->migrator->deleteIfExists('social_seo.default_meta_title');
        $this->migrator->deleteIfExists('social_seo.default_meta_description');
        $this->migrator->deleteIfExists('social_seo.default_share_image_media_uuid');
    }
};
