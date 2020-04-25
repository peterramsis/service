<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check() && Sentinel::getUser()->hasAnyAccess(['admin.*','User.*'])) {
            return $next($request);
        }else{
            return redirect()->route("home");
        }

        return redirect()->back()->with('error', 'Invalid permission');
    }
}
