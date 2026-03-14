<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificadoRequest;
use App\Models\Certificado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CertificadoController extends Controller
{
    use AuthorizesRequests; 

    public function index(): Response
    {
        $certificados = Certificado::with('user')
            ->where('user_id', auth()->id())
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return Inertia::render('certificados/Index', [
            'certificados' => $certificados,
        ]);
    }

    public function store(CertificadoRequest $request): RedirectResponse
    {
        $this->authorize('create', Certificado::class);

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('certificados', 'public');
        }

        Certificado::create($data);

        return to_route('certificados.index');
    }

    public function update(CertificadoRequest $request, Certificado $certificado): RedirectResponse
    {
        $this->authorize('update', $certificado);

        $data = $request->validated();

        if ($request->hasFile('pdf_path')) {
            if ($certificado->pdf_path) {
                Storage::disk('public')->delete($certificado->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf_path')->store('certificados', 'public');
        }

        $certificado->update($data);

        return to_route('certificados.index');
    }

    public function destroy(Certificado $certificado): RedirectResponse
    {
        $this->authorize('delete', $certificado);

        if ($certificado->pdf_path) {
            Storage::disk('public')->delete($certificado->pdf_path);
        }

        $certificado->delete();

        return to_route('certificados.index');
    }
}
