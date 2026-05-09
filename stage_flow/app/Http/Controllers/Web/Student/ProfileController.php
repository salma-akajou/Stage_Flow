<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Services\EtudiantService;
use App\Services\FavoriService;
use App\Models\Etudiant;
use App\Models\Ville;
use App\Http\Requests\Student\UpdateProfileRequest;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected EtudiantService $etudiantService;
    protected FavoriService $favoriService;

    public function __construct(
        EtudiantService $etudiantService,
        FavoriService $favoriService
    ) {
        $this->etudiantService = $etudiantService;
        $this->favoriService = $favoriService;
    }


    public function index(): View
    {
        $etudiant = Etudiant::with('user', 'ville')->first(); // Plus sûr pour les tests
        if (!$etudiant) abort(404, "Aucun étudiant trouvé. Lancez le seeder !");
        
        $villes = Ville::all();
        return view('student.profile', compact('etudiant', 'villes'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $etudiant = Etudiant::first();
        $this->etudiantService->updateProfile($etudiant->user_id, $request->validated());
        
        return back()->with('success', 'Profil mis à jour !');
    }

}
