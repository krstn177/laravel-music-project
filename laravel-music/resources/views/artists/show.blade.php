<x-app-layout>
    <x-slot name="header">🎤 {{ $artist->name }}</x-slot>

    <div class="max-w-6xl mx-auto p-6">
        <style>
            .artist-hero { display: grid; grid-template-columns: 140px 1fr; gap: 1rem; align-items: center; }
            .artist-hero .portrait { width:140px; height:140px; border-radius:0.5rem; overflow:hidden; background:#f3f4f6 }
            .artist-hero .portrait img { width:100%; height:100%; object-fit:cover; display:block }
            .album-portrait { position: relative; width: 100%; padding-top: 100%; overflow: hidden; }
            .album-portrait img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
            .album-portrait .fallback { position: absolute; inset: 0; display:flex; align-items:center; justify-content:center; }
        </style>

        <header class="artist-hero mb-6 bg-white rounded shadow p-4">
            <div class="portrait">
                @if($artist->photo && $artist->photo->path)
                    <img src="{{ asset('storage/' . $artist->photo->path) }}" alt="{{ $artist->name }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M7 7a5 5 0 0110 0M7 7v.01M17 7v.01"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div>
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900">{{ $artist->name }}</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $artist->is_band ? 'Band' : 'Solo artist' }}</p>
                        @if($artist->is_band && is_array($artist->members) && count($artist->members))
                            <p class="mt-3 text-sm text-gray-700"><strong>Members:</strong> {{ implode(', ', $artist->members) }}</p>
                        @endif
                    </div>
                </div>

                @if($artist->is_band)
                    <p class="mt-4 text-sm text-gray-600">Explore albums by this band below.</p>
                @else
                    <p class="mt-4 text-sm text-gray-600">Explore albums by this artist below.</p>
                @endif
            </div>
        </header>

        <section>
            <h2 class="text-lg font-semibold mb-4">Albums</h2>

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
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $album->title }}</h3>
                            <p class="text-sm text-gray-500">{{ optional($album->release_date)->format('Y-m-d') ?? '—' }}</p>

                            <div class="mt-2 flex items-center text-sm text-gray-700 space-x-3">
                                <span><strong>Tracks:</strong> {{ $album->track_count ?? '—' }}</span>
                                <span><strong>Duration:</strong> {{ $album->duration ? gmdate('H:i:s', $album->duration) : '—' }}</span>
                            </div>

                            @if($album->genres && $album->genres->count())
                                <div class="mt-3 text-xs text-gray-600">
                                    @foreach($album->genres as $g)
                                        <span class="inline-block bg-gray-100 px-2 py-1 rounded mr-1">{{ $g->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 p-8 bg-white rounded shadow">No albums for this artist.</div>
                @endforelse
            </div>

            <div class="mt-6">{{ $albums->links() }}</div>
        </section>
    </div>
</x-app-layout>
