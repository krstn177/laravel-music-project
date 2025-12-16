<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoAdminController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();
        return view('admin.photos.index', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'title' => 'nullable|string|max:255'
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        Photo::create([
            'path' => $path,
            'title' => $request->title
        ]);

        return back()->with('success', 'Photo uploaded successfully');
    }

    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048'
        ]);

        $photo->title = $request->title;

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($photo->path);
            $photo->path = $request->file('photo')->store('photos', 'public');
        }

        $photo->save();

        return redirect()->route('admin.photos.index')->with('success', 'Photo updated');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return back()->with('success', 'Photo deleted');
    }
}
