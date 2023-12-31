<?php

namespace EncoreDigitalGroup\DynamicData;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

// @codeCoverageIgnoreStart
class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('dynamicdata')
            ->hasConfigFile();
    }

    public function boot(): void
    {
        $this->commands([
            //
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/encoredigital.php', 'encoredigital'
        );
    }
}
// @codeCoverageIgnoreEnd
