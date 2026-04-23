<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'technologies' => 'array',
        'featured'     => 'boolean',
        'published'    => 'boolean',
    ];

    protected $appends = ['image_url'];

    protected static function booted(): void
    {
        static::creating(function (Project $p) {
            if (empty($p->slug)) {
                $base = Str::slug($p->title) ?: 'projeto';
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $p->slug = $slug;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('published', true);
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('featured', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderByDesc('id');
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
