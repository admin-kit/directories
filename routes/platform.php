<?php

use AdminKit\Directories\Screens\DirectoryEditScreen;
use AdminKit\Directories\Screens\DirectoryListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::group(['prefix' => config('admin-kit.packages.directories.prefix')], function () {
    $routeList = config('admin-kit.packages.directories.route_list');
    $routeEdit = config('admin-kit.packages.directories.route_edit');
    $routeCreate = config('admin-kit.packages.directories.route_create');

    Route::screen('/', DirectoryListScreen::class)
        ->name($routeList)
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Directories'), route($routeList))
        );
    Route::screen('/create', DirectoryEditScreen::class)
        ->name($routeCreate)
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent($routeList)
            ->push(__('Directory'), route($routeCreate))
        );
    Route::screen('/{item}/edit', DirectoryEditScreen::class)
        ->name($routeEdit)
        ->breadcrumbs(fn (Trail $trail, $item) => $trail
            ->parent($routeList)
            ->push(__('Directory'), route($routeEdit, $item))
        );
});
