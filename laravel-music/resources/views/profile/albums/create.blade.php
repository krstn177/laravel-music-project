<x-app-layout>
    <x-slot name="header">
        ➕ Create Album
    </x-slot>

    <div class="max-w-xl mx-auto p-6">

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.albums.store') }}">
            @csrf

            <label class="block font-semibold">Title</label>
            <input name="title" class="border p-2 w-full mb-3" value="{{ old('title') }}">

            <label class="block font-semibold">Release Date</label>
            <input type="date" name="release_date" class="border p-2 w-full mb-3" value="{{ old('release_date') }}">

            <label class="block font-semibold">Duration (seconds)</label>
            <input type="number" name="duration" class="border p-2 w-full mb-3" value="{{ old('duration') }}">

            <label class="block font-semibold">Track Count</label>
            <input type="number" name="track_count" class="border p-2 w-full mb-3" value="{{ old('track_count') }}">

            <label class="block font-semibold">Score</label>
            <input type="number" name="score" class="border p-2 w-full mb-3" value="{{ old('score') }}">

            <label class="block font-semibold">Main Photo</label>
            <select name="photo_id" class="border p-2 w-full mb-4">
                <option value="">None</option>
                @foreach(App\Models\Photo::all() as $photo)
                    <option value="{{ $photo->id }}" @selected(old('photo_id')==$photo->id)>
                        {{ $photo->title ?? "Photo #{$photo->id}" }}
                    </option>
                @endforeach
            </select>

            <label class="block font-semibold">Artists</label>
            <div class="flex-row flex-wrap gap-4 mb-4">
                @foreach($artists as $artist)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="artist_ids[]" value="{{ $artist->id }}" @checked(in_array($artist->id, old('artist_ids', []))) class="form-checkbox">
                        <span>{{ $artist->name }}</span>
                    </label>
                @endforeach
            </div>

            <label class="block font-semibold">Genres</label>
            <div class="flex-row flex-wrap gap-4 mb-4">
                @foreach($genres as $genre)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="genre_ids[]" value="{{ $genre->id }}" @checked(in_array($genre->id, old('genre_ids', []))) class="form-checkbox">
                        <span>{{ $genre->name }}</span>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="bg-dark text-black px-4 py-2 rounded w-full">
                Create Album
            </button>
        </form>
    </div>
</x-app-layout>
