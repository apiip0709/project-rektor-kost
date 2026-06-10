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
     * 🌟 PERBAIKAN LOGIKA AUTO-NUMBER KODE OWNER MENJADI (OWN-0001, OWN-0002, dst)
     */
    protected static function booted()
    {
        static::creating(function ($owner) {
            // Ambil data owner terakhir berdasarkan owner_id terbesar
            $latestOwner = static::orderBy('owner_id', 'desc')->first();

            if (! $latestOwner) {
                // 🌟 JIKA BELUM ADA DATA: Setel data pertama ke OWN-0001 (4 digit)
                $owner->owner_id = 'OWN-0001';
            } else {
                // 🌟 PERBAIKAN SUBSTR: 'OWN-' panjangnya 4 karakter, maka kita ambil angka dari karakter ke-4 dan seterusnya
                $number = intval(substr($latestOwner->owner_id, 4));

                // 🌟 PERBAIKAN STR_PAD: Tambahkan angka 1 lalu format kembali menjadi 4 digit (0002, 0003, dst)
                $owner->owner_id = 'OWN-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * RELASI BALIK: Profil Owner ini milik Akun User yang mana
     */
    public function user()
    {
        // 🌟 PERBAIKAN RELASI: Mengubah foreign key lokal target dari 'id' menjadi 'user_id' agar sinkron dengan model User
        return $this->belongsTo(User::class, 'user_id', 'user_id');
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
