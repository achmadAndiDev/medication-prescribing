<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('log_tables')->insert([
            [
                'name' => 'patients',
                'alias' => 'Patients',
                'is_active' => true,
            ],
            [
                'name' => 'examinations',
                'alias' => 'Examinations',
                'is_active' => true,
            ],
            [
                'name' => 'doctors',
                'alias' => 'Doctors',
                'is_active' => true,
            ],
            [
                'name' => 'persons',
                'alias' => 'Persons',
                'is_active' => true,
            ],
            [
                'name' => 'users',
                'alias' => 'Users',
                'is_active' => true,
            ],
            [
                'name' => 'prescriptions',
                'alias' => 'Prescriptions',
                'is_active' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
