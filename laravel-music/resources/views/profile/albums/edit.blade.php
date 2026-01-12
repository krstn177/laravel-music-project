<x-app-layout>
    <x-slot name="header">
        ✏️ Edit Album — {{ $album->title }}
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

        <form method="POST" action="{{ route('profile.albums.update', $album) }}">
            @csrf
            @method('PATCH')

            <label class="block font-semibold">Title</label>
            <input name="title" class="border p-2 w-full mb-3" value="{{ old('title', $album->title) }}">

            <label class="block font-semibold">Release Date</label>
            <input type="date" name="release_date" class="border p-2 w-full mb-3"
                   value="{{ old('release_date', optional($album->release_date)->format('Y-m-d')) }}">

            <label class="block font-semibold">Duration (seconds)</label>
            <input type="number" name="duration" class="border p-2 w-full mb-3"
                   value="{{ old('duration', $album->duration) }}">

            <label class="block font-semibold">Track Count</label>
            <input type="number" name="track_count" class="border p-2 w-full mb-3"
                   value="{{ old('track_count', $album->track_count) }}">

            <label class="block font-semibold">Score</label>
            <input type="number" name="score" class="border p-2 w-full mb-3"
                   value="{{ old('score', $album->score) }}">

            <label class="block font-semibold">Main Photo</label>
            <select name="photo_id" class="border p-2 w-full mb-4">
                <option value="">None</option>
                @foreach(App\Models\Photo::all() as $photo)
                    <option value="{{ $photo->id }}" @selected(old('photo_id', $album->photo_id)==$photo->id)>
                        {{ $photo->title ?? "Photo #{$photo->id}" }}
                    </option>
                @endforeach
            </select>
            
            @php $selected = old('artist_ids', $album->artists->pluck('id')->toArray()); @endphp
            <label class="block font-semibold">Artists</label>
            <div class="flex-row flex-wrap gap-4 mb-4">
                @foreach($artists as $artist)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="artist_ids[]" value="{{ $artist->id }}" @checked(in_array($artist->id, $selected)) class="form-checkbox">
                        <span>{{ $artist->name }}</span>
                    </label>
                @endforeach
            </div>

            @php $genreSelected = old('genre_ids', $album->genres->pluck('id')->toArray()); @endphp
            <label class="block font-semibold">Genres</label>
            <div class="flex-row flex-wrap gap-4 mb-4">
                @foreach($genres as $genre)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="genre_ids[]" value="{{ $genre->id }}" @checked(in_array($genre->id, $genreSelected)) class="form-checkbox">
                        <span>{{ $genre->name }}</span>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded w-full">
                Save Changes
            </button>
        </form>
    </div>
</x-app-layout>
