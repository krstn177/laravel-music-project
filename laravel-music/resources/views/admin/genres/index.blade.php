<x-app-layout>
    <x-slot name="header">🎼 Genres</x-slot>

    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            @can('create', App\Models\Genre::class)
                <a href="{{ route('admin.genres.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">➕ Add Genre</a>
            @endcan

            <form method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Search genres..." value="{{ request('search') }}" class="border rounded px-3 py-2" />
                <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded">Search</button>
            </form>
        </div>

        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($genres as $genre)
                <div class="bg-white rounded shadow p-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $genre->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $genre->albums_count }} album{{ $genre->albums_count === 1 ? '' : 's' }}</p>
                    </div>

                    <div class="flex items-center space-x-2">
                        @can('update', $genre)
                            <a href="{{ route('admin.genres.edit', $genre) }}" class="text-sm bg-white border px-2 py-1 rounded">Edit</a>
                        @endcan

                        @can('delete', $genre)
                            <form method="POST" action="{{ route('admin.genres.destroy', $genre) }}" onsubmit="return confirm('Delete genre?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 bg-white border px-2 py-1 rounded">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 p-8 bg-white rounded shadow">No genres found.</div>
            @endforelse
        </div>

        <div class="mt-6">{{ $genres->links() }}</div>
    </div>
</x-app-layout>
