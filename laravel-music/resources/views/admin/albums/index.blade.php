<x-app-layout>
    <x-slot name="header">
        🎵 Albums
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">

        <style>
            .album-portrait { position: relative; width: 100%; padding-top: 100%; overflow: hidden; }
            .album-portrait img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
            .album-portrait .fallback { position: absolute; inset: 0; display:flex; align-items:center; justify-content:center; }
        </style>

        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('admin.albums.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded">
               ➕ Add Album
            </a>

            <form method="GET" id="albumFilterForm" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="border p-2 rounded">

                <label class="sr-only">Sort</label>
                <select name="sort" class="border p-2 rounded" onchange="document.getElementById('albumFilterForm').submit()">
                    <option value="">Sort by</option>
                    <option value="title" @selected(request('sort')==='title')>Title</option>
                    <option value="release_date" @selected(request('sort')==='release_date')>Release Date</option>
                    <option value="duration" @selected(request('sort')==='duration')>Duration</option>
                    <option value="track_count" @selected(request('sort')==='track_count')>Tracks</option>
                    <option value="score" @selected(request('sort')==='score')>Score</option>
                </select>

                <input type="hidden" name="direction" id="directionInput" value="{{ request('direction','asc') }}">
                <button type="button" id="directionToggle" class="border px-2 py-2 rounded" title="Toggle sort direction">
                    @if(request('direction','asc') === 'asc')
                        ▲
                    @else
                        ▼
                    @endif
                </button>

                <button type="submit" class="bg-blue-500 text-black px-3 py-2 rounded">Search</button>
            </form>

            <script>
                (function(){
                    const btn = document.getElementById('directionToggle');
                    const form = document.getElementById('albumFilterForm');
                    const input = document.getElementById('directionInput');
                    if(btn && form && input){
                        btn.addEventListener('click', function(){
                            input.value = input.value === 'asc' ? 'desc' : 'asc';
                            form.submit();
                        });
                    }
                })();
            </script>
        </div>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($albums as $album)
                <div class="bg-white rounded shadow overflow-hidden">
                    <div class="album-portrait bg-gray-100">
                        @if($album->photo && $album->photo->path)
                            <img src="{{ asset('storage/' . $album->photo->path) }}" alt="{{ $album->title }}">
                        @else
                            <div class="fallback text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M7 7a5 5 0 0110 0M7 7v.01M17 7v.01"/>
                                </svg>
                            </div>
                        @endif

                        <div class="absolute top-2 right-2 flex space-x-2">
                            <a href="{{ route('admin.albums.edit', $album) }}" class="bg-white bg-opacity-80 text-gray-800 px-2 py-1 rounded text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.albums.destroy', $album) }}" class="inline" onsubmit="return confirm('Delete album?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-white bg-opacity-80 text-red-600 px-2 py-1 rounded text-sm">Delete</button>
                            </form>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $album->title }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ optional($album->release_date)->format('Y-m-d') ?? '—' }}</p>

                        <div class="text-sm text-gray-700 mb-2">
                            <strong>Tracks:</strong> {{ $album->track_count ?? '—' }}
                            &nbsp;•&nbsp;
                            <strong>Duration:</strong> {{ $album->duration ? gmdate('H:i:s', $album->duration) : '—' }}
                            &nbsp;•&nbsp;
                            <strong>Score:</strong> {{ $album->score ?? '—' }}
                        </div>

                        <div class="text-sm text-gray-700 mb-2">
                            <strong>Artists:</strong>
                            @if($album->artists && $album->artists->count())
                                {{ $album->artists->pluck('name')->join(', ') }}
                            @else
                                —
                            @endif
                        </div>

                        <div class="text-sm text-gray-600">
                            <strong>Genres:</strong>
                            @if($album->genres && $album->genres->count())
                                {{ $album->genres->pluck('name')->join(', ') }}
                            @else
                                —
                            @endif
                        </div>

                        <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.albums.edit', $album) }}" class="text-sm bg-white border px-2 py-1 rounded">Edit</a>

                        <form method="POST" action="{{ route('admin.albums.destroy', $album) }}" onsubmit="return confirm('Delete album?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 bg-white border px-2 py-1 rounded">Delete</button>
                        </form>
                    </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 p-8 bg-white rounded shadow">No albums found.</div>
            @endforelse
        </div>

        <div class="mt-6">{{ $albums->links() }}</div>

    </div>
</x-app-layout>