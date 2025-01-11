<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'persons';

    protected $fillable = [
        'user_id',
        'address',
        'phone',
    ];

    const RULES = [
        'user_id' => 'required|exists:users,id',
        'address' => 'nullable|string|max:500',
        'phone'   => 'nullable|string|max:20',
    ];

    /**
     * Define the relationship to the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
