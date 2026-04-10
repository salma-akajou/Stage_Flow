<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OffreService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class OffreApiController extends Controller
{
    protected OffreService $offreService;

    public function __construct(OffreService $offreService)
    {
        $this->offreService = $offreService;
    }

    /**
     * Retourne la liste des offres (paginée et filtrée si nécessaire)
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['titre', 'secteur', 'ville_id', 'type_stage']);
        $offres = $this->offreService->search($filters);
        
        return response()->json([
            'success' => true,
            'data' => $offres
        ]);
    }

    /**
     * Retourne les détails d'une offre spécifique
     */
    public function show(int $id): JsonResponse
    {
        try {
            $offre = $this->offreService->getDetails($id);
            return response()->json([
                'success' => true,
                'data' => $offre
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Offre introuvable'
            ], 404);
        }
    }
}
