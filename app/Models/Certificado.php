<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'institucion',
        'fecha_inicio',
        'fecha_conclusion',
        'duracion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_conclusion' => 'date',
            'duracion' => 'integer',
        ];
    }

    public static function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'institucion' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_conclusion' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'duracion' => ['required', 'integer', 'min:1'],
        ];
    }

    public static function messages(): array
    {
        return [
            'fecha_conclusion.after_or_equal' => 'La fecha de conclusión debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
