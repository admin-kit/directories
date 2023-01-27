<?php

namespace AdminKit\Directories\Models;

use AdminKit\Core\Models\Traits\CyrillicChars;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class DirectoryModel extends Model
{
    use CyrillicChars, HasTranslations;

    protected $table = 'directories';

    protected $fillable = [
        'parent_id',
        'type',
        'name',
    ];

    protected $translatable = [
        'name',
    ];

    public static function boot()
    {
        $type = static::getClassShortName();

        parent::boot();
        static::addGlobalScope($type, function (Builder $builder) use ($type) {
            $builder->where('type', $type);
        });
        static::creating(fn ($model) => $model->type = $type);
    }

    public static function getClassShortName(): string
    {
        $fullName = explode('\\', static::class);

        return end($fullName);
    }
}
