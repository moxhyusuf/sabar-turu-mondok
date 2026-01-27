<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tentang_kami', function (Blueprint $table) {
            $table->id();
            $table->longText('tentang_kami'); // isi teks panjang tentang kami
            $table->string('img')->nullable(); // path/filename gambar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tentang_kami');
    }
};
