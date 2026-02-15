<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoleEnum;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        $userRole = Auth::user()->role;

        foreach ($roles as $role) {
            if ($userRole === UserRoleEnum::tryFrom($role)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
