<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PhotoAdminController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProfileAlbumController;
use App\Http\Controllers\UserAlbumController;
use App\Http\Controllers\UserArtistController;
use App\Http\Controllers\UserGenreController;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
->middleware(['auth', 'verified'])
->name('dashboard');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/albums', AlbumController::class)
        ->names('admin.albums');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/artists', ArtistController::class)
        ->names('admin.artists');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/genres', GenreController::class)
        ->names('admin.genres');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/albums', [UserAlbumController::class, 'index'])->name('albums.index');
    Route::get('/artists', [UserArtistController::class, 'index'])->name('artists.index');
    Route::get('/artists/{artist}', [UserArtistController::class, 'show'])->name('artists.show');
    Route::get('/genres', [UserGenreController::class, 'index'])->name('genres.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/photos', [PhotoAdminController::class, 'index'])->name('admin.photos.index');
    Route::post('/admin/photos', [PhotoAdminController::class, 'store'])->name('admin.photos.store');
    Route::get('/admin/photos/{photo}/edit', [PhotoAdminController::class, 'edit'])->name('admin.photos.edit');
    Route::patch('/admin/photos/{photo}', [PhotoAdminController::class, 'update'])->name('admin.photos.update');
    Route::delete('/admin/photos/{photo}', [PhotoAdminController::class, 'destroy'])->name('admin.photos.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/admin-status', [App\Http\Controllers\UserController::class, 'updateAdminStatus'])->name('admin.users.updateAdminStatus');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('profile', [ProfileAlbumController::class, 'index'])
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::resource('/profile/albums', ProfileAlbumController::class)
        ->names('profile.albums');
});

require __DIR__.'/auth.php';
