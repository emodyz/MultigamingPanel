<?php

namespace App\Http\Middleware\emodyz\cerberus;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CheckAuthorization
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $ability
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next, string $ability)
    {
        if (! $request->user()->can($ability)) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
