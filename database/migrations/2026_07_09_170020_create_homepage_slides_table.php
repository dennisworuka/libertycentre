<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_slides', function (Blueprint $table): void {
            $table->id();
            $table->string('heading');
            $table->text('subheading')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt');
            $table->json('buttons')->nullable();
            $table->decimal('overlay_opacity', 3, 2)->default(0.55);
            $table->string('focal_point')->default('center center');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('publish_from')->nullable();
            $table->timestamp('publish_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_slides');
    }
};
