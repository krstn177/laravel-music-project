<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Genre::withCount('albums');

        if (request()->filled('search')) {
            $query->where('name', 'like', '%'.request('search').'%');
        }

        $genres = $query->orderBy('name')->paginate(12)->withQueryString();
        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($data);

        return redirect()->route('admin.genres.index')->with('success', 'Genre created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return redirect()->route('admin.genres.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,'.$genre->id,
        ]);

        $genre->update($data);

        return redirect()->route('admin.genres.index')->with('success', 'Genre updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Genre deleted');
    }
}
