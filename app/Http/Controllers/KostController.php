<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Room;
use App\Models\Owner;

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
