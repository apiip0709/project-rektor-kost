<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperadminController extends Controller
{
    // Handle halaman Ikhtisar Ekosistem (Dashboard)
    public function dashboard()
    {
        return view('admin.pages.dashboard-superadmin');
    }

    // Handle halaman Manajemen User
    public function userIndex(Request $request)
    {
        // 1. Ambil keyword pencarian dari input text
        $keyword = $request->get('search');

        // 2. Mengambil SEMUA data user tanpa memandang tingkatan role
        $usersQuery = User::query();

        // 3. Logika fitur pencarian berdasarkan nama atau email
        if (!empty($keyword)) {
            $usersQuery->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%");
            });
        }

        // 4. Urutkan dari pendaftar terbaru dan bagi 10 entri per halaman
        $users = $usersQuery->latest()->paginate(10)->withQueryString();

        // 5. Kirim data ke file Blade view
        return view('admin.pages.user.index-user', compact('users', 'keyword'));
    }

    // Handle halaman Manajemen Pemilik
    public function ownerIndex()
    {
        return view('admin.pages.owner.index-owner');
    }

    // Handle halaman Manajemen Properti (Kost)
    public function kostIndex()
    {
        return view('admin.pages.kost.index-kost');
    }
}
