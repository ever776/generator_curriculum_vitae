<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'institucion',
        'fecha_inicio',
        'fecha_conclusion',
        'duracion',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_conclusion' => 'date',
            'duracion' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'institucion' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_conclusion' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'duracion' => ['required', 'integer', 'min:1'],
            'pdf_path' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    public static function messages(): array
    {
        return [
            'fecha_conclusion.after_or_equal' => 'La fecha de conclusión debe ser posterior o igual a la fecha de inicio.',
            'pdf_path.mimes' => 'El archivo debe ser un PDF.',
            'pdf_path.max' => 'El archivo no puede superar los 10MB.',
        ];
    }
}
