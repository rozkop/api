<?php

namespace App\Models;

use App\Models\CrossUsage\HasUserReacted;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use App\Models\CrossUsage\GetReactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
