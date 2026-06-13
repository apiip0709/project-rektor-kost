<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            // id_kost sebagai primary key berformat string
            $table->string('id_kost')->primary();

            // 🌟 Mengubah owner_id menjadi nullable agar bisa dikosongkan
            $table->string('owner_id')->nullable();
            $table->foreign('owner_id')->references('owner_id')->on('owners')->onDelete('cascade');

            $table->string('name_kost');
            $table->enum('klasifikasi', ['putra', 'putri', 'campur']);
            $table->enum('city', ['makassar', 'gowa']);
            $table->enum('campus', ['unhas', 'pnup', 'unitama', 'undipa', 'cokro']);
            $table->text('address');
            $table->longText('description');

            // 🌟 MULTI-DATA (Disimpan dalam format JSON)
            $table->json('img_kost')->nullable();
            $table->json('facility')->nullable();

            // 🌟 TITIK KOORDINAT MAPS
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
