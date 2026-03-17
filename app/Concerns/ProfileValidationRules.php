<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Validation\Rule;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>>
     */
    protected function profileRules(?int $userId = null): array
    {
        return [
            'name' => $this->nameRules(),
            'email' => $this->emailRules($userId),
            'apellidos' => ['nullable', 'string', 'max:255'],
            'lugar_fecha_nacimiento' => ['nullable', 'string', 'max:255'],
            'nacionalidad' => ['nullable', 'string', 'max:255'],
            'cedula_identidad' => ['nullable', 'string', 'max:50'],
            'estado_civil' => ['nullable', 'string', 'max:100'],
            'idioma' => ['nullable', 'string', 'max:255'],
            'domicilio' => ['nullable', 'string', 'max:255'],
            'celular' => ['nullable', 'string', 'max:20'],
            'descripcion_profesional' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user emails.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function emailRules(?int $userId = null): array
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            $userId === null
                ? Rule::unique(User::class)
                : Rule::unique(User::class)->ignore($userId),
        ];
    }
}
