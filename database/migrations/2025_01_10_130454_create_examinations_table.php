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
        Schema::create('examinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->dateTime('examination_time');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->smallInteger('systole')->nullable();
            $table->smallInteger('diastole')->nullable();
            $table->smallInteger('heart_rate')->nullable();
            $table->smallInteger('respiration_rate')->nullable();
            $table->float('body_temperature')->nullable();
            $table->text('notes')->nullable();
            $table->json('external_documents')->nullable();
            $table->softDeletes();  
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
