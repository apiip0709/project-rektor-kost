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

        // 2. Buat Akun Superadmin sesuai Enum di Migration Anda
        User::create([
            'name'            => 'Superadmin A5',
            'email'           => 'projectrektor@gmail.com',
            'password'        => Hash::make('rektoratgagal'),
            'register_method' => 'google',
            'role'            => 'superadmin',
        ]);
    }
}
