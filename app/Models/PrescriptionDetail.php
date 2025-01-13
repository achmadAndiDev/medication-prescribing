<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PaginationScope;
use App\Models\Traits\ModelValidation;
use App\Models\Traits\ActivityLog;

class PrescriptionDetail extends Model
{
    use HasFactory, ActivityLog, SoftDeletes, PaginationScope, ModelValidation;

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'medicine_name',
        'dosage',
        'frequency',
        'duration',
        'quantity',
        'unit_price',
        'price_start_date',
        'price_end_date'
    ];

    const RULES = [];

    const SORT_DEFAULT = 'medicine_name';

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}