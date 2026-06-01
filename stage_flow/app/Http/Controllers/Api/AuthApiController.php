<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthApiController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Enregistre un nouvel étudiant et retourne le token Sanctum
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->registerStudent($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Inscription réussie',
                'data'    => [
                    'token'   => $result['token'],
                    'student' => [
                        'user_id' => $result['user']->id,
                        'nom'     => $result['user']->nom,
                        'prenom'  => $result['user']->prenom,
                        'email'   => $result['user']->email,
                        'avatar'  => $result['user']->etudiant->photo ?? null,
                    ],
                ],
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Registration API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'inscription.'
            ], 500);
        }
    }

    /**
     * Authentifie l'utilisateur (étudiant) et retourne le token Sanctum
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $result = $this->authService->loginStudent($credentials);

            return response()->json([
                'success' => true,
                'data'    => [
                    'token'   => $result['token'],
                    'student' => [
                        'user_id' => $result['user']->id,
                        'nom'     => $result['user']->nom,
                        'prenom'  => $result['user']->prenom,
                        'email'   => $result['user']->email,
                        'avatar'  => $result['user']->avatar_url,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            $code = $e->getCode();
            $statusCode = in_array($code, [401, 403]) ? $code : 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * Déconnecte l'utilisateur et révoque son token Sanctum
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Déconnecté avec succès'
        ]);
    }
}
