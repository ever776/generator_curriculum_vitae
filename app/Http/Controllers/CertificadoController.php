<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificadoRequest;
use App\Models\Certificado;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $certificados = Certificado::orderBy('fecha_inicio', 'desc')->get();

        return Inertia::render('certificados/Index', [
            'certificados' => $certificados,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CertificadoRequest $request): RedirectResponse
    {
        Certificado::create($request->validated());

        return to_route('certificados.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CertificadoRequest $request, Certificado $certificado): RedirectResponse
    {
        $certificado->update($request->validated());

        return to_route('certificados.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificado $certificado): RedirectResponse
    {
        $certificado->delete();

        return to_route('certificados.index');
    }
}
