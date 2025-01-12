<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1); // 1 = menunggu
        });
    }

    public function down()
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
