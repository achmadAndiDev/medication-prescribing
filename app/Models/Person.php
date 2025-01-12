<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ActivityLog;

class Person extends Model
{
    use HasFactory, ActivityLog, SoftDeletes;
    
    protected $table = 'persons';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'nik',
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
