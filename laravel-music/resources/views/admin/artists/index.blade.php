<x-app-layout>
    <x-slot name="header">🎤 Artists</x-slot>

    <div class="max-w-7xl mx-auto p-6">

        <style>
            /* ensure artist images are always square and cover the container */
            .artist-portrait { position: relative; width: 100%; padding-top: 100%; overflow: hidden; }
            .artist-portrait img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
            .artist-portrait .fallback { position: absolute; inset: 0; display:flex; align-items:center; justify-content:center; }
        </style>
        <div class="flex justify-between items-center mb-6">
            @can('create', App\Models\Artist::class)
                <a href="{{ route('admin.artists.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow">
                    ➕ Add Artist
                </a>
            @endcan

            <form method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Search artists..." value="{{ request('search') }}"
                       class="border rounded px-3 py-2 w-64" />
                <button type="submit" class="bg-gray-200 text-black px-3 py-2 rounded">Search</button>
            </form>
        </div>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($artists as $artist)
                <div class="bg-white shadow rounded overflow-hidden">
                    <div class="artist-portrait bg-gray-100">
                        @if($artist->photo && $artist->photo->path)
                            <img src="{{ asset('storage/' . $artist->photo->path) }}"
                                 alt="{{ $artist->name }}" />
                        @else
                            <div class="fallback text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M7 7a5 5 0 0110 0M7 7v.01M17 7v.01"/>
                                </svg>
                            </div>
                        @endif

                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('admin.artists.show', $artist) }}" class="bg-white bg-opacity-80 text-gray-800 px-2 py-1 rounded shadow text-sm">View Albums</a>

                        @can('update', $artist)
                            <a href="{{ route('admin.artists.edit', $artist) }}" class="bg-white bg-opacity-80 text-gray-800 px-2 py-1 rounded shadow text-sm">Edit</a>
                        @endcan

                        @can('delete', $artist)
                            <form method="POST" action="{{ route('admin.artists.destroy', $artist) }}" onsubmit="return confirm('Delete artist?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-white bg-opacity-80 text-red-600 px-2 py-1 rounded shadow text-sm">Delete</button>
                            </form>
                        @endcan
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $artist->name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $artist->is_band ? 'Band' : 'Solo' }}</p>

                        @if($artist->is_band)
                            @if(is_array($artist->members) && count($artist->members))
                                <div class="text-sm text-gray-700">
                                    <strong class="block mb-1">Members</strong>
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($artist->members as $member)
                                            <li>{{ $member }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No members listed.</p>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 p-8 bg-white rounded shadow">
                    No artists found.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $artists->links() }}
        </div>
    </div>
</x-app-layout>