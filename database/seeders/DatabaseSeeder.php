<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan Foreign Key untuk proses Truncate (Kosongkan Tabel)
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // ─── 1. AKUN SUPERADMIN (Data Lama Anda) ───
        User::create([
            'name'            => 'Superadmin A5',
            'email'           => 'projectrektor@gmail.com',
            'password'        => 'rektoratgagal',
            'register_method' => 'google',
            'role'            => 'superadmin',
        ]);

        // ─── 2. TAMBAHAN: AKUN PENGGUNA / PENCARI KOST ───
        User::create([
            'name'            => 'Apiip',
            'email'           => 'afifalhaq777@gmail.com',
            'password'        => 'apiip777',
            'register_method' => 'google',
            'role'            => 'pengguna',
        ]);
    }
}
