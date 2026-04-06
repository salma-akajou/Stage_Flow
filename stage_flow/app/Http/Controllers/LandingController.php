<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\FeedbackService;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * @var DashboardService
     */
    protected $dashboardService;

    /**
     * @var FeedbackService
     */
    protected $feedbackService;

    public function __construct(DashboardService $dashboardService, FeedbackService $feedbackService)
    {
        $this->dashboardService = $dashboardService;
        $this->feedbackService = $feedbackService;
    }

    public function index(): View
    {
        $stats = $this->dashboardService->getLandingStats();
        $feedbacks = $this->feedbackService->getLandingFeedbacks(3);

        return view('public.landing', compact('stats', 'feedbacks'));
    }
}
