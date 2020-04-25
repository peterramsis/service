<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class UserInterface
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check() && Sentinel::getUser()->hasAnyAccess(['user.*'])) {
            return redirect()->route('home')->with('success', 'login');
        }

        return redirect()->back()->with('error', 'Invalid permission');
    }
}
