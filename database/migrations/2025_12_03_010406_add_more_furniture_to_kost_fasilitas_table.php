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
            $table->boolean('kasur')->default(false);
            $table->boolean('bantal')->default(false);
            $table->boolean('lemari')->default(false);
            $table->boolean('guling')->default(false);
            $table->boolean('kursi')->default(false);
            $table->boolean('meja')->default(false);
            $table->boolean('meja_rias')->default(false);
            $table->boolean('mesin_cuci')->default(false);
            $table->boolean('r_jemur')->default(false);
            $table->boolean('dapur')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('kost_fasilitas', function (Blueprint $table) {
            $table->dropColumn([
                'kasur',
                'bantal',
                'lemari',
                'guling',
                'kursi',
                'meja',
                'meja_rias',
                'mesin_cuci',
                'r_jemur',
                'dapur',
            ]);
        });
    }
};
