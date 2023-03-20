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
        // Publishing config file
        if ($this->app->runningInConsole()) {
            // Exporting config file
            $this->publishes(
                [
                    __DIR__.'/../config/telr-laravel.php' => config_path('telr-laravel.php'),
                ], 'config'
            );

            // Exporting migration files
            $this->publishes(
                [
                    __DIR__ . '/../database/migrations/create_telr_transactions_table.php.stub' => database_path('migrations/' . date('Y_m_dHis', time()). 'create_telr_transactions_table'),
                    // Add more migrations here.
                ], 'migrations'
            );
        }

        // Auto publishing migration file
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
