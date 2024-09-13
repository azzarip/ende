<?php

use function Pest\Laravel\get;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

beforeEach(function () {
    Route::middleware(['web', Locale::class])->get('/test', function () {
        return response('Middleware Test');
    });
});
it('gets locale from session', function () {
    Session::put('locale', 'de');
    get('/test');

    expect(app()->getLocale())->toBe('de');
});

it('gets locale from cookie if no session', function () {

    $this->withUnencryptedCookie('locale', 'de')->get('/test');

    expect(Session::get('locale'))->toBe('de');
    expect(app()->getLocale())->toBe('de');
});

it('gets locale from browser if no cookie', function () {
    $this->withHeader('Accept-Language', 'de')->get('/test');

    expect(Session::get('locale'))->toBe('de');
    expect(Cookie::hasQueued('locale'))->toBe(true);
    expect(app()->getLocale())->toBe('de');
});

it('defaults to english if no locale is set', function () {
$this->get('/test');

expect(Session::get('locale'))->toBe('en');
expect(Cookie::hasQueued('locale'))->toBe(true);
expect(app()->getLocale())->toBe('en');
});
