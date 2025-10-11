<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\ResponseStatus;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user?->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Admins only.',
                'user' => $user,
            ], ResponseStatus::FORBIDDEN->value);
        }

        return $next($request);
    }
}
