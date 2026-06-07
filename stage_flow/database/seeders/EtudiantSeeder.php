<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Ville;
use App\Models\Etablissement;
use App\Models\Filiere;
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
            if (empty($row) || count($row) !== count($header) || trim($row[0]) === '') continue;
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
            $user->assignRole('etudiant');

            $ville = Ville::where('nom', $data['ville_nom'])->first();

            // Find or create Etablissement
            $etablissementNom = $data['etablissement'];
            $etablissement = Etablissement::where('nom', 'like', '%' . $etablissementNom . '%')->first()
                ?? Etablissement::firstOrCreate(['nom' => $etablissementNom]);

            // Find or create Filiere
            $filiereNom = $data['filiere'];
            // Normalize "Développement Web" to "Web Full Stack" or just use whatever is in CSV or look up
            $filiere = Filiere::where('nom', 'like', '%' . $filiereNom . '%')->first()
                ?? Filiere::firstOrCreate(['nom' => $filiereNom]);

            // Map Niveau Etudes
            $niveau = $data['niveau_etudes'];
            if ($niveau === 'Master') {
                $niveau = 'Bac+5';
            } elseif ($niveau === 'Bac+2' || $niveau === 'Bac+3' || $niveau === 'Bac+5' || $niveau === 'Doctorat') {
                // Keep as is
            } else {
                $niveau = 'Bac+2'; // default fallback
            }

            Etudiant::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'ville_id' => $ville ? $ville->id : 1,
                    'etablissement_id' => $etablissement->id,
                    'filiere_id' => $filiere->id,
                    'niveau_etudes' => $niveau,
                    'photo' => $data['photo'] ?? null,
                    'bio' => $data['bio'],
                    'vues' => $data['vues'] ?? 0,
                ]
            );
        }
    }
}
