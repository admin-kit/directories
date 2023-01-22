<?php

// config for AdminKit/Directories
return [
    'prefix' => '/directories',

    'models' => [
        'examples' => 'Example',
        'cities' => 'Город',
    ],

    'route_list' => 'platform.directories.list',
    'route_edit' => 'platform.directories.edit',
    'route_create' => 'platform.directories.create',
];
