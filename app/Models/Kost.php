<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa primary key-nya bukan 'id' dan bukan bertipe integer increment
    protected $primaryKey = 'kost_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kost_id',
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
        'status_langganan',
        'status_kemitraan',
    ];

    /**
     * Otomatisasi konversi JSON data saat diakses
     */
    protected $casts = [
        'img_kost' => 'array',
        'facility' => 'array',
        'campus' => 'array',
    ];

    /**
     * 🌟 LOGIKA AUTO-NUMBER KODE PR-0001
     */
    protected static function booted()
    {
        static::creating(function ($kost) {
            // Ambil record kost terakhir berdasarkan kost_id terbesar
            $latestKost = static::orderBy('kost_id', 'desc')->first();

            if (! $latestKost) {
                // Jika belum ada data sama sekali di database
                $kost->kost_id = 'PR-0001';
            } else {
                // Mengambil angka dari string terakhir (misal 'PR-0001' diambil 1)
                $number = intval(substr($latestKost->kost_id, 3));
                // Tambahkan angka 1 lalu format kembali menjadi 4 digit (0002, 0003, dst)
                $kost->kost_id = 'PR-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getImagesAttribute()
    {
        $images = json_decode($this->img_kost, true);

        // Jika data null atau bukan array, kembalikan array kosong
        if (!$images) {
            return [];
        }

        // Jika ingin memastikan path selalu benar,
        // kita pastikan tidak ada double slash
        return array_map(function ($path) {
            return ltrim($path, '/');
        }, $images);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'owner_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'kost_id', 'kost_id');
    }
}
