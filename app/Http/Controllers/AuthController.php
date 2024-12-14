<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('/login.index');
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/order');
        }
        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     if (Auth::user()->level_id === 1) {
        //         # code...
        //         return redirect()->intended('/vehicle');
        //     } else {

        //         return redirect()->intended('/pemesanan-kamar');
        //     }
        // }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
