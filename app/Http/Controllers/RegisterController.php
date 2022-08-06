<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function index() {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request) {
        
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        // enkripsi
        // $validatedData['password'] = bcrypt($validatedData['password']); (Alternatif)
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        // flash message
        // $request->session()->flash('success', 'Registration successfull! Please login');

        // with juga kirim flash message
        return redirect('/login')->with('success', 'Registration successfull! Please login');
    }
}
