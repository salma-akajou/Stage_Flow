<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VilleSeeder::class,
            EtudiantSeeder::class,
            EntrepriseSeeder::class,
            OffreSeeder::class,
            DocumentCvSeeder::class,
            CandidatureSeeder::class,
            FeedbackSeeder::class,
            FavoriSeeder::class,
        ]);
    }
}
