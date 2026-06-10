<?php

namespace App\Http\Controllers;

use App\Enums\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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


    // ========= STORE REGISTER =========
    public function registerStore(Request $request)
    {
        $validated = $request->validate(
            [
                'full_name' => [
                    'required',
                    'string',
                    'max:255',
                    'min:3',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:users,phone',
                ],

                'avatar' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers(),
                ],
            ],
            [
                'full_name.required' => 'Nama lengkap wajib diisi.',
                'full_name.min' => 'Nama lengkap minimal 3 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',

                'phone.required' => 'Nomor telepon wajib diisi.',
                'phone.unique' => 'Nomor telepon sudah digunakan.',

                'avatar.image' => 'Avatar harus berupa gambar.',
                'avatar.mimes' => 'Format avatar harus jpg, jpeg, png, atau webp.',
                'avatar.max' => 'Ukuran avatar maksimal 2 MB.',

                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.mixedCase' => 'Password harus mengandung huruf besar, kecil, dan angka.',
                'password.numbers' => 'Password harus mengandung huruf besar, kecil, dan angka.',
            ]
        );

        $avatarName = null;

        if ($request->hasFile('avatar')) {
            $avatarName = $request
                ->file('avatar')
                ->store('avatar', 'public');
        }

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'avatar' => $avatarName,
            'password' => Hash::make($validated['password']),
            'role' => RoleUser::Customer,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        // Redirect
        return redirect()->intended(
            Auth::user()->role->value === RoleUser::Admin->value
                ? route('dashboard')
                : route('products')
        );
    }

    // ======== LOGOUT =========
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('landing');
    }
}
