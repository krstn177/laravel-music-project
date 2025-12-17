<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;

class GenrePolicy
{
    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Genre $genre)
    {
        return true;
    }

    public function create(User $user)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function update(User $user, Genre $genre)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function delete(User $user, Genre $genre)
    {
        return (bool) ($user->is_admin ?? false);
    }
}
