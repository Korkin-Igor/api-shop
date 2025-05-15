<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Cart $cart): bool
    {
        return !$user->is_admin;
    }
}
