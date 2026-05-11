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
        $data = [
            'note' => $request->note,
            'texte' => $request->commentaire, 
            'auteur_id' => auth()->id() ?? 1, 
            'valide' => false
        ];

        $this->feedbackService->create($data);

        return redirect()->route('student.dashboard')->with('success', 'Merci pour votre feedback !');
    }
}
