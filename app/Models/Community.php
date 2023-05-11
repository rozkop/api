<?php

namespace App\Models;

use Qirolab\Laravel\Reactions\Traits\Reactable;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Community extends Model implements ReactableInterface
{
    use HasFactory, SoftDeletes, Reactable;

    protected $fillable =
    [
        'name',
        'user_id',
        'description',
        'slug',
        'favourite_count',
        'color,',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($community) {
            $community->slug = Str::slug($community->name);
        });
    }

    public function getReactions()
    {
        return $this->update([$this->rating = $this->reaction_summary]);

    }

    public static function slugger(Community $community)
    {
        return $community->slug = Str::slug($community->name);
    }
}
