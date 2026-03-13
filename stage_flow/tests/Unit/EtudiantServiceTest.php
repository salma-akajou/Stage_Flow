<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Etudiant;
use App\Services\EtudiantService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
