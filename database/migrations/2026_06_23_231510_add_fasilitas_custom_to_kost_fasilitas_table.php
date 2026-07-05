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
        Schema::table('kost_fasilitas', function (Blueprint $table) {
            $table->json('fasilitas_custom')->nullable()->after('dapur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kost_fasilitas', function (Blueprint $table) {
            $table->dropColumn('fasilitas_custom');
        });
    }
};
