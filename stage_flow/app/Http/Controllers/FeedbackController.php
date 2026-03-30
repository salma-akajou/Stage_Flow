<?php

namespace App\Http\Controllers;

use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'texte' => 'required|string|max:1000',
            'note' => 'required|integer|min:1|max:5',
        ]);

        $data['auteur_id'] = 1; // Simulation d'utilisateur (Salma)
        $data['valide'] = false; // Nécessite modération par défaut

        $this->feedbackService->create($data);
        
        return back()->with('success', 'Merci pour votre feedback ! Il sera visible après modération.');
    }
}
