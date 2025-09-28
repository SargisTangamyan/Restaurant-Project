<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CredentialValidator;
use App\Http\Controllers\Traits\PasswordChanger;
use App\Models\User;
use App\Notifications\AccountDeleted;
use App\Rulesets\PasswordRules;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Enums\ResponseStatus;

class AccountController extends Controller
{
    use CredentialValidator;
    use PasswordChanger;

    // Helper Functions
    private function logoutUser(User $user, bool $fromAllDevices = false, bool $exceptCurrent = false): void
    {
        if ($fromAllDevices && !$exceptCurrent) {
            // Delete all tokens
            $user->tokens()->delete();
        } elseif ($fromAllDevices && $exceptCurrent) {
            // Delete all tokens except the current one
            $currentTokenId = $user->currentAccessToken()->id;
            $user->tokens()->where('id', '!=', $currentTokenId)->delete();
        } else {
            // Delete only the current token
            $user->currentAccessToken()->delete();
        }
    }

    // Main Functions
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = $request->user();

        if (!$this->validateCredentials($user, $request->password)) {
            return $this->responder->send('The password is incorrect.', status: ResponseStatus::UNPROCESSABLE->value);
        }

        // Logging the user out
        $this->logoutUser($user, true);

        // Notify the user that the account is deleted
        $user->notify(new AccountDeleted());

        // Deleting the user
        $user->delete();

        return $this->responder->send(
            'Account deleted successfully.',
        );
    }

    public function logout(Request $request)
    {
        $this->logoutUser($request->user());
        return $this->responder->send('You have been logged out successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            ...PasswordRules::strongPassword(),
        ]);

        $user = $request->user();

        if (!$this->validateCredentials($user, $request->current_password))
        {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $this->changeUserPassword($user, $request->new_password);

        // Log the user out from all teh device except the current one
        $this->logoutUser($user, true, true);

        return $this->responder->send('Password changed successfully.');
    }
}
