<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);
            $table->dropColumn(['patient_id', 'doctor_id']);

            $table->unsignedBigInteger('examination_id')->after('id');
            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('prescriptions', function (Blueprint $table) {
        //     $table->dropForeign(['examination_id']);
        //     $table->dropColumn('examination_id');

        //     $table->unsignedBigInteger('patient_id')->after('id');
        //     $table->unsignedBigInteger('doctor_id')->after('patient_id');

        //     $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        //     $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        // });
    }
};
