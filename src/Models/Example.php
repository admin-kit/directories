<?php

namespace AdminKit\Directories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Example extends Directory
{
    protected $table = 'directories';

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('example', function (Builder $builder) {
            $builder->where('type', 'example');
        });
    }
}
