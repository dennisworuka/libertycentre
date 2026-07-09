<?php

namespace App\Http\Controllers\Public\Concerns;

use App\Models\MenuItem;
use App\Models\SiteSetting;

trait LoadsPublicLayoutData
{
    protected function publicLayoutData(array $data = []): array
    {
        return array_merge([
            'settings' => SiteSetting::current(),
            'headerMenu' => MenuItem::query()->where('menu', 'header')->where('is_active', true)->orderBy('sort_order')->get(),
            'footerMenu' => MenuItem::query()->where('menu', 'footer')->where('is_active', true)->orderBy('sort_order')->get(),
        ], $data);
    }
}
