<?php

namespace AdminKit\Directories;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::group(__('Admin-Kit'))
            ->addPermission('admin-kit.directories', __('Directories'));

        $dashboard->registerPermissions($permissions);
    }
}
