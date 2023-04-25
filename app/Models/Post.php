<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'title',
        'slug',
        'text',
        'upvotes',
        'downvotes',
        'rating',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public static function ratingUpdate()
    {
        static::creating(function ($post) {
            $post->rating = $post->upvotes - $post->downvotes;
        });
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
