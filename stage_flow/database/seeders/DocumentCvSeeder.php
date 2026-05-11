<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DocumentCv;
use App\Models\Etudiant;

class DocumentCvSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/cvs.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            $user = User::where('email', $data['etudiant_email'])->first();

            if ($user && $user->etudiant) {
                DocumentCv::firstOrCreate(
                    ['file_path' => $data['file_path']],
                    [
                        'etudiant_id' => $user->id,
                        'date_upload' => now(),
                    ]
                );
            }
        }
    }
}
