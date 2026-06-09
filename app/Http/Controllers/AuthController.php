<?php

namespace App\Http\Controllers;

use App\Enums\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ========= LOGIN =========
    public function login()
    {
        return view('auth.login');
    }

    // ========= STORE LOGIN =========
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {

            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // Redirect
        return redirect()->intended(
            Auth::user()->role->value === RoleUser::Admin->value
                ? route('dashboard')
                : route('products')
        );
    }

    // ========= REGISTER =========
    public function register()
    {
        return view('auth.register');
    }

    // ======== LOGOUT =========
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('landing')
            ->with('success', 'Berhasil logout.');
    }
}
