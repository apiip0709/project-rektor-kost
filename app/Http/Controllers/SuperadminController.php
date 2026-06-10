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

    public function userIndex(Request $request)
    {
        $keyword = $request->get('search');

        $users = User::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('user_id', 'LIKE', "%{$keyword}%")
                    ->orWhere('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    // Mencari berdasarkan format tanggal (d M Y)
                    ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%{$keyword}%"]);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

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
