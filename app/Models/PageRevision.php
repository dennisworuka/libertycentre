<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageRevision extends Model
{
    protected $fillable = ['page_id', 'snapshot', 'created_by'];

    protected $casts = ['snapshot' => 'array'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
