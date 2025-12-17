<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PhotoAdminController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\GenreController;


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
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/photos', [PhotoAdminController::class, 'index'])->name('admin.photos.index');
    Route::post('/admin/photos', [PhotoAdminController::class, 'store'])->name('admin.photos.store');
    Route::get('/admin/photos/{photo}/edit', [PhotoAdminController::class, 'edit'])->name('admin.photos.edit');
    Route::patch('/admin/photos/{photo}', [PhotoAdminController::class, 'update'])->name('admin.photos.update');
    Route::delete('/admin/photos/{photo}', [PhotoAdminController::class, 'destroy'])->name('admin.photos.destroy');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
