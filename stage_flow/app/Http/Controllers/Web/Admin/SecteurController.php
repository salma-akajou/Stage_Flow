<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\SecteurService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreSecteurRequest;
use App\Http\Requests\Admin\UpdateSecteurRequest;

class SecteurController extends Controller
{
    protected SecteurService $secteurService;

    public function __construct(SecteurService $secteurService)
    {
        $this->secteurService = $secteurService;
    }

    public function index(Request $request)
    {
        $filters = ['search' => $request->input('search')];
        $secteurs = $this->secteurService->search($filters, 10);

        if ($request->ajax()) {
            return view('components.admin.secteurs.table', compact('secteurs'))->render();
        }

        return view('admin.secteurs.index', compact('secteurs'));
    }

    public function store(StoreSecteurRequest $request)
    {
        $this->secteurService->create($request->only('nom'));

        return back()->with('success', 'Secteur créé avec succès.');
    }

    public function update(UpdateSecteurRequest $request, int $id)
    {
        $this->secteurService->update($id, $request->only('nom'));

        return back()->with('success', 'Secteur modifié avec succès.');
    }

    public function destroy(int $id)
    {
        $this->secteurService->delete($id);

        return back()->with('success', 'Secteur supprimé avec succès.');
    }
}
