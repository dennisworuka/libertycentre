<?php

use App\Domain\Content\Models\NavigationItem;

it('allows a two-level nested navigation structure', function () {
    $parent = NavigationItem::create(['label' => 'Services', 'url' => '/services', 'location' => NavigationItem::LOCATION_HEADER]);

    $child = NavigationItem::create(['label' => 'Autism Support', 'url' => '/services/autism-support', 'parent_id' => $parent->id, 'location' => NavigationItem::LOCATION_HEADER]);

    expect($child->parent_id)->toBe($parent->id)
        ->and($parent->children()->count())->toBe(1);
});

it('rejects a third level of navigation nesting', function () {
    $parent = NavigationItem::create(['label' => 'Services', 'url' => '/services', 'location' => NavigationItem::LOCATION_HEADER]);
    $child = NavigationItem::create(['label' => 'Autism Support', 'url' => '/services/autism-support', 'parent_id' => $parent->id, 'location' => NavigationItem::LOCATION_HEADER]);

    NavigationItem::create(['label' => 'Too deep', 'url' => '/too-deep', 'parent_id' => $child->id, 'location' => NavigationItem::LOCATION_HEADER]);
})->throws(RuntimeException::class);
