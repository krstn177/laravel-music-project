<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Photo;
use App\Models\Genre;
use Illuminate\Http\Request;

class ProfileAlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Album::with(['photo', 'artists', 'genres'])
            ->where(function ($q) {
                $q->where('user_id', auth()->id())
                   ->orWhereNull('user_id');
            });

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

        return view('profile', compact('albums'));
    }

    public function create()
    {
        $photos = Photo::all();
        $artists = Artist::all();
        $genres = Genre::all();
        return view('profile.albums.create', compact('photos', 'artists', 'genres'));
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
        $data['user_id'] = auth()->id();

        $album = Album::create($data);
        $album->artists()->sync($request->input('artist_ids', []));
        $album->genres()->sync($request->input('genre_ids', []));

        return redirect()->route('profile')->with('success', 'Album created');
    }

    public function edit(Album $album)
    {
        $this->authorize('update', $album);

        $photos = Photo::all();
        $artists = Artist::all();
        $genres = Genre::all();
        return view('profile.albums.edit', compact('album', 'photos', 'artists', 'genres'));
    }

    public function update(Request $request, Album $album)
    {
        $this->authorize('update', $album);

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

        $album->update($data);
        $album->artists()->sync($data['artist_ids'] ?? []);
        $album->genres()->sync($data['genre_ids'] ?? []);

        return redirect()->route('profile')->with('success', 'Album updated');
    }

    public function destroy(Album $album)
    {
        $this->authorize('delete', $album);

        $album->delete();

        return redirect()->route('profile')->with('success', 'Album deleted');
    }
}
