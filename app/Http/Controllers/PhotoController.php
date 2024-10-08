<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Comment; // Impor model Comment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        // Menampilkan foto terbaru dari semua user
        $photos = Photo::with('user')->latest()->get();
        return view('photos.index', compact('photos'));
    }

    public function create()
    {
        // Menampilkan form upload foto
        return view('photos.create');
    }

    public function store(Request $request)
    {
        // Validasi file foto
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        // Upload foto ke storage
        $path = $request->file('photo')->store('photos', 'public');

        // Simpan data foto ke database
        Photo::create([
            'user_id' => Auth::id(),
            'photo_path' => $path,
            'caption' => $request->caption,
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil diupload');
    }

    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('photos.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photo = Photo::findOrFail($id);

        // Jika ada file foto baru yang diupload
        if ($request->hasFile('photo')) {
            // Hapus file lama
            if ($photo->photo_path) {
                Storage::delete($photo->photo_path);
            }

            // Upload file baru
            $path = $request->file('photo')->store('photos');
            $photo->photo_path = $path;
        }

        // Update caption
        $photo->caption = $request->caption;
        $photo->save();

        return redirect()->route('profile.show', auth()->user()->id)->with('success', 'Foto berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // Menghapus file gambar dari storage jika diperlukan
        if (Storage::exists($photo->photo_path)) {
            Storage::delete($photo->photo_path);
        }

        // Menghapus foto dari database
        $photo->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }



    public function like($id)
    {
        $photo = Photo::findOrFail($id);

        // Tambah atau hapus like
        if ($photo->likes()->where('user_id', Auth::id())->exists()) {
            $photo->likes()->detach(Auth::id()); // Hapus like
            $photo->likes_count -= 1;
        } else {
            $photo->likes()->attach(Auth::id()); // Tambah like
            $photo->likes_count += 1;
        }

        $photo->save();
        return back();
    }

    public function likedPhotos()
    {
        // Ambil foto yang disukai oleh user
        $photos = auth()->user()->likes()->with('user')->latest()->get();
        return view('photos.liked', compact('photos'));
    }


    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        Comment::create([
            'photo_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->comment,
        ]);

        return back();
    }

    public function show($id)
    {
        // Ambil data photo beserta komentar menggunakan eager loading
        $photo = Photo::with('comments.user')->findOrFail($id); // Menambahkan user pada komentar

        // Kembalikan view beserta data photo
        return view('photos.show', compact('photo'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari foto berdasarkan caption atau nama pengguna
        $photos = Photo::where('caption', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            })
            ->with('user')
            ->latest()
            ->get();

        return view('photos.index', compact('photos'));
    }





}
