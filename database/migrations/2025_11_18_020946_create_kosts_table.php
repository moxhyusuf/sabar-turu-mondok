<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kost');
            $table->string('nama_pemilik');
            $table->string('nik_pemilik')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('contact_person')->nullable();
            $table->enum('jenis_kost', ['putra', 'putri', 'campuran', 'keluarga', 'harian'])->default('putri');
            $table->integer('jumlah_kamar')->default(0);
            $table->enum('lokasi_pemondokan', ['satu_atap', 'terpisah'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
