<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Owner;

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
            ->orderBy('user_id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.user.index-user', compact('users', 'keyword'));
    }

    public function ownerIndex(Request $request)
    {
        $keyword = $request->get('search');

        $pendingOwners = Owner::where('akun', 'menunggu')->with('user')->get();

        $owners = Owner::query()
            ->where('akun', '!=', 'menunggu')
            ->with('user')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    // Pencarian pada kolom di tabel owners
                    $q->where('owner_id', 'LIKE', "%{$keyword}%")
                        ->orWhere('status', 'LIKE', "%{$keyword}%")
                        ->orWhere('akun', 'LIKE', "%{$keyword}%")

                        // Pencarian pada kolom nama di tabel user
                        ->orWhereHas('user', function ($u) use ($keyword) {
                            $u->where('name', 'LIKE', "%{$keyword}%");
                        });
                });
            })
            ->orderBy('owner_id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $users = User::where('role', 'pengguna')->get();
        return view('admin.pages.owner.index-owner', compact('pendingOwners', 'owners', 'keyword', 'users'));
    }

    // Handle halaman Manajemen Properti (Kost)
    public function kostIndex()
    {
        return view('admin.pages.kost.index-kost');
    }
}
