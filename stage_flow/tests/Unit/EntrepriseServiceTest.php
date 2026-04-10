<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entreprise;
use App\Models\User;
use App\Services\EntrepriseService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EntrepriseServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected EntrepriseService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EntrepriseService();
    }

    public function test_it_can_update_entreprise_profile()
    {
        $entreprise = Entreprise::first();

        $this->service->updateProfile($entreprise->user_id, [
            'bio' => 'Entreprise leader dans son domaine - test.'
        ]);

        $this->assertDatabaseHas('entreprises', [
            'user_id' => $entreprise->user_id,
            'bio' => 'Entreprise leader dans son domaine - test.'
        ]);
    }

    public function test_it_can_update_entreprise_logo()
    {
        Storage::fake('public');

        $entreprise = Entreprise::first();
        $file = UploadedFile::fake()->image('logo.png');

        $this->service->updateProfile($entreprise->user_id, [
            'logo' => $file
        ]);

        $entreprise->refresh();

        // Vérifie que le champ logo n'est pas nul
        $this->assertNotNull($entreprise->logo);
        
        // Vérifie le chemin de stockage
        $this->assertStringContainsString('logos/', $entreprise->logo);

        // Vérifie que le fichier existe physiquement
        Storage::disk('public')->assertExists($entreprise->logo);
    }

    public function test_it_can_increment_entreprise_views()
    {
        $entreprise = Entreprise::first();
        $vuesAvant = $entreprise->vues;

        $this->service->incrementViews($entreprise->user_id);

        $this->assertDatabaseHas('entreprises', [
            'user_id' => $entreprise->user_id,
            'vues' => $vuesAvant + 1
        ]);
    }
}
