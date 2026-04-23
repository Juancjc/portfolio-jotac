<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    protected $guarded = [];

    protected $casts = [
        'featured' => 'boolean',
        'active'   => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clicksLog(): HasMany
    {
        return $this->hasMany(LinkClick::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    public function resolveUrl(): string
    {
        if ($this->type === 'internal') {
            try {
                return route($this->url);
            } catch (\Throwable) {
                return url($this->url);
            }
        }
        return $this->url;
    }
}
