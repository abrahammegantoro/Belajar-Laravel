<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        return view('login.forgot', [
            'title' => 'Forgot Password',
            'active' => 'login',
        ]);
    }

    public function password(Request $request)
    {
        // Validasi email 
        $request->validate(['email' => 'required|email']);

        // Send password reset link to user
        $status = Password::sendResetLink(
            $request->only('email') // Ambil dari email usernya
        );

        return $status === Password::RESET_LINK_SENT // Kalo reset link terkirim
                ? back()->with((['status' => __($status)])) // __ ini translation strings
                : back()->withErrors(['email' => __($status)]);
    }

    public function password_update(Request $request) {
        
        // Validasi dulu
        $request->validate([
            'token' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'same:password', // harus sama kayak password
        ]);

        // Validasi password request credentials
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([ // ambil user dengan email tersebut
                    'password' => Hash::make($password) // bikin password
                ])->setRememberToken(Str::random(60)); // bikin token baru
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}
