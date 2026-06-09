<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            // id_room sebagai primary key berformat string (Contoh: 0001-01)
            $table->string('id_room')->primary();
            
            // Relasi ke tabel kosts (Foreign key menggunakan string id_kost)
            $table->string('kost_id');
            $table->foreign('kost_id')->references('id_kost')->on('kosts')->onDelete('cascade');
            
            $table->string('no_room');
            $table->string('size_room');
            $table->integer('floor_room')->default(1);
            $table->enum('status', ['tersedia', 'penuh'])->default('tersedia');
            $table->integer('price');
            $table->text('description')->nullable();
            
            // 🌟 MULTI-IMAGE (Disimpan dalam format JSON)
            $table->json('img_room')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
