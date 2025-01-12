<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ClearCache;

class Table extends Model
{
    use ClearCache;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_tables';

    /**
     * Clear any related cache
     * 
     * @param mixed $model
     */
    private static function clearCache($model)
    {
        TableCache::destroy($model->getOriginal('name'));
    }
}
