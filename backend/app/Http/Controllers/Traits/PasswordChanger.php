<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait PasswordChanger
{
    protected function changeUserPassword(User $user, string $newPassword):void
    {
        $user->update(['password' => Hash::make($newPassword)]);
    }
}
