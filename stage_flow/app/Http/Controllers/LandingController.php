<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\OffreService;
use App\Services\FeedbackService;
use Illuminate\View\View;

class LandingController extends Controller
{
    protected DashboardService $dashboardService;
    protected OffreService $offreService;
    protected FeedbackService $feedbackService;

    public function __construct(
        DashboardService $dashboardService, 
        OffreService $offreService,
        FeedbackService $feedbackService
    ) {
        $this->dashboardService = $dashboardService;
        $this->offreService = $offreService;
        $this->feedbackService = $feedbackService;
    }

    public function index(): View
    {
        $stats = $this->dashboardService->getLandingStats();
        $recommendedOffres = $this->offreService->getRecommended(3);
        $feedbacks = $this->feedbackService->getLandingFeedbacks(3);

        return view('landing', compact('stats', 'recommendedOffres', 'feedbacks'));
    }
}
