<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Ubah enum di bookings menjadi string agar lebih aman untuk ditambah/diubah
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
            $table->string('status_pembayaran')->default('pending')->change();
        });

        // 2. Ubah enum di transaksis menjadi string
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('status_pembayaran')->default('pending')->change();
            $table->string('status')->default('aktif')->change();
        });

        // 3. Tambah type_kamar di kosts
        Schema::table('kosts', function (Blueprint $table) {
            $table->string('type_kamar')->nullable()->after('jumlah_kamar');
        });
    }

    public function down()
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('type_kamar');
        });

        // Down untuk Enum tidak dikembalikan karena MySQL bisa error jika data sudah ada yang pakai string yang bukan anggota ENUM
    }
};
