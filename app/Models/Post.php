<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id', 'user_id', 'image'];

    // withDefault() method will return an empty instance of the related model if the relationship is null
    # Example:
    // $post = Post::find(1);
    // Even if no user exists, this won't throw an error
    // echo $post->user->name; : Will output empty string instead of error
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->chaperone();
    }

    public function scopeYourposts($query)
    {
        return $query->where('user_id', auth()->id());
    }

    // New
    public function scopeByUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    // New scope for category filtering
    public function scopeByCategory($query, $categoryId): void
    {
        $query->where('category_id', $categoryId);
    }
}
