<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'community_id', 
        'title', 
        'slug', 
        'text'];

    protected static function booted() {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
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
}
