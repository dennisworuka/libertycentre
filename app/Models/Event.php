<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'slug', 'starts_at', 'location', 'is_published'];

    protected $casts = ['starts_at' => 'datetime', 'is_published' => 'boolean'];
}
