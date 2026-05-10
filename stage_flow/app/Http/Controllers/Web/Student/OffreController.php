<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Services\OffreService;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OffreController extends Controller
{
    protected OffreService $offreService;

    public function __construct(OffreService $offreService)
    {
        $this->offreService = $offreService;
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['titre', 'secteur', 'ville_id', 'type_stage']);
        $data = $this->offreService->search($filters, 9, true);

        $etudiant = auth()->user() ? auth()->user()->etudiant : null;

        return view('student.offres.index', array_merge($data, [
            'etudiant' => $etudiant
        ]));
    }

    public function show(int $id): View
    {
        $offre = $this->offreService->getDetails($id);

        $etudiant = auth()->user() ? auth()->user()->etudiant : null;

        return view('student.offres.show', compact('offre', 'etudiant'));
    }
}
