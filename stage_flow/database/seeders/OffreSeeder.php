<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\Ville;
use App\Models\User;
use App\Models\Secteur;
use App\Models\Competence;

class OffreSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/offres.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            $user = User::where('email', $data['company_email'])->first();
            $ville = Ville::where('nom', $data['ville_nom'])->first();

            if ($user && $user->entreprise) {
                // Find or create Secteur
                $secteurNom = $data['secteur'];
                $secteur = Secteur::where('nom', 'like', '%' . $secteurNom . '%')->first()
                    ?? Secteur::firstOrCreate(['nom' => $secteurNom]);

                $offre = Offre::create([
                    'titre' => $data['titre'],
                    'description' => $data['description'],
                    'type_stage' => $data['type_stage'],
                    'duree' => $data['duree'],
                    'remuneration' => $data['remuneration'],
                    'format' => $data['format'],
                    'secteur_id' => $secteur->id,
                    'ville_id' => $ville ? $ville->id : 1,
                    'responsabilites' => $data['responsabilites'],
                    'profil_recherche' => $data['profil_recherche'],
                    'status' => $data['status'],
                    'date_debut' => $data['date_debut'],
                    'date_fin' => $data['date_fin'],
                    'entreprise_id' => $user->id,
                ]);

                // Seed competences Many-to-Many
                $compString = $data['competences_techniques'] ?? '';
                if (!empty($compString)) {
                    $compNames = explode('|', $compString);
                    foreach ($compNames as $compName) {
                        $compName = trim($compName);
                        if (!empty($compName)) {
                            $compModel = Competence::firstOrCreate(['nom' => $compName]);
                            $offre->competences()->attach($compModel->id);
                        }
                    }
                }
            }
        }
    }
}
