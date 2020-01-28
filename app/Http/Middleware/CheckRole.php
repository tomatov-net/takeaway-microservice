<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param mixed ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        /** @var /App/User $user */
        $user = auth()->user();
        $role = $user->role;
        if (!$role || !in_array($user->role->slug, $roles)) {
            return response()->json(['errors' => [
                'role' => [
                    'Forbidden',
                ]
            ],], 403);
        }

        return $next($request);
    }
}
