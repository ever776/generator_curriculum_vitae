<?php

namespace App\Policies;

use App\Models\Titulo;
use App\Models\User;

class TituloPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Titulo $titulo): bool
    {
        return $user->id === $titulo->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Titulo $titulo): bool
    {
        return $user->id === $titulo->user_id;
    }

    public function delete(User $user, Titulo $titulo): bool
    {
        return $user->id === $titulo->user_id;
    }

    public function restore(User $user, Titulo $titulo): bool
    {
        return $user->id === $titulo->user_id;
    }

    public function forceDelete(User $user, Titulo $titulo): bool
    {
        return $user->id === $titulo->user_id;
    }
}
