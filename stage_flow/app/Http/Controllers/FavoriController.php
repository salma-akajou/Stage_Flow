<?php

namespace App\Http\Controllers;

use App\Services\FavoriService;
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
        $favoris = $this->favoriService->list($etudiantId);

        return view('student.favoris', compact('favoris'));
    }

    public function toggle(int $offreId)
    {
        $etudiantId = 1;
        return $this->favoriService->toggle($etudiantId, $offreId);
    }
}
