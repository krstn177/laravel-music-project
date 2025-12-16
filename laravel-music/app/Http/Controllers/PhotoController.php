<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();
        return view('photos.index', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048', // 2MB max
            'title' => 'nullable|string|max:255',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        Photo::create([
            'path' => $path,
            'title' => $request->title,
        ]);

        return back()->with('success', 'Photo uploaded successfully!');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return back();
    }
}