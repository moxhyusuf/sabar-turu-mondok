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
        Schema::table('kosts', function (Blueprint $table) {
            $table->enum('status_izin', ['berizin', 'belum_berizin'])->default('belum_berizin')->after('kelurahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('status_izin');
        });
    }
};
