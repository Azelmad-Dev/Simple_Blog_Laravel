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
}
