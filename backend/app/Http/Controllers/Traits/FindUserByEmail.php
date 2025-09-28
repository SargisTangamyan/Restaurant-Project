<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;

trait FindUserByEmail
{
    protected function getUserWithEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
