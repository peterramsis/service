<?php

namespace App\Http\Middleware;

use Closure;



class localization
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
        if(\Session::has("lan")){
            \App::setLocale(\Session::get("lan"));
        }
        return $next($request);
    }
}
