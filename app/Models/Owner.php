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
        'akun',
        'status',
        'temp_email',
        'temp_phone',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function kosts()
    {
        return $this->hasMany(Kost::class, 'owner_id', 'owner_id');
    }
}
