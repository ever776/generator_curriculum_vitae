<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\ExperienciaLaboral;
use App\Models\Titulo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurriculumController extends Controller
{
    public function generate(Request $request)
    {
        $user = Auth::user();

        $titulos = Titulo::where('user_id', $user->id)
            ->orderBy('fecha_titulacion', 'desc')
            ->get();

        $certificados = Certificado::where('user_id', $user->id)
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        $experiencias = ExperienciaLaboral::where('user_id', $user->id)
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        $pdf = Pdf::loadView('curriculum.template', [
            'user' => $user,
            'titulos' => $titulos,
            'certificados' => $certificados,
            'experiencias' => $experiencias,
        ]);

        $fileName = 'curriculum_vitae_'.str_replace(' ', '_', $user->name).'.pdf';

        return $pdf->stream($fileName);
    }
}
