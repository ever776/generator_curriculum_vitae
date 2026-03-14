<?php

namespace App\Policies;

use App\Models\Certificado;
use App\Models\User;

class CertificadoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Certificado $certificado): bool
    {
        return $user->id === $certificado->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Certificado $certificado): bool
    {
        return $user->id === $certificado->user_id;
    }

    public function delete(User $user, Certificado $certificado): bool
    {
        return $user->id === $certificado->user_id;
    }

    public function restore(User $user, Certificado $certificado): bool
    {
        return $user->id === $certificado->user_id;
    }

    public function forceDelete(User $user, Certificado $certificado): bool
    {
        return $user->id === $certificado->user_id;
    }
}
