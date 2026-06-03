<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Secteur;


class SecteurSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/secteurs.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            Secteur::firstOrCreate(['nom' => $data['nom']]);
        }
    }
}
