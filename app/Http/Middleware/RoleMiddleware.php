<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user) return redirect()->route('login');

        if (empty($roles) || in_array($user->role, $roles)) {
            return $next($request);
        }
        return redirect()->route('home')->with('error','You do not have access to this area.');
    }
}
