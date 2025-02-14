<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Post $post): bool
    {
        return $user?->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * I added ? to ?User to check unauthenticated users , means when $user is null
     * The ?-> operator safely checks the id of the $user only if $user is not null (i.e., authenticated
     */
    public function delete(?User $user, Post $post): Response
    {
        return $user?->id === $post->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }

    public function updateAdmin(User $user, Post $post): bool
    {
        // If the post belongs to another admin
        if ($post->user->isAdmin() && $post->user_id !== $user->id) {
            return false; // Can't update other admins' posts
        }

        // Admin can update their own posts and normal users' posts
        return true;
    }

    public function deleteAdmin(User $user, Post $post): bool
    {
        // If the post belongs to another admin
        if ($post->user->isAdmin() && $post->user_id !== $user->id) {
            return false; // Can't delete other admins' posts
        }

        // Admin can delete their own posts and normal users' posts
        return true;
    }
}
