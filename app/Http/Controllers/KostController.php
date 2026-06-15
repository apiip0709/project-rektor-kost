<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Room;
use App\Models\Owner;
use Illuminate\Support\Facades\Storage;

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
        $kost = Kost::findOrFail($id);

        // 1. Validasi
        $request->validate([
            'name_kost' => 'required|string|max:255',
            'img_kost.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Handle Gambar (Hapus yang lama jika ada di input 'removed_images')
        $currentImages = json_decode($kost->img_kost, true) ?? [];
        $removedImages = json_decode($request->removed_images, true) ?? [];

        // Hapus file fisik dari storage
        foreach ($removedImages as $path) {
            if (Storage::exists('public/' . $path)) {
                Storage::delete('public/' . $path);
            }
        }
        
        // Filter array gambar yang tersisa
        $remainingImages = array_values(array_diff($currentImages, $removedImages));

        // 3. Handle Upload Gambar Baru
        if ($request->hasFile('img_kost')) {
            foreach ($request->file('img_kost') as $file) {
                $path = $file->store('kost', 'public');
                $remainingImages[] = $path;
            }
        }

        // 4. Update Data Kost
        $kost->update([
            'name_kost'    => $request->name_kost,
            'klasifikasi'  => $request->klasifikasi,
            'city'         => $request->city,
            'address'      => $request->address,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'description'  => $request->description,
            'campus'       => $request->campuses_data, // Data sudah berupa JSON string dari form
            'facility'     => $request->facilities_data, // Data sudah berupa JSON string dari form
            'img_kost'     => json_encode($remainingImages),
        ]);

        // 5. Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()->route('superadmin.kost.edit', $id)
                         ->with('success', 'Data kost berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
