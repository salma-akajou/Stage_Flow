<?php

namespace App\Http\Controllers\Web\Entreprise;

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
     * Marquer une notification comme lue et rediriger vers la liste des candidatures.
     */
    public function markRead(int $id): RedirectResponse
    {
        $notification = $this->notificationService->findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $this->notificationService->markAsRead($id);

        // For company, all notifications point to the candidatures list
        return redirect()->route('entreprise.candidatures.index');
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
