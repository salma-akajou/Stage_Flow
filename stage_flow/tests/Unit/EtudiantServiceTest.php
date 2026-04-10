<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Etudiant;
use App\Models\User;
use App\Services\EtudiantService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EtudiantServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected EtudiantService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EtudiantService();
    }

    public function test_it_can_update_etudiant_profile()
    {
        $etudiant = Etudiant::first();

        $this->service->updateProfile($etudiant->user_id, [
            'bio' => 'Nouvelle bio mise à jour par le test.'
        ]);

        $this->assertDatabaseHas('etudiants', [
            'user_id' => $etudiant->user_id,
            'bio' => 'Nouvelle bio mise à jour par le test.'
        ]);
    }

    public function test_it_can_update_etudiant_photo()
    {
        Storage::fake('public');

        $etudiant = Etudiant::first();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->service->updateProfile($etudiant->user_id, [
            'photo' => $file
        ]);

        $etudiant->refresh();

        // Vérifie que le champ photo n'est pas nul
        $this->assertNotNull($etudiant->photo);
        
        // Vérifie le chemin de stockage
        $this->assertStringContainsString('photos/students/', $etudiant->photo);

        // Vérifie que le fichier existe physiquement
        Storage::disk('public')->assertExists($etudiant->photo);
    }

    public function test_it_can_increment_etudiant_views()
    {
        $etudiant = Etudiant::first();
        $vuesAvant = $etudiant->vues;

        $this->service->incrementViews($etudiant->user_id);

        $this->assertDatabaseHas('etudiants', [
            'user_id' => $etudiant->user_id,
            'vues' => $vuesAvant + 1
        ]);
    }
}
