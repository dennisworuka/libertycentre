<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['quote', 'attribution', 'relationship', 'consent_confirmed', 'is_published', 'sort_order'];

    protected $casts = [
        'consent_confirmed' => 'boolean',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Testimonial $testimonial): void {
            if ($testimonial->is_published && ! $testimonial->consent_confirmed) {
                throw ValidationException::withMessages(['consent_confirmed' => 'Consent must be confirmed before publishing.']);
            }
        });
    }
}
