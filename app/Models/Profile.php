<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'social_links' => 'array',
        'tech_stack'   => 'array',
        'experiences'  => 'array',
    ];

    protected $appends = ['avatar_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn () =>
            $this->avatar_path
                ? Storage::disk('public')->url($this->avatar_path)
                : null
        );
    }

    public function githubHandle(): ?string
    {
        if ($this->github_username) return $this->github_username;
        if ($this->github_url && preg_match('#github\.com/([^/?]+)#i', $this->github_url, $m)) {
            return $m[1];
        }
        return null;
    }
}
