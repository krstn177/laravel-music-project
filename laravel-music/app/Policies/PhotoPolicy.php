<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Photo $photo)
    {
        return true;
    }

    public function create(User $user)
    {
        // any authenticated user may upload a photo
        return (bool) $user;
    }

    public function update(User $user, Photo $photo)
    {
        // no ownership field available; only admins may update
        return (bool) ($user->is_admin ?? false);
    }

    public function delete(User $user, Photo $photo)
    {
        // restrict deletion to admins for now
        return (bool) ($user->is_admin ?? false);
    }
}
