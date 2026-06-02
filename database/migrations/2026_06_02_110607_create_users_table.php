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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            
            // Kolom Login & Registrasi
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            
            // Kolom Tracking SSO
            $table->string('register_method')->nullable(); // 'google' atau 'whatsapp'
            
            // Default diatur ke 'pencari' sesuai dengan desain form Anda "Daftar Sebagai Pengguna"
            $table->enum('role', ['superadmin','pengguna', 'pemilik','admin'])->default('pengguna');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
