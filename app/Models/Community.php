<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Community extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'description',
        'slug',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected static function booted()
    {
        static::creating(function ($community) {
            $community->slug = Str::slug($community->name);
        });
    }
}
