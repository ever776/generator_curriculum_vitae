<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienciaLaboralRequest;
use App\Models\ExperienciaLaboral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ExperienciaLaboralController extends Controller
{
    public function index(): Response
    {
        $search = request('search', '');

        $experiencias = ExperienciaLaboral::with('user')
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
                            $sub->whereRaw('LOWER(entidad) LIKE ?', ["%{$term}%"])
                                ->orWhereRaw('LOWER(puesto) LIKE ?', ["%{$term}%"]);
                        });
                    }
                });
            })
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('experiencias-laborales/Index', [
            'experiencias' => $experiencias,
            'filters' => ['search' => $search],
        ]);
    }

    public function store(ExperienciaLaboralRequest $request): RedirectResponse
    {
        $this->authorize('create', ExperienciaLaboral::class);

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('experiencias-laborales', 'public');
        }

        ExperienciaLaboral::create($data);

        return to_route('experiencias-laborales.index');
    }

    public function update(ExperienciaLaboralRequest $request, $experienciaLaboral_id): RedirectResponse
    {
        $experienciaLaboral = ExperienciaLaboral::findOrFail($experienciaLaboral_id);

        $this->authorize('update', $experienciaLaboral);

        $data = $request->validated();

        if ($request->hasFile('pdf_path')) {
            if ($experienciaLaboral->pdf_path) {
                Storage::disk('public')->delete($experienciaLaboral->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf_path')->store('experiencias-laborales', 'public');
        } else {
            unset($data['pdf_path']);
        }

        $experienciaLaboral->update($data);

        return to_route('experiencias-laborales.index');
    }

    public function destroy($experienciaLaboral_id): RedirectResponse
    {
        $experienciaLaboral = ExperienciaLaboral::findOrFail($experienciaLaboral_id);

        $this->authorize('delete', $experienciaLaboral);

        if ($experienciaLaboral->pdf_path) {
            Storage::disk('public')->delete($experienciaLaboral->pdf_path);
        }

        $experienciaLaboral->delete();

        return to_route('experiencias-laborales.index');
    }
}
