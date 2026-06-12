<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Owner;

class OwnerController extends Controller
{
    public function updateStatus(Request $request, string $owner_id)
    {
        $request->validate([
            'akun' => 'required|in:aktif,menunggu,nonaktif',
        ]);

        $owner = Owner::where('owner_id', $owner_id)->firstOrFail();
        $user = $owner->user; // Pastikan relasi user ada di model Owner

        $owner->update([
            'akun' => $request->akun
        ]);

        // Jika diverifikasi (aktif), update role dan data kontak user
        if ($request->akun === 'aktif') {
            $user->update([
                'role'  => 'pemilik',
                'email' => $owner->temp_email ?? $user->email,
                'phone' => $owner->temp_phone ?? $user->phone
            ]);
        }
        // Jika nonaktif, kembalikan ke role standar
        elseif ($request->akun === 'nonaktif') {
            $user->update(['role' => 'pengguna']);
        }

        return redirect()->route('superadmin.owner.index')
            ->with('success', 'Status dan data user berhasil diperbarui!');
    }

    public function create(Request $request)
    {
        $userId = $request->query('user_id');

        $user = $userId ? User::where('user_id', $userId)->first() : null;

        return view('admin.pages.owner.create-owner', compact('user'));
    }

    public function store(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->firstOrFail();

        $request->validate([
            'email' => $user->register_method === 'whatsapp' ? 'required|email|unique:users,email' : 'nullable',
            'phone' => $user->register_method !== 'whatsapp' ? 'required|string|unique:users,phone' : 'nullable',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        Owner::create([
            'user_id'  => $user->user_id,
            'gender'   => strtolower($request->jenis_kelamin),
            'pob'      => $request->tempat_lahir,
            'dob'      => $request->tanggal_lahir,
        ]);

        return redirect()->route('superadmin.owner.index')
            ->with('success', 'Data pemilik berhasil disimpan dan menunggu verifikasi.');
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
