<?php

namespace App\Support\Html;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Committed allow-list for editor-authored rich text: safe inline
 * formatting, lists, links and images only. No scripts, styles, iframes,
 * or event-handler attributes can survive this, regardless of what an
 * editor pastes in.
 */
class Purifier
{
    protected static ?HTMLPurifier $instance = null;

    public static function clean(string $html): string
    {
        return static::instance()->purify($html);
    }

    protected static function instance(): HTMLPurifier
    {
        if (static::$instance) {
            return static::$instance;
        }

        $config = HTMLPurifier_Config::createDefault();

        $config->set('HTML.Allowed', implode(',', [
            'p', 'br', 'strong', 'em', 'u', 's',
            'ul', 'ol', 'li',
            'a[href|title|rel|target]',
            'h2', 'h3', 'h4',
            'blockquote',
            'img[src|alt|width|height]',
        ]));
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('HTML.TargetBlank', true);
        $config->set('Cache.SerializerPath', storage_path('app/htmlpurifier'));

        return static::$instance = new HTMLPurifier($config);
    }
}
