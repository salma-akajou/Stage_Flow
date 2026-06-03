<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Ville;
use App\Models\Secteur;
use Illuminate\Support\Facades\Hash;


class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/entreprises.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            // Create user first
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'prenom' => $data['prenom'],
                    'nom' => $data['nom'],
                    'password' => Hash::make($data['password']),
                ]
            );

            // Assign role
            $user->assignRole('entreprise');

            $ville = Ville::where('nom', $data['ville_nom'])->first();

            // Find or create Secteur
            $secteurNom = $data['secteur'];
            $secteur = Secteur::where('nom', 'like', '%' . $secteurNom . '%')->first()
                ?? Secteur::firstOrCreate(['nom' => $secteurNom]);

            Entreprise::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nom_entreprise' => $data['nom_entreprise'],
                    'secteur_id' => $secteur->id,
                    'ville_id' => $ville ? $ville->id : 1,
                    'adresse' => $data['adresse'],
                    'email_contact' => $data['email_contact'],
                    'bio' => $data['bio'],
                    'registre_commerce' => $data['registre_commerce'],
                    'logo' => $data['logo'] ?? null,
                    'taille' => $data['taille'],
                    'vues' => $data['vues'] ?? 0,
                ]
            );
        }
    }
}
