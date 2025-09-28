<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;

trait LoginTokenGenerator
{
    protected function generateUserToken(User $user): string
    {
        return $user->createToken('auth-token')->plainTextToken;
    }
}
