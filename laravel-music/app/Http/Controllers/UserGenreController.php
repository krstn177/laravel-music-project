<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class UserGenreController extends Controller
{
    public function index(Request $request)
    {
        $query = Genre::withCount('albums');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $genres = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        return view('genres.index', compact('genres'));
    }
}
