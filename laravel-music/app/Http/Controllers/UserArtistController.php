<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class UserArtistController extends Controller
{
    public function index(Request $request)
    {
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

        return view('artists.index', compact('artists'));
    }

    public function show(Artist $artist)
    {
        $artist->load(['photo']);
        $albums = $artist->albums()
            ->with(['photo', 'artists', 'genres'])
            ->orderBy('release_date', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('artists.show', compact('artist', 'albums'));
    }
}
