<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\LoginTokenGenerator;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Notifications\ApiVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use LoginTokenGenerator;

    private function createUser(string $email, string $password): User
    {
        return User::create([
            'email' => strtolower($email),
            'password' => Hash::make($password),
        ]);
    }

    public function store(UserRegistrationRequest $request): JsonResponse
    {
        // Get validated email and password out
        $validated = $request->safe()->only(['email', 'password']);

        // Create a user with the given credentials
        $user = $this->createUser($validated['email'], $validated['password']);

        // Create token to log the user in
        $token = $this->generateUserToken($user);

        // Send notification for email verification
        $user->notify(new ApiVerifyEmail($request->redirect_url));

        // Send response telling that the registration was successful
        return $this->responder->send(
            message: 'Registration Successful',
            payload: [
                'data' => [
                    'email' => $user->email,
                    'token' => $token,
                ]
            ],
            status: ResponseStatus::CREATED->value,
        );
    }
}
