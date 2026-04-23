<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $guarded = [];

    protected $casts = [
        'active'          => 'boolean',
        'overlay_opacity' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () =>
            $this->image_path
                ? Storage::disk('public')->url($this->image_path)
                : null
        );
    }
}
