<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Music Hub</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
                color: #fff;
                font-family: 'Figtree', sans-serif;
            }

            .hero {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 2rem;
            }

            .hero-content h1 {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                text-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            }

            .hero-content p {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                color: #b0b0b0;
            }

            .cta-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn {
                padding: 0.75rem 2rem;
                font-size: 1rem;
                border-radius: 0.5rem;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                cursor: pointer;
                border: none;
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            }

            .btn-secondary {
                background: transparent;
                color: white;
                border: 2px solid white;
            }

            .btn-secondary:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }

            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
                padding: 4rem 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                padding: 2rem;
                border-radius: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }

            .feature-card:hover {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(102, 126, 234, 0.5);
                transform: translateY(-5px);
            }

            .feature-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
            }

            .feature-card h3 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .feature-card p {
                color: #b0b0b0;
                font-size: 0.95rem;
            }

            .section-title {
                text-align: center;
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 3rem;
                margin-top: 2rem;
            }

            nav {
                background: rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(10px);
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: sticky;
                top: 0;
                z-index: 100;
            }

            nav .logo {
                font-size: 1.5rem;
                font-weight: 700;
                text-decoration: none;
                color: white;
            }

            nav .nav-links {
                display: flex;
                gap: 2rem;
            }

            nav a {
                color: #b0b0b0;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            nav a:hover {
                color: white;
            }

            @media (max-width: 768px) {
                .hero-content h1 {
                    font-size: 2rem;
                }

                .cta-buttons {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                }

                nav .nav-links {
                    gap: 1rem;
                    font-size: 0.9rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav>
            <a href="/" class="logo">🎵 Music Hub</a>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="hero">
            <div class="hero-content">
                <h1>🎵 Welcome to Music Hub</h1>
                <p>Discover, explore, and manage your favorite music</p>
                <div class="cta-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Sign Up</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div style="background: rgba(0, 0, 0, 0.2);">
            <h2 class="section-title">Explore Your Music</h2>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">📸</div>
                    <h3>Photo Gallery</h3>
                    <p>Browse and upload beautiful album artwork and artist photos</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎶</div>
                    <h3>Albums</h3>
                    <p>Discover albums from your favorite artists with detailed information</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎤</div>
                    <h3>Artists</h3>
                    <p>Explore all artists and their complete discography</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎼</div>
                    <h3>Genres</h3>
                    <p>Find music by your favorite genres and discover new styles</p>
                </div>
            </div>
        </div>
    </body>
</html>
