<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PaginationScope;
use App\Models\Traits\ModelValidation;

class Doctor extends Model
{
    use HasFactory, SoftDeletes, PaginationScope, ModelValidation;

    protected $fillable = [
        'person_id',
        'specialty',
        'bio',
    ];

    const RULES = [
        'person_id' => 'required|exists:persons,id',
        'specialty' => 'nullable|string|max:255',
        'bio'       => 'nullable|string',
    ];

    /**
     * Define the relationship to the Person model.
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
