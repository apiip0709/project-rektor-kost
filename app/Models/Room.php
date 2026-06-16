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
        'type_room',
        'size_room',
        'price',
        'price_year',
        'description',
        'img_room',
        'floor_room',
        'status',
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
            // Jika room_id belum diisi secara manual, baru kita generate
            if (empty($room->room_id)) {
                // 1. Ambil digit setelah prefix (misal RK-0001 -> 0001)
                $prefixPos = strpos($room->kost_id, '-') + 1;
                $kostNumber = substr($room->kost_id, $prefixPos);

                // 2. Cari ID tertinggi untuk kost ini
                $latestRoom = static::where('kost_id', $room->kost_id)
                    ->orderBy('room_id', 'desc')
                    ->first();

                // Format penambahan RM di sini
                if (!$latestRoom) {
                    // Hasil: RM-0001-01
                    $room->room_id = 'RM-' . $kostNumber . '-01';
                } else {
                    // Ambil bagian setelah tanda '-' terakhir (mengabaikan RM-)
                    $lastSequence = intval(substr($latestRoom->room_id, strrpos($latestRoom->room_id, '-') + 1));
                    $nextSequence = $lastSequence + 1;

                    // Hasil: RM-0001-02, dst.
                    $room->room_id = 'RM-' . $kostNumber . '-' . str_pad($nextSequence, 2, '0', STR_PAD_LEFT);
                }
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
