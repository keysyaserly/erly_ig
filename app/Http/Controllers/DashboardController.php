<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user(); // Ambil pengguna yang sedang login
        $photos = Photo::where('user_id', $user->id)->latest()->get(); // Ambil foto pengguna yang sedang login

        return view('dashboard.index', compact('user', 'photos')); // Kirim data user dan photos ke view
    }

    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $photoPath = $request->file('photo')->store('photos', 'public');

        Photo::create([
            'photo_path' => $photoPath,
            'caption' => $request->caption,
            'user_id' => auth()->id(), // Ambil ID pengguna yang sedang login
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Foto berhasil di-upload');
    }

    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('dashboard.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photo = Photo::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            Storage::disk('public')->delete($photo->photo_path);
            $photoPath = $request->file('photo')->store('photos', 'public');
            $photo->photo_path = $photoPath; // Update path foto
        }

        $photo->caption = $request->input('caption');
        $photo->save();

        return redirect()->route('dashboard.index')->with('success', 'Foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return redirect()->route('dashboard.index')->with('success', 'Foto berhasil dihapus!');
    }
}
