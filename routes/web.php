<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController; // Pastikan untuk menggunakan controller yang sesuaiuse
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('welcome');
});

// Autentikasi
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Registrasi
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard/upload', [DashboardController::class, 'upload'])->name('dashboard.upload');
});
// routes/web.php
Route::get('/dashboard/edit/{id}', [DashboardController::class, 'edit'])->name('dashboard.edit')->middleware('auth');
Route::put('/dashboard/update/{id}', [DashboardController::class, 'update'])->name('dashboard.update')->middleware('auth');
Route::delete('/dashboard/destroy/{id}', [DashboardController::class, 'destroy'])->name('dashboard.destroy')->middleware('auth');


// Menampilkan daftar foto (gunakan POST jika GET tidak didukung)
Route::post('/photos', [PhotoController::class, 'index'])->name('photos.index');

// Menampilkan form upload foto (gunakan POST jika GET tidak didukung)
Route::post('/photos/create', [PhotoController::class, 'create'])->name('photos.create');

// Meng-upload foto
Route::post('/photos/upload', [PhotoController::class, 'upload'])->name('photos.upload');
// Route di web.php
Route::post('/photos/{id}/like', [PhotoController::class, 'like'])->name('photos.like');
Route::post('/photos/{id}/comment', [PhotoController::class, 'comment'])->name('photos.comment');
Route::get('/photos/liked', [PhotoController::class, 'likedPhotos'])->name('photos.liked');

// Menyimpan foto baru
Route::post('/photos/store', [PhotoController::class, 'store'])->name('photos.store');

// Menampilkan form edit foto (gunakan POST jika GET tidak didukung)
Route::post('/photos/{photo}/edit', [PhotoController::class, 'edit'])->name('photos.edit');

// Memperbarui foto
Route::put('/photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');

// Menghapus foto
Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
Route::get('/photos/{id}', [PhotoController::class, 'show'])->name('photos.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');




// Rute untuk Profil
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
//home
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/{id}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
Route::post('/profile/{id}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');



// Route untuk foto
Route::get('/photos/{id}/edit', [PhotoController::class, 'edit'])->name('photo.edit');
Route::put('/photos/{id}', [PhotoController::class, 'update'])->name('photo.update');
Route::delete('/photo/{id}', [PhotoController::class, 'destroy'])->name('photo.destroy');
