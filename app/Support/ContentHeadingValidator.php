<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContentHeadingValidator
{
    public static function validate(array $blocks): void
    {
        $levels = collect($blocks)
            ->pluck('heading_level')
            ->filter()
            ->map(fn (mixed $level): int => (int) $level)
            ->values();

        Validator::make(['h1_count' => $levels->filter(fn (int $level): bool => $level === 1)->count()], [
            'h1_count' => ['required', 'integer', 'in:1'],
        ], [
            'h1_count.in' => 'Content must contain exactly one H1.',
        ])->validate();

        $previous = 0;

        foreach ($levels as $level) {
            if ($level < 1 || $level > 3) {
                throw ValidationException::withMessages(['blocks' => 'Only H1, H2 and H3 headings are supported.']);
            }

            if ($previous > 0 && $level > $previous + 1) {
                throw ValidationException::withMessages(['blocks' => 'Heading levels must be sequential.']);
            }

            $previous = $level;
        }
    }
}
