<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use App\Services\ChatbotContextService;
use App\Services\ChatbotCommandHandler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    protected GeminiService $gemini;
    protected ChatbotContextService $context;
    protected ChatbotCommandHandler $handler;

    public function __construct(
        GeminiService $gemini,
        ChatbotContextService $context,
        ChatbotCommandHandler $handler
    ) {
        $this->gemini = $gemini;
        $this->context = $context;
        $this->handler = $handler;
    }

    public function handleMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:10000',
        ]);

        $message = $request->input('message');
        $userId = auth()->id();
        $role = 'guest';

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->hasRole('admin')) {
                $role = 'admin';
            } elseif ($user->hasRole('entreprise')) {
                $role = 'entreprise';
            } elseif ($user->hasRole('etudiant')) {
                $role = 'etudiant';
            }
        }

        // Récupérer le contexte lié au rôle de l'utilisateur
        $context = $this->context->getContext($role, $userId, $message);

        // Envoyer à l'API Gemini
        $aiResponse = $this->gemini->generate($context, $message, $role);

        // Exécuter l'action sur la base de données locale si nécessaire
        $result = $this->handler->handle($aiResponse, $userId ?: 0);

        return response()->json($result);
    }
}
