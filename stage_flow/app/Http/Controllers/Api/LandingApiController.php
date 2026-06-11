<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\FeedbackService;
use App\Services\OffreService;
use App\Models\Etablissement;
use App\Models\Filiere;
use Illuminate\Http\JsonResponse;

class LandingApiController extends Controller
{
    protected DashboardService $dashboardService;
    protected FeedbackService $feedbackService;
    protected OffreService $offreService;

    public function __construct(
        DashboardService $dashboardService, 
        FeedbackService $feedbackService,
        OffreService $offreService
    ) {
        $this->dashboardService = $dashboardService;
        $this->feedbackService = $feedbackService;
        $this->offreService = $offreService;
    }

    public function index(): JsonResponse
    {
        try {
            $stats = $this->dashboardService->getLandingStats();
            $feedbacks = $this->feedbackService->getLandingFeedbacks(3);

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'feedbacks' => $feedbacks
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données de la landing page'
            ], 500);
        }
    }

    /**
     * Retourne la liste de toutes les villes pour le filtrage
     */
    public function villes(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->dashboardService->getVilles()
        ]);
    }

    /**
     * Retourne la liste de tous les secteurs distincts pour le filtrage
     */
    public function secteurs(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->offreService->getDistinctSecteurs()
        ]);
    }

    /**
     * Retourne la liste de tous les établissements
     */
    public function etablissements(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Etablissement::select('id', 'nom')->get()
        ]);
    }

    /**
     * Retourne la liste de toutes les filières
     */
    public function filieres(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Filiere::select('id', 'nom')->get()
        ]);
    }
}
