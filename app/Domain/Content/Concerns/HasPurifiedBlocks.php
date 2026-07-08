<?php

namespace App\Domain\Content\Concerns;

use App\Support\Html\Purifier;

/**
 * Sanitises the rich-HTML fields inside a Filament Builder block array on
 * save. Only the keys known to carry HTML (per block type) are purified —
 * everything else (labels, URLs, icon names) passes through untouched.
 */
trait HasPurifiedBlocks
{
    /**
     * @var array<string, array<int, string>>
     */
    protected static array $purifiedBlockKeys = [
        'rich_text' => ['content'],
        'quote' => ['text'],
        'cta' => ['text'],
        'two_column' => ['left', 'right'],
        'feature_list' => ['items.*.description'],
        'steps' => ['items.*.description'],
        'faq' => ['items.*.answer'],
    ];

    /**
     * Block shape is loosely typed on purpose: this reads editor-submitted
     * Filament Builder state, where a missing 'type' or 'data' key is a
     * runtime possibility even if it shouldn't happen in practice.
     *
     * @param  array<int, array<string, mixed>>  $blocks
     * @return array<int, array<string, mixed>>
     */
    protected function purifyBlocks(array $blocks): array
    {
        foreach ($blocks as &$block) {
            $type = $block['type'] ?? null;
            $keys = static::$purifiedBlockKeys[$type] ?? [];

            foreach ($keys as $key) {
                $block['data'] = $this->purifyDotKey($block['data'] ?? [], $key);
            }
        }

        return $blocks;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function purifyDotKey(array $data, string $key): array
    {
        if (! str_contains($key, '.*.')) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Purifier::clean($data[$key]);
            }

            return $data;
        }

        [$listKey, $itemKey] = explode('.*.', $key, 2);

        if (isset($data[$listKey]) && is_array($data[$listKey])) {
            foreach ($data[$listKey] as &$item) {
                if (is_array($item) && isset($item[$itemKey]) && is_string($item[$itemKey])) {
                    $item[$itemKey] = Purifier::clean($item[$itemKey]);
                }
            }
        }

        return $data;
    }
}
