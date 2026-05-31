<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Marquer une notification comme lue et rediriger.
     */
    public function markRead(int $id): RedirectResponse
    {
        $notification = $this->notificationService->findOrFail($id);

        // Security check
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $this->notificationService->markAsRead($id);

        // Redirect based on type
        if ($notification->type === 'candidature_status') {
            return redirect()->route('student.candidatures');
        }

        if ($notification->type === 'new_offre') {
            $offreId = $notification->data['offre_id'] ?? null;
            if ($offreId) {
                return redirect()->route('student.offres.show', $offreId);
            }
        }

        return redirect()->back();
    }

    /**
     * Marquer toutes les notifications comme lues.
     */
    public function markAllRead(Request $request)
    {
        $this->notificationService->markAllAsRead(auth()->id());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Toutes les notifications ont été marquées comme lues.'
            ]);
        }

        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}
