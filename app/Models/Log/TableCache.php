<?php

namespace App\Models\Log;

use App\Models\Log\Table;
use App\Models\Traits\CacheModel;

class TableCache extends CacheModel
{
    const KEY = 'log';

    /**
     * Get a record from database.
     */
    public static function findDefault($id)
    {
        return Table::where('name', $id)->first(['id'])?->toArray();
    }
}
