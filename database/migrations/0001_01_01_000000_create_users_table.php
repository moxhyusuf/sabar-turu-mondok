<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->text('alamat')->nullable();
            $table->enum('role', ['pemilik_dekost', 'admin', 'perpajakan', 'perizinan'])->default('pemilik_dekost');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('bukti_ktp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
