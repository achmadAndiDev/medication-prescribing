<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PaginationScope;
use App\Models\Traits\ModelValidation;

class Patient extends Model
{
    use HasFactory, SoftDeletes, PaginationScope, ModelValidation;

    protected $fillable = [
        'patient_code',
        'name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'blood_type',
    ];

    const GENDERS = [
        "L" => "Laki-Laki",
        "P" => "Perempuan",
    ];

    const BLODS = [null => 'Belum Tahu', 'A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'];

    const RULES = [
        'patient_code' => [
            'required' => true,
            'string' => true,
            'unique' => 'patients',
            'maxlength' => 255,
        ],
        'name' => [
            'required' => true,
            'string' => true,
            'maxlength' => 255,
        ],
        'gender' => [
            'required' => true,
            'control' => 'radio',
            'in' => self::GENDERS,
        ],
        'date_of_birth' => [
            'required' => true,
            'control' => 'date',
        ],
        'phone' => [
            'required' => true,
            'string' => true,
            'maxlength' => 20,
        ],
        'email' => [
            'nullable' => true,
            'email' => true,
            'maxlength' => 255,
        ],
        'address' => [
            'control' => 'textarea',
            'nullable' => true,
            'string' => true,
            'maxlength' => 500,
        ],
        'blood_type' => [
            'nullable' => true,
            'control' => 'radio',
            'in' => self::BLODS,
        ],
    ];
    
    const FILTERABLE = ['patient_code', 'name', 'phone', 'email'];

    const SORT_DEFAULT = 'name';
}
