<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PaginationScope;
use App\Models\Traits\ModelValidation;
use App\Models\Traits\ActivityLog;

class Examination extends Model
{
    use HasFactory, ActivityLog, SoftDeletes, PaginationScope, ModelValidation;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'examination_time',
        'height',
        'weight',
        'systole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'body_temperature',
        'notes',
        'external_documents',
        'status'
    ];

    protected $casts = [
        'external_documents' => 'array',
        'examination_time' => 'datetime',
    ];

    const STATUS_MENUNGGU = 1;
    const STATUS_DALAM_PROSES = 2;
    const STATUS_SELESAI = 3;
    const STATUS_DIBATALKAN = 4;

    const STATUSES = [
        self::STATUS_MENUNGGU => 'Menunggu',
        self::STATUS_DALAM_PROSES => 'Dalam Proses',
        self::STATUS_SELESAI => 'Selesai',
        self::STATUS_DIBATALKAN => 'Dibatalkan',
    ];

    const RULES = [
        'patient_id' => [
            'required' => true,
            'control' => 'select-search-ajax',
            'url' => 'search-options/patients',
            'value_field' => 'patient_name',
            'col' => '6'
        ],
        'doctor_id' => [
            'required' => true,
            'control' => 'select-search-ajax',
            'url' => 'search-options/doctors',
            'value_field' => 'doctor_name',
            'col' => '6'
        ],
        'status' => [
            'required' => true,
            'control' => 'select-option',
            'in' => self::STATUSES,
            'col' => '6'
        ],
        'examination_time' => [
            'required' => true,
            'control' => 'datetime',
            'col' => '6'
        ],
        'height' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'weight' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'systole' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'diastole' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'heart_rate' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'respiration_rate' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'body_temperature' => [
            'nullable' => true,
            'control' => 'number',
            'col' => '6'
        ],
        'notes' => [
            'nullable' => true,
            'control' => 'textarea',
            'maxlength' => 1000,
        ],
        'external_documents' => [
            'nullable' => true,
            'array' => true,
        ],
    ];

    const FILTERABLE = ['patient_id', 'doctor_id', 'examination_time'];

    const SORT_DEFAULT = 'examination_time';

    // Relationships

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
