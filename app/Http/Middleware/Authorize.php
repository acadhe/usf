<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if (Auth::guest()){
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('auth.login'));
            }
        } else {
            if (!$request->user()->minRole($role)){
                return response('Forbidden access',403);
            }
        }
        return $next($request);
    }
}
