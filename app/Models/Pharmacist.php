<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ActivityLog;

class Pharmacist extends Model
{
    use HasFactory, ActivityLog, SoftDeletes;

    protected $fillable = [
        'person_id',
        'license_number',
        'bio',
    ];

    const RULES = [
        'person_id'      => 'required|exists:persons,id',
        'license_number' => 'nullable|string|max:255',
        'bio'            => 'nullable|string',
    ];

    /**
     * Define the relationship to the Person model.
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
