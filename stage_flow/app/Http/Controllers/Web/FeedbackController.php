<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FeedbackService;
use App\Models\Etudiant;
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

        $etudiant = Etudiant::find($request->etudiant_id);
        if ($etudiant) {
            $data['auteur_id'] = $etudiant->user->id;
        }
        $data['valide'] = false;

        $this->feedbackService->create($data);
        
        return back()->with('success', 'Merci pour votre feedback !');
    }
}
