<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\FeedbackService;
use App\Models\Ville;
use Illuminate\Http\JsonResponse;

class LandingApiController extends Controller
{
    protected DashboardService $dashboardService;
    protected FeedbackService $feedbackService;

    public function __construct(
        DashboardService $dashboardService, 
        FeedbackService $feedbackService
    ) {
        $this->dashboardService = $dashboardService;
        $this->feedbackService = $feedbackService;
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
            'data' => \App\Models\Ville::select('id', 'nom')->get()
        ]);
    }
}
