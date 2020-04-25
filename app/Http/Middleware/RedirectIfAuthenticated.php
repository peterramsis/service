<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Sentinel::check() && Sentinel::hasAnyAccess(['admin.*', 'editor.*', 'report.*', 'operations.*','admin_report.*','User.*'])) {
            return redirect()->route('home')->with('success', 'You are already login in');
        } elseif (Sentinel::check() && Sentinel::hasAccess(['User.*'])) {
            return redirect()->route('/')->with('success', 'You are already login in');
        }

        return $next($request);
    }
}
