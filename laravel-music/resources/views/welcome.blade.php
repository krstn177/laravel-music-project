<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Music Hub</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white font-sans">
        <!-- Navigation -->
        <nav class="sticky top-0 z-100 bg-black/30 backdrop-blur-lg border-b border-white/10 px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">🎵 Music Hub</a>
            <div class="flex gap-8">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="min-h-screen flex flex-col items-center justify-center px-6 py-20 text-center">
            <h1 class="text-5xl sm:text-6xl font-bold mb-6 text-shadow">🎵 Welcome to Music Hub</h1>
            <p class="text-xl sm:text-2xl text-gray-400 mb-8 max-w-2xl">Discover, explore, and manage your favorite music</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-1 transition duration-300">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-1 transition duration-300">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 hover:-translate-y-1 transition duration-300">
                            Sign Up
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-black/20 py-20">
            <h2 class="text-4xl sm:text-5xl font-bold text-center mb-16">Explore Your Music</h2>
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Photos Card -->
                <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-xl p-8 hover:bg-white/10 hover:border-purple-500/50 hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-4">📸</div>
                    <h3 class="text-2xl font-bold mb-3">Photo Gallery</h3>
                    <p class="text-gray-400">Browse and upload beautiful album artwork and artist photos</p>
                </div>

                <!-- Albums Card -->
                <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-xl p-8 hover:bg-white/10 hover:border-purple-500/50 hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-4">🎶</div>
                    <h3 class="text-2xl font-bold mb-3">Albums</h3>
                    <p class="text-gray-400">Discover albums from your favorite artists with detailed information</p>
                </div>

                <!-- Artists Card -->
                <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-xl p-8 hover:bg-white/10 hover:border-purple-500/50 hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-4">🎤</div>
                    <h3 class="text-2xl font-bold mb-3">Artists</h3>
                    <p class="text-gray-400">Explore all artists and their complete discography</p>
                </div>

                <!-- Genres Card -->
                <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-xl p-8 hover:bg-white/10 hover:border-purple-500/50 hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-4">🎼</div>
                    <h3 class="text-2xl font-bold mb-3">Genres</h3>
                    <p class="text-gray-400">Find music by your favorite genres and discover new styles</p>
                </div>
            </div>
        </div>
    </body>
</html>
