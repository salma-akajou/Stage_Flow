<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Offre;
use App\Models\DocumentCv;
use App\Models\Candidature;

class CandidatureSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/candidatures.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            $user = User::where('email', $data['etudiant_email'])->first();
            $offre = Offre::where('titre', $data['offer_title'])->first();
            $cv = DocumentCv::where('file_path', $data['cv_path'])->first();

            if ($user && $user->etudiant && $offre && $cv) {
                Candidature::create([
                    'statut' => $data['statut'],
                    'telephone' => $data['telephone'],
                    'photo' => $data['photo'] ?? null,
                    'portfolio_url' => $data['portfolio_url'] ?? null,
                    'message_motivation' => $data['message_motivation'],
                    'date_postulation' => now(),
                    'etudiant_id' => $user->id,
                    'offre_id' => $offre->id,
                    'cv_id' => $cv->id,
                ]);
            }
        }
    }
}
