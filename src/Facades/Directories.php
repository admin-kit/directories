<?php

namespace AdminKit\Directories\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AdminKit\Directories\Directories
 */
class Directories extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AdminKit\Directories\Directories::class;
    }
}
