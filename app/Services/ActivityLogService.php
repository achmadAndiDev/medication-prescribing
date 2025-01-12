<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Log\Activity;
use App\Models\Log\TableCache;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    const ACTIVITY_INSERT = 'I';
    const ACTIVITY_UPDATE = 'U';
    const ACTIVITY_DELETE = 'D';
    const ACTIVITY_FORCE_DELETE = 'F';
    const ACTIVITY_RESTORE = 'R';

    /**
     * Log aktivitas data.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $activity
     */
    public static function log(Model $model, string $activity)
    {
        // hanya tabel yang dibutuhkan
        $table = $model->getTable();
        $logTable = TableCache::find($table);

        if (empty($logTable)) {
            return;
        }

        $old = $model->getOriginal();
        $new = $model->toArray();

        Activity::create([
            'table_id' => $logTable['id'],
            'record_id' => $new['id'] ?? $old['id'],
            'activity' => $activity,
            'old_values' => $old ? json_encode($old) : null,
            'new_values' => $new ? json_encode($new) : null,
            'created_by' => Auth::check() ? Auth::user()->id : null
        ]);
    }
}
