<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PaginationScope;

class Patient extends Model
{
    use HasFactory, SoftDeletes, PaginationScope;

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

    const RULES = [
        'patient_code'  => 'required|string|unique:patients|max:255',
        'name'          => 'required|string|max:255',
        'gender'        => 'required|in:L,P',
        'date_of_birth' => 'required|date',
        'phone'         => 'required|string|max:20',
        'email'         => 'nullable|email|max:255',
        'address'       => 'nullable|string|max:500',
        'blood_type'    => 'nullable|in:A,B,AB,O',
    ];

    const SORT_DEFAULT = 'name';
}
