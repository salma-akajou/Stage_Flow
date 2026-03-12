<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Ville;
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

            $ville = Ville::where('nom', $data['ville_nom'])->first();

            Entreprise::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nom_entreprise' => $data['nom_entreprise'],
                    'secteur' => $data['secteur'],
                    'ville_id' => $ville ? $ville->id : 1,
                    'adresse' => $data['adresse'],
                    'email_contact' => $data['email_contact'],
                    'bio' => $data['bio'],
                    'registre_commerce' => $data['registre_commerce'],
                    'taille' => $data['taille'],
                ]
            );
        }
    }
}
