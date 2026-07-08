<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Post;
use Illuminate\Http\UploadedFile;

it('reports missing alt text on the hero image and reflects it once set', function () {
    $post = Post::create(['title' => 'A Post', 'body' => [], 'status' => PublishStatus::Draft]);

    $post->addMedia(UploadedFile::fake()->image('hero.jpg'))
        ->toMediaCollection(Post::HERO_IMAGE_COLLECTION);

    expect($post->heroImageHasAltText())->toBeFalse();

    $post->getFirstMedia(Post::HERO_IMAGE_COLLECTION)
        ->setCustomProperty('alt', 'A support worker helping someone in the garden')
        ->save();

    expect($post->fresh()->heroImageHasAltText())->toBeTrue();
});

it('generates the 480/960/1440 webp conversions for the hero image', function () {
    $post = Post::create(['title' => 'A Post', 'body' => [], 'status' => PublishStatus::Draft]);

    $post->addMedia(UploadedFile::fake()->image('hero.jpg', 2000, 1200))
        ->toMediaCollection(Post::HERO_IMAGE_COLLECTION);

    $media = $post->fresh()->getFirstMedia(Post::HERO_IMAGE_COLLECTION);

    expect($media->hasGeneratedConversion('480'))->toBeTrue()
        ->and($media->hasGeneratedConversion('960'))->toBeTrue()
        ->and($media->hasGeneratedConversion('1440'))->toBeTrue();
});
