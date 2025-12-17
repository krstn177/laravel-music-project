<?php

namespace App\Policies;

use App\Models\Artist;
use App\Models\User;

class ArtistPolicy
{
    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Artist $artist)
    {
        return true;
    }

    public function create(User $user)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function update(User $user, Artist $artist)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function delete(User $user, Artist $artist)
    {
        return (bool) ($user->is_admin ?? false);
    }
}
