<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Photo;
use App\Policies\ArtistPolicy;
use App\Policies\GenrePolicy;
use App\Policies\PhotoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Artist::class => ArtistPolicy::class,
        Genre::class => GenrePolicy::class,
        Photo::class => PhotoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
