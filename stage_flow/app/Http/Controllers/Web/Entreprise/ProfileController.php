<?php

namespace App\Http\Controllers\Web\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Ville;
use App\Services\EntrepriseService;
use Illuminate\Http\Request;

use App\Http\Requests\Entreprise\UpdateProfileRequest;

class ProfileController extends Controller
{
    protected EntrepriseService $entrepriseService;

    public function __construct(EntrepriseService $entrepriseService)
    {
        $this->entrepriseService = $entrepriseService;
    }

    public function index()
    {
        $entreprise = auth()->user()->entreprise()->with('ville')->first();
        if (!$entreprise) abort(404, "Profil entreprise introuvable.");

        $villes = Ville::all();
        return view('entreprise.profile', compact('entreprise', 'villes'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->entrepriseService->updateProfile(auth()->id(), $request->validated());

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}
