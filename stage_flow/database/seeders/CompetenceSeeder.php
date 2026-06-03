<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Competence;

class CompetenceSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/competences.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            Competence::firstOrCreate(['nom' => $data['nom']]);
        }
    }
}
