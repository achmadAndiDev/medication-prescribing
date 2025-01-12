<?php

namespace App\Models\Traits;

use App\Observers\ActivityObserver;

trait ActivityLog
{
    protected static function bootActivityLog()
    {
        static::observe(ActivityObserver::class);
    }
}
