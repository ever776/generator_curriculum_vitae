<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienciaLaboral extends Model
{
    use SoftDeletes;

    protected $table = 'experiencias_laborales';

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected $fillable = [
        'user_id',
        'entidad',
        'puesto',
        'descripcion',
        'direccion',
        'fecha_inicio',
        'fecha_final',
        'duracion',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_final' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function rules(): array
    {
        return [
            'entidad' => ['required', 'string', 'max:255'],
            'puesto' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'direccion' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_final' => ['nullable', 'date'],
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->fecha_inicio && $model->fecha_final) {
                $inicio = $model->fecha_inicio->copy();
                $final = $model->fecha_final->copy();
                $meses = $inicio->diffInMonths($final);
                $model->duracion = $meses;
            } else {
                $model->duracion = null;
            }
        });
    }
}
