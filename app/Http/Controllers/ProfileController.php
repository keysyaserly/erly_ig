<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use App\Models\Follower; // Pastikan model Follower diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Debugging
        if (!$user) {
            dd('Pengguna tidak ditemukan.');
        }

        return view('profile.profile', compact('user'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->file('photo')) {
            $path = $request->file('photo')->store('photos', 'public'); // Simpan di folder photos

            // Simpan informasi foto ke database
            Photo::create([
                'photo_path' => $path,
                'caption' => $request->caption,
                'user_id' => auth()->id(), // Menghubungkan foto dengan pengguna yang login
            ]);
        }

        return redirect()->back()->with('success', 'Foto berhasil diunggah.');
    }

    public function show($id)
    {
        $user = User::with(['photos', 'followers'])->findOrFail($id);
        return view('profile.show', compact('user'));
    }

    public function follow(Request $request, $id)
    {
        $follower = auth()->user()->id;

        if ($follower !== $id) {
            Follower::create([
                'user_id' => $id,
                'follower_id' => $follower,
            ]);
        }

        return back();
    }

    public function unfollow($id)
    {
        $follower = auth()->user()->id;
        Follower::where('user_id', $id)->where('follower_id', $follower)->delete();
        return back();
    }
}
