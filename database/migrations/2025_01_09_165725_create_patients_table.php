<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code')->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']); 
            $table->date('date_of_birth');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
