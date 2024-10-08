<?php

namespace App\Http\Controllers;

use App\Models\Comment; // Pastikan model diimpor
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input komentar
        $request->validate([
            'content' => 'required|string|max:500',
            'photo_id' => 'required|exists:photos,id',
        ]);

        // Simpan komentar baru
        Comment::create([
            'content' => $request->content,
            'photo_id' => $request->photo_id,
            'user_id' => auth()->id(), // Menggunakan ID pengguna yang sedang login
        ]);

        // Redirect kembali ke halaman foto dengan pesan sukses
        return redirect()->route('photos.show', $request->photo_id)
                         ->with('success', 'Comment posted successfully!');
    }
}
