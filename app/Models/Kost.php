<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa primary key-nya bukan 'id' dan bukan bertipe integer increment
    protected $primaryKey = 'id_kost';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kost',
        'owner_id',
        'name_kost',
        'city',
        'campus',
        'address',
        'description',
        'img_kost',
        'facility',
        'latitude',
        'longitude',
        'status_kemitraan',
    ];

    /**
     * Otomatisasi konversi JSON data saat diakses
     */
    protected $casts = [
        'img_kost' => 'array',
        'facility' => 'array',
    ];

    /**
     * 🌟 LOGIKA AUTO-NUMBER KODE PR-0001
     */
    protected static function booted()
    {
        static::creating(function ($kost) {
            // Ambil record kost terakhir berdasarkan id_kost terbesar
            $latestKost = static::orderBy('id_kost', 'desc')->first();

            if (! $latestKost) {
                // Jika belum ada data sama sekali di database
                $kost->id_kost = 'PR-0001';
            } else {
                // Mengambil angka dari string terakhir (misal 'PR-0001' diambil 1)
                $number = intval(substr($latestKost->id_kost, 3));
                // Tambahkan angka 1 lalu format kembali menjadi 4 digit (0002, 0003, dst)
                $kost->id_kost = 'PR-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'owner_id');
    }
}
