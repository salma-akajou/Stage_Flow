<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\EtablissementService;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    protected EtablissementService $etablissementService;

    public function __construct(EtablissementService $etablissementService)
    {
        $this->etablissementService = $etablissementService;
    }

    public function index(Request $request)
    {
        $filters = ['search' => $request->input('search')];
        $etablissements = $this->etablissementService->search($filters, 10);

        if ($request->ajax()) {
            return view('components.admin.etablissements.table', compact('etablissements'))->render();
        }

        return view('admin.etablissements.index', compact('etablissements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:etablissements,nom',
        ]);

        $this->etablissementService->create($request->only('nom'));

        return back()->with('success', 'Établissement créé avec succès.');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:etablissements,nom,' . $id,
        ]);

        $this->etablissementService->update($id, $request->only('nom'));

        return back()->with('success', 'Établissement modifié avec succès.');
    }

    public function destroy(int $id)
    {
        $this->etablissementService->delete($id);

        return back()->with('success', 'Établissement supprimé avec succès.');
    }
}
