<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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
    public function view(User $user, Comment $comment): bool
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
    public function update(User $user, Comment $comment): bool
    {
        return $user?->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): Response
    {
        return $user?->id === $comment->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function updateAdmin(User $user, Comment $comment): bool
    {
        if ($comment->user->isAdmin() && $comment->user_id !== $user->id) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function deleteAdmin(User $user, Comment $comment): bool
    {
        if ($comment->user->isAdmin() && $comment->user_id !== $user->id) {
            return false;
        }

        return true;
    }
}
