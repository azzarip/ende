<?php

namespace Azzarip\Ende\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Session::has('locale')) {

            if (! Cookie::has('locale')) {
                $locale = $this->getBrowserLocale($request);
            } else {
                Session::put('locale', Cookie::get('locale'));
            }
        }
        $locale = Session::get('locale');
        app()->setLocale($locale);

        return $next($request);
    }

    protected function getBrowserLocale(Request $request)
    {
        $langs = explode(',', $request->header('Accept-Language'));
        foreach ($langs as $lang) {
            $xx = substr($lang, 0, 2);
            if (in_array($xx, ['de', 'en'])) {
                Session::put('locale', $xx);
                Cookie::queue('locale', $xx, 525600, null, null, false, false);

                return;
            }
        }
    }
}
