<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kost_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->constrained()->onDelete('cascade');
            $table->boolean('lahan_parkir')->default(false);
            $table->boolean('pagar')->default(false);
            $table->boolean('cctv')->default(false);
            $table->boolean('ac_kipas')->default(false);
            $table->boolean('meteran_listrik')->default(false);
            $table->boolean('wifi')->default(false);
            $table->boolean('peraturan_penghuni')->default(false);
            $table->boolean('penjaga')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kost_fasilitas');
    }
};
