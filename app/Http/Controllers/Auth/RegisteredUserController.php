<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    // Menampilkan form registrasi
    public function create()
    {
        return view('auth.register');
    }

    // Menyimpan data registrasi dan membuat pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('status', 'Registration successful!');
    }
}
