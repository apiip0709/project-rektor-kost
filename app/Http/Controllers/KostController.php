<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Room;
use App\Models\Owner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KostController extends Controller
{
    public function create(Request $request)
    {
        $ownerId = $request->query('owner_id');

        $selectedOwner = null;
        if ($ownerId) {
            $selectedOwner = Owner::where('owner_id', $ownerId)->first();
        }

        return view('admin.pages.kost.create-kost', compact('selectedOwner'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name_kost'       => 'required|string|max:255',
            'klasifikasi'     => 'required',
            'city'            => 'required',
            'campuses_data'   => 'required', // Harus sesuai dengan name di form
            'facilities_data' => 'required', // Harus sesuai dengan name di form
            'address'         => 'required',
            'img_kost'        => 'required',
            'img_kost.*'      => 'image|mimes:jpeg,png,jpg|max:2048',
            'description'     => 'nullable|string',
            'latitude'        => 'required',
            'longitude'       => 'required',
        ]);

        // 2. Proses upload gambar
        $imagePaths = [];
        if ($request->hasFile('img_kost')) {
            foreach ($request->file('img_kost') as $image) {
                $imagePaths[] = $image->store('kost_images', 'public');
            }
        }

        // 3. Simpan ke Database
        // Karena kita mengirim data sebagai JSON dari input hidden,
        // kita simpan langsung apa adanya atau di-decode sesuai kebutuhan database Anda
        Kost::create([
            'owner_id'         => $request->owner_id,
            'name_kost'        => $request->name_kost,
            'klasifikasi'      => $request->klasifikasi,
            'city'             => $request->city,
            'campus'           => $request->campuses_data, // Sesuai dengan field di form
            'facility'         => $request->facilities_data, // Sesuai dengan field di form
            'address'          => $request->address,
            'description'      => $request->description,
            'img_kost'         => json_encode($imagePaths), // Pastikan formatnya sesuai (JSON atau String)
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'status_langganan' => 'silver',
            'status_kemitraan' => 'aktif',
        ]);

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('superadmin.kost.index')
            ->with('success', 'Data properti berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mengambil data kost beserta pemilik dan kamar terkait
        $kost = Kost::with(['owner.user', 'rooms'])->where('kost_id', $id)->firstOrFail();

        // Jika Anda memerlukan daftar semua owner untuk dropdown (opsional)
        $owners = Owner::with('user')->get();

        return view('admin.pages.kost.edit-kost', compact('kost', 'owners'));
    }

    public function update(Request $request, $id)
    {
        // Menggunakan kost_id sebagai acuan (sesuai alur sebelumnya)
        $kost = Kost::where('kost_id', $id)->firstOrFail();

        // 1. Validasi Input
        $request->validate([
            'name_kost'    => 'required|string|max:255',
            'img_kost.*'   => 'image|mimes:jpeg,png,jpg|max:2048',
            'removed_images' => 'nullable|string', // Tambahkan validasi untuk keamanan
        ]);

        // 2. Handle Gambar (Hapus)
        $currentImages = json_decode($kost->img_kost, true) ?? [];
        $removedImages = json_decode($request->removed_images, true) ?? [];

        if (!empty($removedImages)) {
            foreach ($removedImages as $path) {
                // Pastikan hanya menghapus jika path valid dan ada
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            // Filter array gambar yang tersisa
            $currentImages = array_values(array_diff($currentImages, $removedImages));
        }

        // 3. Handle Upload Gambar Baru
        if ($request->hasFile('img_kost')) {
            foreach ($request->file('img_kost') as $file) {
                $path = $file->store('kost', 'public');
                $currentImages[] = $path;
            }
        }

        // 4. Update Data
        $kost->update([
            'name_kost'    => $request->name_kost,
            'klasifikasi'  => $request->klasifikasi,
            'city'         => $request->city,
            'address'      => $request->address,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'description'  => $request->description,
            'campus'       => $request->campuses_data,
            'facility'     => $request->facilities_data,
            'img_kost'     => json_encode($currentImages),
        ]);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('superadmin.kost.edit', ['kost' => $id])
            ->with('success', 'Data properti berhasil diperbarui!');
    }

    public function storeRoom(Request $request, $id)
    {
        $kost = Kost::where('kost_id', $id)->firstOrFail();

        $request->validate([
            'nomor_kamar'   => 'required|array',
            'ukuran_kamar'  => 'required|array',
            'harga_bulan'   => 'required|array',
        ]);

        try {
            DB::transaction(function () use ($request, $kost) {
                if (!$request->has('nomor_kamar')) {
                    throw new \Exception('Tidak ada data kamar yang dikirim.');
                }

                $uids = array_keys($request->nomor_kamar);

                foreach ($request->nomor_kamar as $uid => $nomor_kamar_list) {
                    $typeRoom = chr(65 + array_search($uid, $uids));
                    $imgPaths = $this->uploadRoomImages($request, $uid);

                    foreach ($nomor_kamar_list as $nomor) {
                        // Karena sudah ada booted, kita cukup gunakan identitas unik
                        // yang sudah ada di database (kost_id + no_room)
                        Room::updateOrCreate(
                            [
                                'kost_id' => $kost->kost_id,
                                'no_room' => $nomor
                            ],
                            [
                                'type_room'   => $typeRoom,
                                'size_room'   => $request->ukuran_kamar[$uid] ?? '',
                                'price'       => (string) ($request->harga_bulan[$uid] ?? '0'),
                                'price_year'  => (string) ($request->harga_tahun[$uid] ?? '0'),
                                'description' => $request->deskripsi_kamar[$uid] ?? '',
                                'img_room'    => !empty($imgPaths) ? json_encode($imgPaths) : null,
                                'floor_room'  => $request->lantai_room[$uid] ?? 1,
                            ]
                        );
                    }
                }
            });

            return redirect()->route('superadmin.kost.edit', ['kost' => $id])
                ->with('success', 'Data kamar berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Gagal simpan kamar: ' . $e->getMessage());
            return redirect()->route('superadmin.kost.edit', ['kost' => $id])
                ->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    private function uploadRoomImages(Request $request, string $uid): array
    {
        $paths = [];
        if ($request->hasFile("img_kost.$uid")) {
            foreach ($request->file("img_kost.$uid") as $file) {
                $paths[] = $file->store('rooms', 'public');
            }
        }
        return $paths;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
