<?php

namespace AdminKit\Directories\Models;

use AdminKit\Core\Models\Traits\CyrillicChars;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Spatie\Translatable\HasTranslations;

/**
 * Admin Directory Model
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Directory extends Model
{
    use CyrillicChars, HasTranslations, Filterable;

    protected $fillable = [
        'parent_id',
        'type',
        'name',
        'properties',
    ];

    protected $translatable = [
        'name',
    ];

    protected $allowedFilters = [
        'type',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'type',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function getProperty(string $key)
    {
        return $this->properties[$key] ?? null;
    }
}
