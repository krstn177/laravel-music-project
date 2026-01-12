<x-app-layout>
    <x-slot name="header">🎼 Genres</x-slot>

    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <div></div>

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
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 p-8 bg-white rounded shadow">No genres found.</div>
            @endforelse
        </div>

        <div class="mt-6">{{ $genres->links() }}</div>
    </div>
</x-app-layout>
