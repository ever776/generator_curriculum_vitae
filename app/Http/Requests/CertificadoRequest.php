<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'institucion' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_conclusion' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'duracion' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_conclusion.after_or_equal' => 'La fecha de conclusión debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
