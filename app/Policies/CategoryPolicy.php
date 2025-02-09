<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    public function before(?User $user, string $ability): ?bool
    {
        if ($user?->role == 1) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewCategoriesPage(?User $user): bool
    {
        return $user?->role == 1;
    }
}
