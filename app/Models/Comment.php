<?php

namespace App\Models;

use App\Models\CrossUsage\GetReactions;
use App\Models\CrossUsage\HasUserReacted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Qirolab\Laravel\Reactions\Traits\Reactable;

class Comment extends Model implements ReactableInterface
{
    use HasFactory, Reactable, GetReactions, HasUserReacted;

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
}
