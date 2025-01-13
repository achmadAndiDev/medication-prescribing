<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PaginationScope;
use App\Models\Traits\ModelValidation;
use App\Models\Traits\ActivityLog;

class Prescription extends Model
{
    use HasFactory, ActivityLog, SoftDeletes, PaginationScope, ModelValidation;

    protected $fillable = [
        'examination_id',
        'notes',
        'is_paid',
        'prescription_date'
    ];

    protected $casts = [
        'prescription_date' => 'datetime',
    ];

    const STATUS_MENUNGGU = 1;
    const STATUS_DALAM_PROSES = 2;

    const RULES = [
        'examination_id' => [
            'required' => true,
            'control' => 'select-search-ajax',
            'url' => 'search-options/patients',
            'value_field' => 'patient_name',
            'col' => '6'
        ],
    ];

    const SORT_DEFAULT = 'prescription_date';

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
