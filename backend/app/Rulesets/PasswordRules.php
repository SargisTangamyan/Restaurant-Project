<?php

namespace App\Rulesets;

use Illuminate\Validation\Rules\Password;

class PasswordRules
{
    public static function strongPassword(): array
    {
        return [
            'password' => ['required', 'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
            ],
        ];
    }
}
