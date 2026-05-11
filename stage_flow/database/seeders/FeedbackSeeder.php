<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/feedbacks.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            $user = User::where('email', $data['auteur_email'])->first();

            if ($user) {
                Feedback::create([
                    'texte' => $data['texte'],
                    'note' => $data['note'],
                    'auteur_id' => $user->id,
                    'valide' => true,
                ]);
            }
        }
    }
}
