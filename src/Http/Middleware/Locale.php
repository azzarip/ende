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
    public function handle(Request $request, Closure $next, $locale = null): Response
    {
        if(is_null($locale)) {
            $locale = $this->getLocale();
        } else {
            $this->forceLocale($locale);
        }

        app()->setLocale($locale);

        return $next($request);
    }

    protected function getLocale() {
        if (! Session::has('locale')) {

            if (! Cookie::has('locale')) {
                $locale = $this->getBrowserLocale();
                Session::put('locale', $locale);
                Cookie::queue('locale', $locale, 525600, null, null, false, false);
            } else {
                $locale = Cookie::get(key: 'locale');
                Session::put('locale', $locale);
            }

            return $locale;
        }

        return Session::get('locale');
    }
    protected function getBrowserLocale()
    {
        $langs = explode(',', request()->header('Accept-Language'));
        foreach ($langs as $lang) {
            $xx = substr($lang, 0, 2);
            if (in_array($xx, ['de', 'en'])) {

                return $xx;
            }
        }

        return 'en'; // default to English if no language is found;
    }

    protected function forceLocale($locale) {
        if(Session::get('locale') != $locale) {
            Session::put('locale', $locale);
            Cookie::queue('locale', $locale, 525600, null, null, false, false);
        }
    }
}
