<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $redirectTo = '/admin';
    public function showLoginForm()
    {
        return view('auth.login');
    }

  public function login(Request $request)
{
    // Validasi form input kosong
    $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ], [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
    ]);

    $user = \App\Models\User::where('username', $request->username)->first();

    if (!$user) {
        return back()->withErrors([
            'username' => 'Username tidak ditemukan.',
        ])->onlyInput('username');
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'password' => 'Password salah.',
        ])->onlyInput('username');
    }

    // Login berhasil
    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->intended('/admin');
}


public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')->with('status', 'Anda telah berhasil logout.');
}

}
