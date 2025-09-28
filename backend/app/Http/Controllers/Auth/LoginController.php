<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CredentialValidator;
use App\Http\Controllers\Traits\FindUserByEmail;
use App\Http\Controllers\Traits\LoginTokenGenerator;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    use FindUserByEmail;
    use LoginTokenGenerator;
    use CredentialValidator;

    public function store(UserLoginRequest $request): JsonResponse
    {
        // Getting out and normalizing the input dat from the request
        $email = strtolower($request->input('email'));
        $password = $request->input('password');

        // Get the user with the given email
        $user = $this->getUserWithEmail($email);

        // Validate the credentials
        if (!$this->validateCredentials($user, $password)) {
            // Show that the credentials are invalid
            return $this->responder->send(message: 'Invalid Credentials', status: ResponseStatus::UNAUTHORIZED->value);
        }

        // Create a token for the current user
        $token = $this->generateUserToken($user);

        // Send response to show the user is successfully logged in
        return $this->responder->send(
            message: 'Login Successful',
            payload: [
                'data' => [
                    'token' => $token
                ]
            ]);
    }
}
