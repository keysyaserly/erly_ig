<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        // Menampilkan halaman login
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Tidak ada validasi, email dan password bisa bebas
        $email = $request->input('email', 'guest@example.com');

        // Dapatkan atau buat pengguna baru berdasarkan email yang dimasukkan
        $user = User::firstOrCreate(
            ['email' => $email], // Jika email belum ada, buat user baru
            [
                'name' => 'Guest User', // Nama default
                'password' => bcrypt('defaultpassword') // Password default
            ]
        );

        // Login otomatis tanpa mengecek password
        Auth::login($user);

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // Redirect ke halaman dashboard atau halaman yang diinginkan
        return redirect()->intended('/home');
    }

    }

