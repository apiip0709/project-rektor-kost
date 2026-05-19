<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Mail; 
use Illuminate\Support\Str;
use Carbon\Carbon; 
use App\Models\User;


class forgetPasswordController extends Controller
{
    public function index()
    {
        return view('Auth.forgetPassword');
    }

    public function forgetPasswordRequest (Request $request) {

        $request->validate([
            'email' => 'required|unique:password_resets|email|exists:users',
        ],[
            'exists' => 'Masukkan Email Anda Dengan Benar!',
            'confirmed' => 'Password Berbeda Dengan Password Confirmation!',
            'unique' => 'Anda Sudah Melakukan Request New Password Sebelumnya, Silahkan Cek Akun Email Anda!'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::send('email.emailContent', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'Silahkan Cek Email Anda!');

    }

    public function indexResetPasswordForm($token) { 
        return view('Auth.recoverPassword', [
            'token' => $token,
            "title" => "Forget Password"
        ]);
    }

    public function resetPasswordForm(Request $request)

    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
        ],[
            'exists' => 'Masukkan Email Anda Dengan Benar!',
            'confirmed' => 'Password Berbeda Dengan Password Confirmation!'
        ]);

        $updatePassword = DB::table('password_resets')  
        ->where([  
            'email' => $request->email,  
            'token' => $request->token
        ])->first();

        if(!$updatePassword){
            return back()->with('failed', 'Masukkan Email Anda Dengan Benar!');
        }

        $user = User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/')->with('success', 'Password Anda Berhasil Diubah! Silahkan Login');
    }
}