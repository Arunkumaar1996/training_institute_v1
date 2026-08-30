<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please sign in to continue.');
        }

        $user = auth()->user();

        if (!$user->isActive()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact administration.');
        }

        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        if (!$user->hasRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized role access.'], 403);
            }
            abort(403, 'You do not have the required role to access this page.');
        }

        return $next($request);
    }
}
