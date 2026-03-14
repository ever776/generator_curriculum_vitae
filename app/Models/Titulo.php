<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Titulo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'institucion',
        'fecha_titulacion',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'fecha_titulacion' => 'date',
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
            'fecha_titulacion' => ['required', 'date'],
            'pdf_path' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    public static function messages(): array
    {
        return [
            'pdf_path.mimes' => 'El archivo debe ser un PDF.',
            'pdf_path.max' => 'El archivo no puede superar los 10MB.',
        ];
    }
}
