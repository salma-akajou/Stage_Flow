<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Services\FavoriService;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriController extends Controller
{
    protected FavoriService $favoriService;

    public function __construct(FavoriService $favoriService)
    {
        $this->favoriService = $favoriService;
    }

    public function index(): View
    {
        $etudiantId = 1;
        $etudiant = Etudiant::find($etudiantId);
        $favoris = $this->favoriService->list($etudiantId);

        return view('student.favoris', compact('favoris', 'etudiant'));
    }

    public function toggle(int $offreId)
    {
        $etudiantId = 1;
        $this->favoriService->toggle($etudiantId, $offreId);
        
        return back()->with('success', 'Favoris mis à jour');
    }
}
