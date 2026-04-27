<?php

namespace App\Policies;

use App\Models\DishReview;
use App\Models\User;

class DishReviewPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DishReview $review): bool
    {
        return $user->id === $review->user_id;
    }

    public function delete(User $user, DishReview $review): bool
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }
}