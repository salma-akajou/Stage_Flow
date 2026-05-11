<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Offre;
use App\Models\Etudiant;

class FavoriSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/favoris.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            $user = User::where('email', $data['etudiant_email'])->first();
            $offre = Offre::where('titre', $data['offer_title'])->first();

            if ($user && $user->etudiant && $offre) {
                $user->etudiant->favoris()->syncWithoutDetaching([$offre->id => ['date_ajout' => now()]]);
            }
        }
    }
}
