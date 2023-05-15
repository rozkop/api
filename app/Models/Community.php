<?php

namespace App\Models;

use App\Models\CrossUsage\GetReactions;
use App\Models\CrossUsage\HasUserReacted;
use App\QueryBuilders\SearchQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Qirolab\Laravel\Reactions\Traits\Reactable;

class Community extends Model implements ReactableInterface
{
    use HasFactory, SoftDeletes, Reactable, GetReactions, HasUserReacted;

    protected $fillable =
    [
        'name',
        'user_id',
        'description',
        'slug',
        'rating',
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

    public static function slugger(Community $community)
    {
        return $community->slug = Str::slug($community->name);
    }

    public static function query(): SearchQuery
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): SearchQuery
    {
        return new SearchQuery($query);
    }
}
