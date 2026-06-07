<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filiere;


class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/filieres.csv');
        if (!file_exists($file)) return;

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (empty($row) || count($row) !== count($header) || trim($row[0]) === '') continue;
            $data = array_combine($header, $row);
            if (!empty($data['nom'])) {
                Filiere::firstOrCreate(['nom' => $data['nom']]);
            }
        }
    }
}
