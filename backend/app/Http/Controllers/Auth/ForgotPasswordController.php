<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FindUserByEmail;
use App\Http\Controllers\Traits\PasswordChanger;
use App\Http\Requests\ResetPasswordRequest;
use App\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    use FindUserByEmail;
    use PasswordChanger;

    private function generateToken(): string
    {
        return Str::random(64);
    }

    private function findRecord(string $token, string $email)
    {
        return DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $email)
            ->first();
    }

    private function storeTokenIntoDB(string $token, string $email): void
    {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }

    private function deleteResetTokenFromDB(string $email): void
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = $this->getUserWithEmail($request->email);

        if ($user) {
            // Generating custom token
            $token = $this->generateToken();

            // Inserting or Updating if the token exists into the DB
            $this->storeTokenIntoDB($token, $user->email);

            // Send the token
            $user->notify(new ResetPassword($token));
        }


        return $this->responder->send(
                'Reset Link is sent to your email',
            );
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $record = $this->findRecord($request->token, $request->email);

        if (! $record) {
            return $this->responder->send(
                'Failed to Reset Your Password',
                ['errors' => 'Invalid email or token.'],
                ResponseStatus::UNAUTHORIZED->value,
            );
        }

        // Get the user
        $user = $this->getUserWithEmail($request->email);

        // Change the user password
        $this->changeUserPassword($user, $request->password);

        $this->deleteResetTokenFromDB($request->email);

        return $this->responder->send(
            'Password changed successfully',
        );
    }
}
