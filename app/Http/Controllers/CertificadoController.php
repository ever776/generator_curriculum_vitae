<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificadoRequest;
use App\Models\Certificado;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CertificadoController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $search = request('search', '');

        $certificados = Certificado::with('user')
            ->where('user_id', auth()->id())
            ->when($search, function ($query) use ($search) {
                $searchTerms = array_filter(
                    array_map('trim', explode(' ', mb_strtolower($search)))
                );

                if (empty($searchTerms)) {
                    return;
                }

                $query->where(function ($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where(function ($sub) use ($term) {
                            $sub->whereRaw('LOWER(nombre) LIKE ?', ["%{$term}%"])
                                ->orWhereRaw('LOWER(institucion) LIKE ?', ["%{$term}%"]);
                        });
                    }
                });
            })
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('certificados/Index', [
            'certificados' => $certificados,
            'filters' => ['search' => $search],
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
