<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\FiliereService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreFiliereRequest;
use App\Http\Requests\Admin\UpdateFiliereRequest;

class FiliereController extends Controller
{
    protected FiliereService $filiereService;

    public function __construct(FiliereService $filiereService)
    {
        $this->filiereService = $filiereService;
    }

    public function index(Request $request)
    {
        $filters = ['search' => $request->input('search')];
        $filieres = $this->filiereService->search($filters, 10);

        if ($request->ajax()) {
            return view('components.admin.filieres.table', compact('filieres'))->render();
        }

        return view('admin.filieres.index', compact('filieres'));
    }

    public function store(StoreFiliereRequest $request)
    {
        $this->filiereService->create($request->only('nom'));

        return back()->with('success', 'Filière créée avec succès.');
    }

    public function update(UpdateFiliereRequest $request, int $id)
    {
        $this->filiereService->update($id, $request->only('nom'));

        return back()->with('success', 'Filière modifiée avec succès.');
    }

    public function destroy(int $id)
    {
        $this->filiereService->delete($id);

        return back()->with('success', 'Filière supprimée avec succès.');
    }
}
