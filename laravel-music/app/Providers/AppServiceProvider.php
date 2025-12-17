<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Photo;
use App\Policies\ArtistPolicy;
use App\Policies\GenrePolicy;
use App\Policies\PhotoPolicy;
use App\Models\Album;
use App\Policies\AlbumPolicy;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $router = $this->app->make(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware('admin', \App\Http\Middleware\EnsureAdmin::class);

        // register policies here so the app works without the default AuthServiceProvider entry
        Gate::policy(Artist::class, ArtistPolicy::class);
        Gate::policy(Genre::class, GenrePolicy::class);
        Gate::policy(Photo::class, PhotoPolicy::class);
    }

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Album::class => AlbumPolicy::class,
        Photo::class => PhotoPolicy::class,
    ];
}
