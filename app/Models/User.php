<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang boleh diisi secara massal.
     * Kolom gender, pob, dan dob telah dihapus karena sudah dikelola oleh model Owner.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'register_method',
        'role',
    ];

    /**
     * Atribut yang disembunyikan saat konversi ke Array/JSON (Keamanan).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data otomatis bawaan Laravel 11/12.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Otomatis Bcrypt saat create/update password
        ];
    }

    /**
     * RELASI: Hubungan ke Profil Owner (One-to-One)
     */
    public function ownerProfile()
    {
        return $this->hasOne(Owner::class, 'user_id', 'id');
    }
}
