<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login',
        ]);
    }

    public function authenticate(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        // ini validasi apakah sudah terdaftar atau belum
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate($credentials); // untuk menghindari kejahatan

            return redirect()->intended('/dashboard');
        }

        // kalau user ga terdaftar, return back, kirim pesan Login Failed melalui variable loginError
        return back()->with('loginError', 'Login Failed');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate(); // matiin session
 
        $request->session()->regenerateToken(); // regenerate token
    
        return redirect('/');
    }
}
