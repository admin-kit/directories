<?php

namespace AdminKit\Directories;

use AdminKit\Directories\Commands\ModelCommand;
use Illuminate\Support\Facades\Route;
use Orchid\Support\Facades\Dashboard;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DirectoriesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('directories')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(ModelCommand::class)
            ->hasMigration('create_directories_table');
    }

    public function packageRegistered()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/directories.php', 'admin-kit.packages.directories');
    }

    public function packageBooted()
    {
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->middleware(config('platform.middleware.private'))
            ->group(__DIR__.'/../routes/platform.php');
    }
}
