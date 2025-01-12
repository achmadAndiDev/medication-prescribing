<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_activities';

    protected $fillable = [
        'table_id',
        'record_id',
        'activity',
        'old_values',
        'new_values',
        'created_by'
    ];

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;
}
