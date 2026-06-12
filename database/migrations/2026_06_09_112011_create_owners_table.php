<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->string('owner_id')->primary();

            // 🌟 UBAH KODE FOREIGN KEY MENJADI SEPERTI INI:
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            // Data personal yang digeser ke tabel owner
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('pob')->nullable(); // Place of Birth (Tempat Lahir)
            $table->date('dob')->nullable();   // Date of Birth (Tanggal Lahir)

            $table->enum('akun', ['aktif', 'menunggu', 'nonaktif'])->default('menunggu');
            $table->enum('status', ['berlangganan','tidak','trial'])->default('tidak');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
