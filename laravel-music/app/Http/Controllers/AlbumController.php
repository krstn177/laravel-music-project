<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Photo;
use App\Models\Genre;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        // eager-load related photo, artists and genres to avoid N+1
        $query = Album::with(['photo', 'artists', 'genres']);

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $allowedSorts = ['title', 'release_date', 'duration', 'track_count', 'score'];
        if ($request->filled('sort') && in_array($request->sort, $allowedSorts)) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('title', 'asc');
        }

        $albums = $query->paginate(12)->withQueryString();

        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $photos = Photo::all();
        $artists = Artist::all();
        $genres = Genre::all();
        return view('admin.albums.create', compact('photos', 'artists', 'genres'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'track_count' => 'nullable|integer',
            'score' => 'nullable|integer',
            'photo_id' => 'nullable|exists:photos,id',
            'artist_ids' => 'nullable|array',
            'artist_ids.*' => 'exists:artists,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $album = Album::create($data);
        // attach selected artists (empty array will detach all)
        $album->artists()->sync($data['artist_ids'] ?? []);
        // attach selected genres
        $album->genres()->sync($data['genre_ids'] ?? []);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album created');
    }

    public function edit(Album $album)
    {
        $photos = Photo::all();
        $artists = Artist::all();
        $genres = Genre::all();
        return view('admin.albums.edit', compact('album', 'photos', 'artists', 'genres'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'track_count' => 'nullable|integer',
            'score' => 'nullable|integer',
            'photo_id' => 'nullable|exists:photos,id',
            'artist_ids' => 'nullable|array',
            'artist_ids.*' => 'exists:artists,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        // ensure we keep photo_id as-is (Album uses `photo_id` field)
        $album->update($data);
        $album->artists()->sync($data['artist_ids'] ?? []);
        $album->genres()->sync($data['genre_ids'] ?? []);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album updated');
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album deleted');
    }
}