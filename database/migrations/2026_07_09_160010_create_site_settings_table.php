<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('site_name')->default('Liberty Centre Limited');
            $table->string('strapline')->nullable();
            $table->json('identity')->nullable();
            $table->json('branding')->nullable();
            $table->json('contact')->nullable();
            $table->json('social_links')->nullable();
            $table->json('cqc')->nullable();
            $table->json('forms')->nullable();
            $table->json('seo_analytics')->nullable();
            $table->json('cookie_banner')->nullable();
            $table->json('retention')->nullable();
            $table->boolean('maintenance_enabled')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
