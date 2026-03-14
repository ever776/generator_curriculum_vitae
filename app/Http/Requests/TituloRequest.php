<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class TituloRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nombre' => ['required', 'string', 'max:255'],
            'institucion' => ['required', 'string', 'max:255'],
            'fecha_titulacion' => ['required', 'date'],
            'pdf_path' => ['nullable', File::types(['pdf'])->max(10240)],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'pdf_path.file' => 'El archivo debe ser un archivo válido.',
            'pdf_path.mimes' => 'El archivo debe ser un PDF.',
            'pdf_path.max' => 'El archivo no puede superar los 10MB.',
        ];
    }
}
