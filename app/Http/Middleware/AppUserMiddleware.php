<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AppUserMiddleware
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth('web')->check()){
            auth('web')->logout();
            return redirect()->route('appUser.login.view');
        }

        if(auth('appuser')->check()) {
            return $next($request);
        }

        return redirect()->route('appUser.login.view');
    }
}
