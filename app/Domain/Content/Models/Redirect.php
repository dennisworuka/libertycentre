<?php

namespace App\Domain\Content\Models;

use App\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use LogsAdminActivity;

    protected $fillable = [
        'from_path',
        'to_path',
        'status_code',
        'hits',
    ];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'hits' => 'integer',
        ];
    }

    public function incrementHits(): void
    {
        $this->increment('hits');
    }
}
