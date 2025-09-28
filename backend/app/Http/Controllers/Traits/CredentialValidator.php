<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CredentialValidator
{
    protected function validateCredentials(?User $user, string $password): bool
    {
        return ($user && Hash::check($password, $user->password));
    }
}
