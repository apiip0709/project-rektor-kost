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

            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();

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
