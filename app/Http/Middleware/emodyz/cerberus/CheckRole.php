<?php

namespace App\Http\Middleware\emodyz\cerberus;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->getAttribute('role') !== $role) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
