<?php

namespace Azzarip\Ende;

use Spatie\LaravelPackageTools\Package;
use Illuminate\Cookie\Middleware\EncryptCookies;
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
    }
}
