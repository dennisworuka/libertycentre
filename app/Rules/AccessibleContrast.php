<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AccessibleContrast implements ValidationRule
{
    public function __construct(private readonly string $against, private readonly float $minimum = 4.5)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! self::isHex($value) || ! self::isHex($this->against)) {
            return;
        }

        if (self::ratio($value, $this->against) < $this->minimum) {
            $fail('The selected colour combination does not meet WCAG AA contrast.');
        }
    }

    public static function ratio(string $foreground, string $background): float
    {
        $lighter = max(self::luminance($foreground), self::luminance($background));
        $darker = min(self::luminance($foreground), self::luminance($background));

        return ($lighter + 0.05) / ($darker + 0.05);
    }

    private static function luminance(string $hex): float
    {
        [$r, $g, $b] = array_map(
            fn (int $value): float => ($value / 255 <= 0.03928)
                ? ($value / 255) / 12.92
                : (($value / 255 + 0.055) / 1.055) ** 2.4,
            self::rgb($hex)
        );

        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    private static function rgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    private static function isHex(string $value): bool
    {
        return preg_match('/^#[0-9a-fA-F]{6}$/', $value) === 1;
    }
}
