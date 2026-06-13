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
            'name_kost'    => 'required|string|max:255',
            'klasifikasi'  => 'required',
            'city'         => 'required',
            'campus'       => 'required',
            'address'      => 'required',
            'img_kost.*'   => 'image|mimes:jpeg,png,jpg|max:2048',
            'facility'     => 'nullable|array',
            'description'  => 'nullable|string',
        ]);

        // Proses upload gambar ...
        $imagePaths = [];
        if ($request->hasFile('img_kost')) {
            foreach ($request->file('img_kost') as $image) {
                $imagePaths[] = $image->store('kost_images', 'public');
            }
        }

        // Simpan ke Database
        Kost::create([
            // Mengambil dari input hidden, jika tidak ada (null) akan tetap tersimpan sebagai null
            'owner_id'         => $request->owner_id,

            'name_kost'        => $request->name_kost,
            'klasifikasi'      => $request->klasifikasi,
            'city'             => $request->city,
            'campus'           => $request->campus,
            'address'          => $request->address,
            'description'      => $request->description,
            'img_kost'         => $imagePaths,
            'facility'         => $request->facility,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'status_langganan' => 'silver',
            'status_kemitraan' => 'aktif',
        ]);

        return redirect()->route('superadmin.kost.index') // Sesuaikan route index Anda
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
