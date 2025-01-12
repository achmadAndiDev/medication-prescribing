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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('record_id');
            $table->char('activity', 1);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestampTz('created_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('table_id')->references('id')->on('log_tables');
            $table->index('table_id');
            $table->index('record_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
