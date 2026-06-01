<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthService extends BaseService
{
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Enregistre un étudiant et génère un token Sanctum.
     */
    public function registerStudent(array $data): array
    {
        $user = User::registerStudent($data);
        $token = $user->createToken('mobile-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    /**
     * Authentifie l'étudiant et retourne le token Sanctum.
     */
    public function loginStudent(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw new Exception('Identifiants incorrects', 401);
        }

        $user = Auth::user();

        if ($user->role !== 'etudiant') {
            Auth::logout();
            throw new Exception('Accès réservé aux étudiants', 403);
        }

        if ($user->statut !== 'actif') {
            Auth::logout();
            throw new Exception('Votre compte est suspendu. Veuillez contacter l\'administration.', 403);
        }

        $token = $user->createToken('mobile-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    /**
     * Révoque le token de l'utilisateur connecté.
     */
    public function logoutUser($user): void
    {
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
    }
}
