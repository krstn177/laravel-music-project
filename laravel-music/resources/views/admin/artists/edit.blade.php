<x-app-layout>
    <x-slot name="header">✏️ Edit Artist — {{ $artist->name }}</x-slot>
    <div class="max-w-xl mx-auto p-6">
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.artists.update', $artist) }}">
            @csrf
            @method('PATCH')

            <label class="block font-semibold">Name</label>
            <input name="name" class="border p-2 w-full mb-3" value="{{ old('name', $artist->name) }}" required>

            <label class="inline-flex items-center mb-3">
                <input type="checkbox" name="is_band" class="mr-2" @checked(old('is_band', $artist->is_band))>
                <span>Is a band</span>
            </label>

            <label class="block font-semibold">Members (one per line)</label>
            <textarea name="members" class="border p-2 w-full mb-3" rows="4">{{ old('members', is_array($artist->members) ? implode("\n", $artist->members) : $artist->members) }}</textarea>

            <label class="block font-semibold">Photo</label>
            <select name="photo_id" class="border p-2 w-full mb-4">
                <option value="">None</option>
                @foreach($photos as $photo)
                    <option value="{{ $photo->id }}" @selected(old('photo_id', $artist->photo_id) == $photo->id)>{{ $photo->title ?? "Photo #{$photo->id}" }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-600 text-black px-4 py-2 rounded w-full">Save Changes</button>
        </form>
    </div>
</x-app-layout>