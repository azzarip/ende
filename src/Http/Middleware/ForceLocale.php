<?php

namespace Azzarip\Ende\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ForceLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $locale): Response
    {
        if(Session::get('locale') != $locale) {
            Session::put('locale', $locale);
            Cookie::queue('locale', $locale, 525600, null, null, false, false);
        }
        app()->setLocale($locale);
        return $next($request);
    }

}
