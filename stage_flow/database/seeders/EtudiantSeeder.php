<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Ville;
use Illuminate\Support\Facades\Hash;

class EtudiantSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/etudiants.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (count($row) !== count($header)) continue;
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

            Etudiant::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'ville_id' => $ville ? $ville->id : 1,
                    'etablissement' => $data['etablissement'],
                    'filiere' => $data['filiere'],
                    'niveau_etudes' => $data['niveau_etudes'],
                    'photo' => $data['photo'] ?? null,
                    'bio' => $data['bio'],
                    'vues' => $data['vues'] ?? 0,
                ]
            );
        }
    }
}
