<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            // owner_id sebagai primary key berupa string (Contoh: OW-001)
            $table->string('owner_id')->primary();

            // ForeignKey yang menghubungkan ke kolom 'id' di tabel 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data personal yang digeser ke tabel owner
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('pob')->nullable(); // Place of Birth (Tempat Lahir)
            $table->date('dob')->nullable();   // Date of Birth (Tanggal Lahir)

            // Status tingkatan/level member owner
            $table->enum('status', ['premium', 'gold', 'silver'])->default('silver');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
