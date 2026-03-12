<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\Ville;
use App\Models\User;

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
                Offre::create([
                    'titre' => $data['titre'],
                    'description' => $data['description'],
                    'type_stage' => $data['type_stage'],
                    'duree' => $data['duree'],
                    'remuneration' => $data['remuneration'],
                    'format' => $data['format'],
                    'secteur' => $data['secteur'],
                    'ville_id' => $ville ? $ville->id : 1,
                    'responsabilites' => $data['responsabilites'],
                    'profil_recherche' => $data['profil_recherche'],
                    'status' => $data['status'],
                    'date_debut' => $data['date_debut'],
                    'date_fin' => $data['date_fin'],
                    'entreprise_id' => $user->id,
                ]);
            }
        }
    }
}
