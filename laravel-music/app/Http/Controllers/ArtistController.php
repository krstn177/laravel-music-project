<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Photo;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        // eager-load photo to avoid N+1 when rendering cards
        $query = Artist::with('photo');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $allowedSorts = ['name', 'created_at'];
        if ($request->filled('sort') && in_array($request->sort, $allowedSorts)) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('name', 'asc');
        }

        $artists = $query->paginate(12)->withQueryString();

        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        $photos = Photo::all();
        return view('admin.artists.create', compact('photos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo_id' => 'nullable|exists:photos,id',
        ]);

        $members = [];
        if ($request->filled('members')) {
            $members = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $request->members))));
        }

        $artist = Artist::create([
            'name' => $data['name'],
            'is_band' => $request->has('is_band'),
            'members' => $members,
            'photo_id' => $data['photo_id'] ?? null,
        ]);

        return redirect()->route('admin.artists.index')->with('success', 'Artist created');
    }

    public function edit(Artist $artist)
    {
        $photos = Photo::all();
        return view('admin.artists.edit', compact('artist', 'photos'));
    }

    public function show(Artist $artist)
    {
        $artist->load(['photo']);
        $albums = $artist->albums()->with(['photo','artists','genres'])->orderBy('release_date','desc')->paginate(12);

        return view('admin.artists.show', compact('artist', 'albums'));
    }

    public function update(Request $request, Artist $artist)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo_id' => 'nullable|exists:photos,id',
        ]);

        $members = [];
        if ($request->filled('members')) {
            $members = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $request->members))));
        }

        $artist->update([
            'name' => $data['name'],
            'is_band' => $request->has('is_band'),
            'members' => $members,
            'photo_id' => $data['photo_id'] ?? null,
        ]);

        return redirect()->route('admin.artists.index')->with('success', 'Artist updated');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('admin.artists.index')->with('success', 'Artist deleted');
    }
}
