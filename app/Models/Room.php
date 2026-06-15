<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Proteksi primary key kustom bertipe string
    protected $primaryKey = 'room_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'room_id',
        'kost_id',
        'no_room',
        'size_room',
        'floor_room',
        'status',
        'price',
        'description',
        'img_room',
    ];

    /**
     * Otomatisasi konversi JSON gambar menjadi Array PHP
     */
    protected $casts = [
        'img_room' => 'array',
    ];

    /**
     * 🌟 LOGIKA AUTO-NUMBER KODE KAMAR (Contoh: 0001-01)
     */
    protected static function booted()
    {
        static::creating(function ($room) {
            // 1. Ambil 4 digit angka belakang dari id_kost (Misal 'RK-0001' diambil '0001')
            $kostNumber = substr($room->kost_id, 3);

            // 2. Cari kamar terakhir yang terdaftar di kost tersebut
            $latestRoom = static::where('kost_id', $room->kost_id)
                ->orderBy('room_id', 'desc')
                ->first();

            if (! $latestRoom) {
                // Jika ini adalah kamar pertama di kost tersebut
                $room->room_id = $kostNumber . '-01';
            } else {
                // Mengambil 2 digit angka urutan terakhir (Misal '0001-01' diambil 1)
                $nextSequence = intval(substr($latestRoom->room_id, 5)) + 1;
                
                // Format kembali menjadi 0001-02, 0001-03, dst.
                $room->room_id = $kostNumber . '-' . str_pad($nextSequence, 2, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Relasi Balik ke Kost
     */
    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'kost_id');
    }
}
