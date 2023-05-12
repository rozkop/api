<?php

namespace App\Models;

use App\Models\CrossUsage\HasUserReacted;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use App\Models\CrossUsage\GetReactions;

class Post extends Model implements ReactableInterface
{
    use HasFactory, SoftDeletes, Reactable, GetReactions, HasUserReacted;

    protected $fillable =
    [
        'title',
        'slug',
        'text',
        'rating',
        'user_id',
        'community_id',
        'reports',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public static function slugger(Post $post)
    {
        return $post->slug = Str::slug($post->title);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
