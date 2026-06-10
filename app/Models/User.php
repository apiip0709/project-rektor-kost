<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 🌟 1. ATUR PRIMARY KEY SEBAGAI STRING CUSTOM
    protected $primaryKey = 'user_id';
    public $incrementing = false; // Matikan auto-increment database
    protected $keyType = 'string'; // Tegaskan bahwa tipenya string

    protected $fillable = [
        'user_id', // 🌟 Masukkan ke fillable agar bisa diisi otomatis oleh system
        'name',
        'email',
        'phone',
        'password',
        'register_method',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 🌟 2. LOGIKA AUTO-NUMBER KODE USER (USR-0001, USR-0002, dst)
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            // Ambil data user terakhir berdasarkan user_id terbesar
            $latestUser = static::orderBy('user_id', 'desc')->first();

            if (! $latestUser) {
                // Jika belum ada data sama sekali di database
                $user->user_id = 'USR-0001';
            } else {
                // Mengambil angka dari string terakhir (misal 'USR-0001' diambil angka 1)
                // 'USR-' panjangnya 4 karakter, maka kita ambil teks setelah indeks ke-4
                $number = intval(substr($latestUser->user_id, 4));

                // Tambahkan angka 1 lalu format kembali menjadi 4 digit (0002, 0003, dst)
                $user->user_id = 'USR-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * RELASI: Hubungan ke Profil Owner (One-to-One)
     */
    public function ownerProfile()
    {
        // Tetap menggunakan user_id sebagai foreign key dan owner key
        return $this->hasOne(Owner::class, 'user_id', 'user_id');
    }
}
