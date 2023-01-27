<?php

use AdminKit\Directories\Directories;
use AdminKit\Directories\Screens\DirectoryEditScreen;
use AdminKit\Directories\Screens\DirectoryListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::prefix(config('admin-kit.packages.directories.prefix'))->group(function () {
    Route::screen('/', DirectoryListScreen::class)
        ->name(Directories::ROUTE_LIST)
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__(Directories::NAME_PLURAL), route(Directories::ROUTE_LIST));
        });
    Route::screen('/create', DirectoryEditScreen::class)
        ->name(Directories::ROUTE_CREATE)
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent(Directories::ROUTE_LIST)
                ->push(__(Directories::NAME), route(Directories::ROUTE_CREATE));
        });
    Route::screen('/{item}/edit', DirectoryEditScreen::class)
        ->name(Directories::ROUTE_EDIT)
        ->breadcrumbs(function (Trail $trail, $item) {
            return $trail
                ->parent(Directories::ROUTE_LIST)
                ->push(__(Directories::NAME), route(Directories::ROUTE_EDIT, $item));
        });
});
