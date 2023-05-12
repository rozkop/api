<?php

namespace App\Models;

use Qirolab\Laravel\Reactions\Traits\Reactable;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model implements ReactableInterface
{
    use HasFactory, Reactable;

    protected $fillable = [
        'text',
        'rating',
        'user_id',
        'post_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public 
    public function getReactions()
    {
        return $this->update([$this->rating = $this->reaction_summary]);

    }
}
