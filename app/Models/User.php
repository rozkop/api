<?php

namespace App\Models;

use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableInterface;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements ReacterableInterface, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Reacterable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'country',
        'provider_id',
        'provider_token',
        'provider',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->assignRole('user');
        });
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function communities(): HasMany
    {
        return $this->hasMany(Community::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
