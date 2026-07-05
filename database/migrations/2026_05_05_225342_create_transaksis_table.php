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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->onDelete('cascade');

            $table->foreignId('kost_id')
                ->constrained('kosts')
                ->onDelete('cascade');

            // Periode sewa
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');

            // Pembayaran
            $table->enum('status_pembayaran', [
                'pending',
                'menunggu_verifikasi',
                'lunas',
                'ditolak'
            ])->default('pending');

            // Bukti pembayaran (upload gambar)
            $table->string('bukti_pembayaran')->nullable();

            // Status sewa
            $table->enum('status', [
                'aktif',
                'selesai'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
