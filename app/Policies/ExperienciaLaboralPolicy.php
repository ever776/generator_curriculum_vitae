<?php

namespace App\Policies;

use App\Models\ExperienciaLaboral;
use App\Models\User;

class ExperienciaLaboralPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ExperienciaLaboral $experienciaLaboral): bool
    {
        return $user->id === $experienciaLaboral->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ExperienciaLaboral $experienciaLaboral): bool
    {
        return $user->id === $experienciaLaboral->user_id;
    }

    public function delete(User $user, ExperienciaLaboral $experienciaLaboral): bool
    {
        return $user->id === $experienciaLaboral->user_id;
    }

    public function restore(User $user, ExperienciaLaboral $experienciaLaboral): bool
    {
        return $user->id === $experienciaLaboral->user_id;
    }

    public function forceDelete(User $user, ExperienciaLaboral $experienciaLaboral): bool
    {
        return $user->id === $experienciaLaboral->user_id;
    }
}
