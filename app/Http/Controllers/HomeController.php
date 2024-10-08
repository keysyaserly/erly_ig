<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua foto yang telah diunggah, urutkan berdasarkan waktu unggahan terbaru
        $photos = Photo::with('user', 'comments')->orderBy('created_at', 'desc')->get();

        return view('home.index', compact('photos'));
    }
}
