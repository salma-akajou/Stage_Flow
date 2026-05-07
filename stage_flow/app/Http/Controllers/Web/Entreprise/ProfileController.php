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
        $entrepriseId = 6; 
        $entreprise = Entreprise::with('user', 'ville')->findOrFail($entrepriseId);
        $villes = Ville::all();

        return view('entreprise.profile', compact('entreprise', 'villes'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $entrepriseId = 6;
        $this->entrepriseService->updateProfile($entrepriseId, $request->validated());

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}
