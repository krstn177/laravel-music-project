<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">{{ __("Welcome!") }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Photos Link -->
                        <a href="{{ route('photos.index') }}" class="p-4 bg-blue-50 rounded-lg border-2 border-blue-200 hover:border-blue-500 transition">
                            <div class="text-2xl mb-2">📸</div>
                            <h4 class="font-semibold text-lg">Photos</h4>
                            <p class="text-sm text-gray-600">Upload and manage photos</p>
                        </a>

                        <!-- Albums Link -->
                        <a href="{{ route('albums.index') }}" class="p-4 bg-purple-50 rounded-lg border-2 border-purple-200 hover:border-purple-500 transition">
                            <div class="text-2xl mb-2">🎶</div>
                            <h4 class="font-semibold text-lg">Albums</h4>
                            <p class="text-sm text-gray-600">Browse albums</p>
                        </a>

                        <!-- Artists Link -->
                        <a href="{{ route('artists.index') }}" class="p-4 bg-pink-50 rounded-lg border-2 border-pink-200 hover:border-pink-500 transition">
                            <div class="text-2xl mb-2">🎤</div>
                            <h4 class="font-semibold text-lg">Artists</h4>
                            <p class="text-sm text-gray-600">Explore artists</p>
                        </a>

                        <!-- Genres Link -->
                        <a href="{{ route('genres.index') }}" class="p-4 bg-green-50 rounded-lg border-2 border-green-200 hover:border-green-500 transition">
                            <div class="text-2xl mb-2">🎼</div>
                            <h4 class="font-semibold text-lg">Genres</h4>
                            <p class="text-sm text-gray-600">Browse genres</p>
                        </a>
                    </div>

                    @if(auth()->user()->is_admin)
                        <div class="mt-8 pt-6 border-t">
                            <h3 class="text-xl font-bold mb-4">Admin Tools</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <a href="{{ route('admin.photos.index') }}" class="p-4 bg-red-50 rounded-lg border-2 border-red-200 hover:border-red-500 transition">
                                    <div class="text-2xl mb-2">🛠</div>
                                    <h4 class="font-semibold text-lg">Manage Photos</h4>
                                    <p class="text-sm text-gray-600">Admin photos</p>
                                </a>

                                <a href="{{ route('admin.albums.index') }}" class="p-4 bg-red-50 rounded-lg border-2 border-red-200 hover:border-red-500 transition">
                                    <div class="text-2xl mb-2">🛠</div>
                                    <h4 class="font-semibold text-lg">Manage Albums</h4>
                                    <p class="text-sm text-gray-600">Admin albums</p>
                                </a>

                                <a href="{{ route('admin.artists.index') }}" class="p-4 bg-red-50 rounded-lg border-2 border-red-200 hover:border-red-500 transition">
                                    <div class="text-2xl mb-2">🛠</div>
                                    <h4 class="font-semibold text-lg">Manage Artists</h4>
                                    <p class="text-sm text-gray-600">Admin artists</p>
                                </a>

                                <a href="{{ route('admin.genres.index') }}" class="p-4 bg-red-50 rounded-lg border-2 border-red-200 hover:border-red-500 transition">
                                    <div class="text-2xl mb-2">🛠</div>
                                    <h4 class="font-semibold text-lg">Manage Genres</h4>
                                    <p class="text-sm text-gray-600">Admin genres</p>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
