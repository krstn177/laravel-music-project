<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class UserAlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Album::with(['photo', 'artists', 'genres']);

        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

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

        return view('albums.index', compact('albums'));
    }
}
