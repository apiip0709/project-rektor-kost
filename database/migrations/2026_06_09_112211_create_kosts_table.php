<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            // id_kost sebagai primary key berformat string (bukan id integer biasa)
            $table->string('id_kost')->primary();

            // Menghubungkan kost ke tabel owners (menggunakan string owner_id, beralih dari users)
            $table->string('owner_id');
            $table->foreign('owner_id')->references('owner_id')->on('owners')->onDelete('cascade');

            $table->string('name_kost');
            $table->enum('city', ['Makassar', 'Gowa']);
            $table->enum('campus', ['Unhas', 'PNUP', 'Unitama', 'Undipa', 'Cokro']);
            $table->text('address');
            $table->longText('description');

            // 🌟 MULTI-DATA (Disimpan dalam format JSON)
            $table->json('img_kost')->nullable(); // Menampung array nama/path gambar
            $table->json('facility')->nullable(); // Menampung array fasilitas ['wifi', 'AC']

            // 🌟 TITIK KOORDINAT MAPS (Presisi tinggi untuk Latitude & Longitude)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->enum('status_langganan', ['premium', 'gold', 'silver'])->default('silver');
            $table->enum('status_kemitraan', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
