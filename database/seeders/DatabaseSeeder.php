<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan Foreign Key agar tidak error saat menghapus data yang saling berelasi
        Schema::disableForeignKeyConstraints();

        // 2. Pilih tabel apa saja yang ingin Anda bersihkan datanya secara total
        DB::table('users')->truncate();
        // DB::table('nama_tabel_lain')->truncate(); // Tambahkan tabel lain di sini jika ada

        // 3. Hidupkan kembali pengecekan Foreign Key
        Schema::enableForeignKeyConstraints();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
