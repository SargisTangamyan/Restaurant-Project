<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Enums\ResponseStatus;

class EmailVerificationController extends Controller
{
    public function __invoke($id, $hash, Request $request): JsonResponse
    {
        $user = User::findOrFail($id);

        // Validate hash
        if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
            return $this->responder->send(message: 'Invalid hash', status: ResponseStatus::FORBIDDEN->value);
        }

        // Validate signature (optional, still recommended)
        if (! URL::hasValidSignature($request)) {
            return $this->responder->send(message: 'Invalid or expired link', status: ResponseStatus::FORBIDDEN->value);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->responder->send(message: 'Email already verified');
        }

        $user->markEmailAsVerified();

        return $this->responder->send(message: 'Email verified successfully');
    }
}
