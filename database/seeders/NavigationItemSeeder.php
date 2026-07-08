<?php

namespace Database\Seeders;

use App\Domain\Content\Models\NavigationItem;
use App\Domain\Content\Models\Service;
use Illuminate\Database\Seeder;

class NavigationItemSeeder extends Seeder
{
    public function run(): void
    {
        $about = NavigationItem::create(['label' => 'About', 'url' => '/about', 'location' => NavigationItem::LOCATION_HEADER, 'order' => 0]);

        $services = NavigationItem::create(['label' => 'Services', 'url' => '/services', 'location' => NavigationItem::LOCATION_HEADER, 'order' => 1]);

        Service::orderBy('order')->get()->each(function (Service $service, int $index) use ($services) {
            NavigationItem::create([
                'label' => $service->title,
                'url' => "/services/{$service->slug}",
                'parent_id' => $services->id,
                'location' => NavigationItem::LOCATION_HEADER,
                'order' => $index,
            ]);
        });

        NavigationItem::create(['label' => 'Careers', 'url' => '/careers', 'location' => NavigationItem::LOCATION_HEADER, 'order' => 2]);
        NavigationItem::create(['label' => 'News', 'url' => '/news', 'location' => NavigationItem::LOCATION_HEADER, 'order' => 3]);
        NavigationItem::create(['label' => 'Referrals', 'url' => '/referrals', 'location' => NavigationItem::LOCATION_HEADER, 'order' => 4]);
        NavigationItem::create(['label' => 'Contact', 'url' => '/contact', 'location' => NavigationItem::LOCATION_HEADER, 'order' => 5]);

        $footerLinks = [
            ['label' => 'Privacy Notice', 'url' => '/privacy'],
            ['label' => 'Cookie Policy', 'url' => '/cookies'],
            ['label' => 'Accessibility Statement', 'url' => '/accessibility'],
            ['label' => 'Terms of Use', 'url' => '/terms'],
            ['label' => 'Safeguarding', 'url' => '/safeguarding'],
        ];

        foreach ($footerLinks as $index => $link) {
            NavigationItem::create([
                'label' => $link['label'],
                'url' => $link['url'],
                'location' => NavigationItem::LOCATION_FOOTER,
                'order' => $index,
            ]);
        }
    }
}
