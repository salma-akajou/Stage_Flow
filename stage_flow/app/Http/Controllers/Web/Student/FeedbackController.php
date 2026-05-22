<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Services\FeedbackService;
use App\Http\Requests\StoreFeedbackRequest;

class FeedbackController extends Controller
{
    protected FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }


    public function store(StoreFeedbackRequest $request)
    {
        $this->feedbackService->submitFeedback(
            auth()->id() ?? 1,
            (int) $request->note,
            (string) $request->commentaire
        );

        return redirect()->route('student.dashboard')->with('success', 'Merci pour votre feedback !');
    }
}
