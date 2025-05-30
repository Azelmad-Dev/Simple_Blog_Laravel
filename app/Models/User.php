<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'password',
        'admin_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's username with first letter capitalized using Accessor.
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => strtolower($value),
        );
    }

    protected function usernameWithRole(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $roleText = $attributes['role'] === 1 ? 'Admin' : 'User';
                return ucfirst($attributes['username']) . " ({$roleText})";
            },
        );
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    // Get recent posts (last 7 days)
    // This is an example of a scoped Relationships
    public function recentPosts()
    {
        return $this->posts()->where('created_at', '>=', now()->subDays(7));
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 1;
    }

    public function isUser(): bool
    {
        return $this->role === 2;
    }

    public function hasRole()
    {
        if ($this->isAdmin()) {
            return 'admin.dashboard';
        } else if ($this->isUser()) {
            return 'dashboard';
        } else {
            return 'login';
        }
    }
}
