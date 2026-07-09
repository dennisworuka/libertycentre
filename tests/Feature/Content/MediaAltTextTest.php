<?php

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Post;
use App\Domain\Content\Models\Service;
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

it('reports missing alt text on the service card image and reflects it once set', function () {
    $service = Service::create(['title' => 'A Service', 'summary' => 'Summary', 'body' => [], 'status' => PublishStatus::Draft]);

    $service->addMedia(UploadedFile::fake()->image('card.jpg'))
        ->toMediaCollection(Service::CARD_IMAGE_COLLECTION);

    expect($service->cardImageHasAltText())->toBeFalse();

    $service->getFirstMedia(Service::CARD_IMAGE_COLLECTION)
        ->setCustomProperty('alt', 'A support worker and a young person planting seedlings together')
        ->save();

    expect($service->fresh()->cardImageHasAltText())->toBeTrue();
});

it('generates the 480/960/1440 webp conversions for the service card image', function () {
    $service = Service::create(['title' => 'A Service', 'summary' => 'Summary', 'body' => [], 'status' => PublishStatus::Draft]);

    $service->addMedia(UploadedFile::fake()->image('card.jpg', 2000, 1200))
        ->toMediaCollection(Service::CARD_IMAGE_COLLECTION);

    $media = $service->fresh()->getFirstMedia(Service::CARD_IMAGE_COLLECTION);

    expect($media->hasGeneratedConversion('480'))->toBeTrue()
        ->and($media->hasGeneratedConversion('960'))->toBeTrue()
        ->and($media->hasGeneratedConversion('1440'))->toBeTrue();
});
