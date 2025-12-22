<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->boolean('is_late_check_in')->default(false)->after('jam_masuk');
            $table->boolean('is_late_check_out')->default(false)->after('jam_keluar');
            $table->integer('late_duration_minutes')->nullable()->after('is_late_check_out');
        });
    }

    public function down()
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn(['is_late_check_in', 'is_late_check_out', 'late_duration_minutes']);
        });
    }
};