<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alur_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('img'); // untuk menyimpan path/nama file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alur_pendaftarans');
    }
};
