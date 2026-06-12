<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan Foreign Key untuk proses Truncate (Kosongkan Tabel)
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // ─── 1. AKUN SUPERADMIN ───
        User::create([
            'user_id'         => 'USR-0001',
            'name'            => 'Superadmin A5',
            'email'           => 'projectrektor@gmail.com',
            'password'        => 'rektoratgagal',
            'register_method' => 'google',
            'role'            => 'superadmin',
        ]);

        // ─── 2. TAMBAHAN: AKUN PENGGUNA / PENCARI KOST ───
        User::create([
            'user_id'         => 'USR-0002',
            'name'            => 'Apiip',
            'email'           => 'afifalhaq777@gmail.com',
            'password'        => 'apiip777',
            'register_method' => 'google',
            'role'            => 'pengguna',
        ]);

        User::create([
            'user_id'         => 'USR-0003',
            'name'            => 'A. Afif',
            'phone'           => '089695096085',
            'password'        => 'apiip777',
            'register_method' => 'whatsapp',
            'role'            => 'pengguna',
        ]);

        User::create([
            'user_id'         => 'USR-0004',
            'name'            => 'Kaia',
            'email'           => 'kaiapart01@gmail.com',
            'password'        => 'apiip777',
            'register_method' => 'google',
            'role'            => 'pengguna',
        ]);
    }
}
