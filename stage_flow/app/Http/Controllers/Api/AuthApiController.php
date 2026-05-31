<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Auth\RegisterRequest;

class AuthApiController extends Controller
{
    /**
     * Enregistre un nouvel étudiant et retourne le token Sanctum
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::registerStudent($request->validated());
            $token = $user->createToken('mobile-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Inscription réussie',
                'data'    => [
                    'token'   => $token,
                    'student' => [
                        'user_id' => $user->id,
                        'nom'     => $user->nom,
                        'prenom'  => $user->prenom,
                        'email'   => $user->email,
                        'avatar'  => $user->etudiant->photo ?? null,
                    ],
                ],
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Registration API Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'inscription.'], 500);
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

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'etudiant') {
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'Accès réservé aux étudiants'], 403);
            }

            $token = $user->createToken('mobile-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'data'    => [
                    'token'   => $token,
                    'student' => [
                        'user_id' => $user->id,
                        'nom'     => $user->nom,
                        'prenom'  => $user->prenom,
                        'email'   => $user->email,
                        'avatar'  => $user->avatar_url,
                    ],
                ],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Identifiants incorrects'], 401);
    }

    /**
     * Déconnecte l'utilisateur et révoque son token Sanctum
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['success' => true, 'message' => 'Déconnecté avec succès']);
    }
}
