<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ExperienciaLaboralRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'entidad' => ['required', 'string', 'max:255'],
            'puesto' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'direccion' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_final' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'pdf_path' => ['nullable', File::types(['pdf'])->max(10240)],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'entidad.required' => 'La entidad es requerida.',
            'puesto.required' => 'El puesto es requerido.',
            'descripcion.required' => 'La descripción es requerida.',
            'direccion.required' => 'La dirección es requerida.',
            'fecha_inicio.required' => 'La fecha de inicio es requerida.',
            'fecha_final.after_or_equal' => 'La fecha final no puede ser menor que la fecha de inicio.',
            'pdf_path.file' => 'El archivo debe ser un archivo válido.',
            'pdf_path.mimes' => 'El archivo debe ser un PDF.',
            'pdf_path.max' => 'El archivo no puede superar los 10MB.',
        ];
    }
}
