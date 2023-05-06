<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;-
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableInterface;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements ReacterableInterface
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Reacterable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'country',
        'avatar',
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
