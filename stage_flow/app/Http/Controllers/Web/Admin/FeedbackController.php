<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'valide' => $request->input('valide'),
            'role' => $request->input('role')
        ];

        $feedbacks = $this->feedbackService->search($filters, 9);

        if ($request->ajax()) {
            return view('components.admin.feedbacks.table-partial', compact('feedbacks'))->render();
        }

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function approve(int $id)
    {
        $this->feedbackService->moderate($id, 'valider');
        return back()->with('success', 'Feedback approuvé et publié !');
    }

    public function destroy(int $id)
    {
        $this->feedbackService->delete($id);
        return back()->with('success', 'Feedback supprimé avec succès.');
    }
}
