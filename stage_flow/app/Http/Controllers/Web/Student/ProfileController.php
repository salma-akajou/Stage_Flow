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
        $etudiant = auth()->user()->etudiant()->with('ville')->first();
        if (!$etudiant) abort(404, "Profil étudiant introuvable.");
        
        $villes = Ville::all();
        return view('student.profile', compact('etudiant', 'villes'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->etudiantService->updateProfile(auth()->id(), $request->validated());
        
        return back()->with('success', 'Profil mis à jour !');
    }

}
