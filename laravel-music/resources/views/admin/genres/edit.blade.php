<x-app-layout>
    <x-slot name="header">✏️ Edit Genre — {{ $genre->name }}</x-slot>

    <div class="max-w-xl mx-auto p-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul>@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.genres.update', $genre) }}">
            @csrf
            @method('PATCH')

            <label class="block font-semibold">Name</label>
            <input name="name" class="border p-2 w-full mb-3" value="{{ old('name', $genre->name) }}" required>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded w-full">Save Changes</button>
        </form>
    </div>
</x-app-layout>
