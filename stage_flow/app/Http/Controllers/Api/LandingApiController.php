<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\FeedbackService;
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

    /**
     * Retourne les données nécessaires pour construire la Landing Page Mobile
     */
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
}
