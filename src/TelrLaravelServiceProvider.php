<?php

namespace Melogail\TelrLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Melogail\TelrLaravel\Commands\TelrLaravelCommand;

class TelrLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('telr-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_telr_transactions_table')
            ->hasCommand(TelrLaravelCommand::class);
    }
}
