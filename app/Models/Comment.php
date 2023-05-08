<?php

namespace App\Models;

use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model implements ReactableInterface
{
    use HasFactory, Reactable;

    protected $fillable = [
        'text',
        'rating',
        'rating',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ratingUpdate(Comment $comment)
    {
        return $comment->rating = $comment->viaLoveReactant()->getReactionTotal()->getWeight();
    }
}
