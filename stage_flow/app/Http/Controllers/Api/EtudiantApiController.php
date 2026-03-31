<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EtudiantService;
use App\Services\DashboardService;
use App\Models\Etudiant;
use Illuminate\Http\JsonResponse;

class EtudiantApiController extends Controller
{
    protected EtudiantService $etudiantService;
    protected DashboardService $dashboardService;

    public function __construct(EtudiantService $etudiantService, DashboardService $dashboardService)
    {
        $this->etudiantService = $etudiantService;
        $this->dashboardService = $dashboardService;
    }

    /**
     * Retourne les données du profil étudiant
     */
    public function profile($etudiantId): JsonResponse
    {
        try {
            $etudiant = Etudiant::with('user', 'ville')->findOrFail($etudiantId);
            return response()->json([
                'success' => true,
                'data' => $etudiant
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Étudiant introuvable'
            ], 404);
        }
    }

    /**
     * Retourne les statistiques et recommandations pour le dashboard étudiant
     */
    public function dashboard($etudiantId): JsonResponse
    {
        try {
            $data = $this->dashboardService->getEtudiantDashboardData($etudiantId);
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Données du tableau de bord introuvables'
            ], 404);
        }
    }
}
