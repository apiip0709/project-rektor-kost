<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    // Pengaturan primary key kustom string
    protected $primaryKey = 'owner_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'owner_id',
        'user_id',
        'gender',
        'pob',
        'dob',
        'status',
    ];

    /**
     * 🌟 LOGIKA AUTO-NUMBER KODE OWNER (OW-001, OW-002, dst)
     */
    protected static function booted()
    {
        static::creating(function ($owner) {
            // Ambil data owner terakhir berdasarkan owner_id terbesar
            $latestOwner = static::orderBy('owner_id', 'desc')->first();

            if (! $latestOwner) {
                // Jika belum ada data owner sama sekali
                $owner->owner_id = 'OW-001';
            } else {
                // Mengambil angka dari string terakhir (misal 'OW-001' diambil angka 1)
                $number = intval(substr($latestOwner->owner_id, 3));
                
                // Tambahkan angka 1 lalu format kembali menjadi 3 digit (002, 003, dst)
                $owner->owner_id = 'OW-' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * RELASI BALIK: Profil Owner ini milik Akun User yang mana
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * RELASI BERIKUTNYA: Hubungan ke tabel kosts
     * Karena sekarang kita pakai tabel khusus owner, maka tabel kosts akan mendeteksi owner_id dari tabel ini.
     */
    public function kosts()
    {
        return $this->hasMany(Kost::class, 'owner_id', 'owner_id');
    }
}
