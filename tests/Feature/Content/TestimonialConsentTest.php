<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Testimonial;

it('blocks publishing a testimonial without consent on file', function () {
    Testimonial::create([
        'quote' => 'Great service',
        'attribution' => 'A family',
        'consent_on_file' => false,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);
})->throws(RuntimeException::class, 'consent on file');

it('allows a testimonial to stay a draft without consent on file', function () {
    $testimonial = Testimonial::create([
        'quote' => 'Great service',
        'attribution' => 'A family',
        'consent_on_file' => false,
        'status' => PublishStatus::Draft,
    ]);

    expect($testimonial->status)->toBe(PublishStatus::Draft);
});

it('allows publishing a testimonial once consent is on file', function () {
    $testimonial = Testimonial::create([
        'quote' => 'Great service',
        'attribution' => 'A family',
        'consent_on_file' => true,
        'status' => PublishStatus::Published,
        'published_at' => now(),
    ]);

    expect($testimonial->fresh()->status)->toBe(PublishStatus::Published);
});
