<?php

namespace Melogail\TelrLaravel;

use Melogail\TelrLaravel\Commands\TelrLaravelCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__.'/../config/telr-laravel.php' => config_path('telr-laravel.php'),
                ], 'config'
            );
        }
    }
}
