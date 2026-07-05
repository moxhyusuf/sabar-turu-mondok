<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kosts', function (Blueprint $table) {
            // Menambahkan field kamar_tersedia setelah field jumlah_kamar
            // Saya tambahkan default(0) atau bisa menggunakan nullable() sesuai kebutuhan
            $table->integer('kamar_tersedia')->default(0)->after('jumlah_kamar');
        });
    }

    public function down()
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('kamar_tersedia');
        });
    }
};
