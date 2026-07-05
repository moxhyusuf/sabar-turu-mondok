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
        Schema::table('bookings', function (Blueprint $table) {
            // Drop user_id constraints and column if it exists
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Add penyewa_id and kode_booking
            $table->foreignId('penyewa_id')->after('id')->nullable()->constrained('penyewas')->onDelete('cascade');
            $table->string('kode_booking')->unique()->after('penyewa_id');
            
            // Note: modifying ENUMs in some databases requires raw queries or DBAL, 
            // but we can also just drop and recreate status if data loss is acceptable, 
            // or add status_pembayaran
            $table->dropColumn('status');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending')->after('tanggal_keluar');
            $table->enum('status_pembayaran', ['pending', 'dibayar'])->default('pending')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['penyewa_id']);
            $table->dropColumn(['penyewa_id', 'kode_booking', 'status_pembayaran']);
            
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->dropColumn('status');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        });
    }
};
