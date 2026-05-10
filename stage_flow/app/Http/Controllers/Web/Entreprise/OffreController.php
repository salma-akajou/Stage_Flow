<?php

namespace App\Http\Controllers\Web\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Services\OffreService;
use App\Http\Requests\Entreprise\StoreOffreRequest;
use App\Http\Requests\Entreprise\UpdateOffreRequest;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    protected OffreService $offreService;

    public function __construct(OffreService $offreService)
    {
        $this->offreService = $offreService;
    }

    /**
     * Affichage de la liste des offres avec toutes les données nécessaires (Read)
     */
    public function index(Request $request)
    {
        $entrepriseId = auth()->id();
        
        $filters = $request->all();
        $filters['entreprise_id'] = $entrepriseId;

        $includeMeta = !$request->ajax();
        
        $data = $this->offreService->search($filters, 9, $includeMeta);

        if ($request->ajax()) {
            return view('components.entreprise.offres.table', ['offres' => $data])->render();
        }

        $entreprise = auth()->user()->entreprise;

        return view('entreprise.offres.index', array_merge([
            'entreprise' => $entreprise
        ], $data));
    }

    /**
     * Création d'une offre (Create)
     */
    public function store(StoreOffreRequest $request)
    {
        $data = $request->validated();
        $entreprise = auth()->user()->entreprise;
        
        $data['entreprise_id'] = auth()->id();
        $data['secteur'] = $entreprise->secteur;

        $this->offreService->create($data);

        return redirect()->route('entreprise.offres.index')
            ->with('success', 'Votre offre a été publiée avec succès !');
    }

    /**
     * Récupération d'une offre pour édition (via AJAX pour la modale)
     */
    public function edit(int $id)
    {
        $offre = $this->offreService->find($id);
        return response()->json($offre);
    }

    /**
     * Mise à jour d'une offre (Update)
     */
    public function update(UpdateOffreRequest $request, int $id)
    {
        $data = $request->validated();
        $entreprise = auth()->user()->entreprise;
        $data['secteur'] = $entreprise->secteur;

        $this->offreService->update($id, $data);

        return redirect()->route('entreprise.offres.index')
            ->with('success', 'L\'offre a été mise à jour avec succès.');
    }

    /**
     * Suppression d'une offre (Delete)
     */
    public function destroy(int $id)
    {
        $this->offreService->delete($id);

        return redirect()->route('entreprise.offres.index')
            ->with('success', 'L\'offre a été supprimée avec succès.');
    }
}
