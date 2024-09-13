<?php

use function Pest\Laravel\get;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

beforeEach(function () {
    Route::get('/test', function () {
        return response();
    })->middleware(['web', 'locale:de']);
});
it('sets locale', function () {
    get('/test');
    expect(value: app()->getLocale())->toBe('de');
});

it('saves session and cookie', function () {
    get('/test');

    expect(Session::get('locale'))->toBe('de');
    expect(Cookie::hasQueued('locale'))->toBe(true);
    expect(value: app()->getLocale())->toBe('de');
});
