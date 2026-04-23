<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkClick extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['clicked_at' => 'datetime'];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
