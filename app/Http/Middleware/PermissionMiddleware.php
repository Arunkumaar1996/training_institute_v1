<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please sign in to continue.');
        }

        $user = auth()->user();

        if (!$user->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Forbidden: Missing permission [{$permission}]."], 403);
            }
            abort(403, "You do not have permission [{$permission}] to perform this action.");
        }

        return $next($request);
    }
}
