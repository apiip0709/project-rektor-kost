<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.pages.user.create-user');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'register_method' => 'required|string',
            'role'            => 'required|in:pengguna,pemilik,teknisi',
            'email'           => $request->register_method === 'google' ? 'required|email|unique:users,email' : 'nullable|email',
            'phone'           => $request->register_method === 'whatsapp' ? 'required|string|max:20|unique:users,phone' : 'nullable',
            'password'        => 'required|string|min:8',
        ]);

        // Password tidak di-hash di sini karena model sudah menangani hashing secara otomatis
        User::create($validated);

        return redirect()->route('superadmin.user.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.user.edit-user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'role'  => 'required|in:pengguna,pemilik,teknisi',
            'password' => 'nullable|string|min:8',
        ];

        // Gunakan user_id sebagai pengecualian (ignore)
        if ($user->register_method === 'google') {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')
            ];
        } elseif ($user->register_method === 'whatsapp') {
            $rules['phone'] = [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($user->user_id, 'user_id')
            ];
        }

        $validated = $request->validate($rules);

        $updateData = [
            'name' => $validated['name'],
            'role' => $validated['role'],
        ];

        if ($user->register_method === 'google') {
            $updateData['email'] = $validated['email'];
        } else {
            $updateData['phone'] = $validated['phone'];
        }

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->update($updateData);

        return redirect()->route('superadmin.user.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(String $id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $user->delete();

        return redirect()->route('superadmin.user.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
