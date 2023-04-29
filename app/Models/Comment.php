<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class Comment extends Model implements ReactableInterface
{
    use HasFactory, Reactable;

    protected $fillable = [
        'text',
        'upvotes',
        'downvotes',
        'rating',
    ];

    public static function ratingUpdate()
    {
        static::creating(function ($comment) {
            $comment->rating = $comment->upvotes - $comment->downvotes;
        });
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
