<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Models\Etudiant;
use App\Models\Feedback;
use App\Models\Entreprise;
use App\Services\FeedbackService;
use Illuminate\View\View;

class LandingController extends Controller
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

    public function index(): View
    {
        $stats = $this->dashboardService->getLandingStats();
        $feedbacks = $this->feedbackService->getLandingFeedbacks(3);

        return view('landing', compact('stats', 'feedbacks'));
    }
}
