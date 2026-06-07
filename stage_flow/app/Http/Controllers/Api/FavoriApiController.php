<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FavoriService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriApiController extends Controller
{
    protected FavoriService $favoriService;

    public function __construct(FavoriService $favoriService)
    {
        $this->favoriService = $favoriService;
    }

    /**
     * Liste paginée des favoris de l'étudiant
     */
    public function index($etudiantId, Request $request): JsonResponse
    {
        try {
            $perPage = $request->integer('per_page', 9);
            $favoris = $this->favoriService->list((int) $etudiantId, (int) $perPage);
            return response()->json([
                'success' => true,
                'data'    => $favoris,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur chargement favoris'], 500);
        }
    }

    /**
     * Toggle favori (ajoute ou supprime)
     */
    public function toggle($etudiantId, $offreId): JsonResponse
    {
        try {
            $result = $this->favoriService->toggle((int) $etudiantId, (int) $offreId);
            return response()->json([
                'success'  => true,
                'favoris'  => $result['attached'],
                'message'  => $result['attached'] ? 'Ajouté aux favoris' : 'Retiré des favoris',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur toggle favori'], 500);
        }
    }

    /**
     * Retourne la liste des IDs des offres favorites de l'étudiant
     */
    public function ids($etudiantId): JsonResponse
    {
        try {
            $ids = $this->favoriService->getFavoriteIds((int) $etudiantId);
            return response()->json(['success' => true, 'data' => $ids]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur'], 500);
        }
    }
}
