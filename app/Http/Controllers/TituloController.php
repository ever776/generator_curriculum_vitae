<?php

namespace App\Http\Controllers;

use App\Http\Requests\TituloRequest;
use App\Models\Titulo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TituloController extends Controller
{
    public function index(): Response
    {
        $search = request('search', '');

        $titulos = Titulo::with('user')
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
            ->orderBy('fecha_titulacion', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('titulos/Index', [
            'titulos' => $titulos,
            'filters' => ['search' => $search],
        ]);
    }

    public function store(TituloRequest $request): RedirectResponse
    {
        $this->authorize('create', Titulo::class);

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('titulos', 'public');
        }

        Titulo::create($data);

        return to_route('titulos.index');
    }

    public function update(TituloRequest $request, Titulo $titulo): RedirectResponse
    {
        $this->authorize('update', $titulo);

        $data = $request->validated();

        if ($request->hasFile('pdf_path')) {
            if ($titulo->pdf_path) {
                Storage::disk('public')->delete($titulo->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf_path')->store('titulos', 'public');
        }

        $titulo->update($data);

        return to_route('titulos.index');
    }

    public function destroy(Titulo $titulo): RedirectResponse
    {
        $this->authorize('delete', $titulo);

        if ($titulo->pdf_path) {
            Storage::disk('public')->delete($titulo->pdf_path);
        }

        $titulo->delete();

        return to_route('titulos.index');
    }
}
