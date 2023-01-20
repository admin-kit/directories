<?php

namespace AdminKit\Directories;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AdminKit\Directories\Commands\DirectoriesCommand;

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
            ->hasMigration('create_directories_table')
            ->hasCommand(DirectoriesCommand::class);
    }
}
