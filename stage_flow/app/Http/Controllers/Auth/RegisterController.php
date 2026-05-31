<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Ville;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    use RegistersUsers;

    /**
     * Handle a registration request for the application.
     */
    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    public function showRegistrationForm()
    {
        $villes = Ville::all();
        return view('auth.register', compact('villes'));
    }

    protected function redirectTo()
    {
        $role = auth()->user()->getRoleNames()->first();
        
        return match ($role) {
            'admin' => '/admin/dashboard',
            'etudiant' => '/student/dashboard',
            'entreprise' => '/entreprise/dashboard',
            default => '/home',
        };
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Création du User
            $user = User::create([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // 2. Assignation du rôle Spatie
            $user->assignRole($data['role']);

            // 3. Création du profil spécifique
            if ($data['role'] === 'etudiant') {
                $photoPath = isset($data['photo']) ? $data['photo']->store('avatars', 'public') : null;
                
                Etudiant::create([
                    'user_id' => $user->id,
                    'ville_id' => $data['ville_id'],
                    'etablissement' => $data['etablissement'],
                    'filiere' => $data['filiere'],
                    'niveau_etudes' => $data['niveau_etude'],
                    'photo' => $photoPath,
                    'bio' => $data['bio_etudiant'] ?? null,
                    'github' => $data['github'] ?? null,
                    'linkedin' => $data['linkedin'] ?? null,
                ]);
            } else {
                $logoPath = isset($data['logo']) ? $data['logo']->store('logos', 'public') : null;

                Entreprise::create([
                    'user_id' => $user->id,
                    'nom_entreprise' => $data['nom_entreprise'],
                    'secteur' => $data['secteur'],
                    'ville_id' => $data['ville_id'],
                    'adresse' => $data['adresse'],
                    'email_contact' => $data['email_contact'],
                    'logo' => $logoPath,
                    'registre_commerce' => $data['registre_commerce'],
                    'bio' => $data['bio_entreprise'] ?? null,
                    'taille' => $data['taille'],
                ]);
            }

            return $user;
        });
    }
}
