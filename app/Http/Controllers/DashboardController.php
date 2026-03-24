<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\ExperienciaLaboral;
use App\Models\Titulo;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $userId = Auth::id();

        $stats = [
            'totalTitulos' => Titulo::where('user_id', $userId)->count(),
            'totalCertificados' => Certificado::where('user_id', $userId)->count(),
            'totalExperiencias' => ExperienciaLaboral::where('user_id', $userId)->count(),
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
        ]);
    }
}
