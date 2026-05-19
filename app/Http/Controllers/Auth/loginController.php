<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            if (Auth::user()->jabatan == 'admin') {
            }
            return redirect()->to('/')->send()->with('failed', 'Email Atau Password Anda Salah!');
        }
    }

    public function logout()
    {
        Auth::Logout(); 
        return \redirect('/');
    }
}