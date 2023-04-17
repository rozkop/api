<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'post_id',
        'text',
        'upvotes',
        'downvotes',
        'rating',
    ];

    public static function ratingUpdate(){
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
