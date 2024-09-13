<?php

namespace Azzarip\Ende;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EndeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('ende')
            ->hasConfigFile();
    }

    public function bootingPackage()
    {
        EncryptCookies::except('locale');

        $router = app(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware('locale', \Azzarip\Ende\Http\Middleware\Locale::class);

    }
}
