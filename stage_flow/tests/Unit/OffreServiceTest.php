<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\Ville;
use App\Services\OffreService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OffreServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected OffreService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OffreService();
    }

    public function test_it_can_get_all_offers()
    {
        $result = $this->service->search();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_offers_by_title()
    {
        $offre = Offre::first();
        $result = $this->service->search([
            'titre' => $offre->titre
        ]);

        $this->assertGreaterThan(0, $result->total());
        $this->assertEquals($offre->titre, $result->first()->titre);
    }

    public function test_it_can_get_offer_details()
    {
        $offre = Offre::first();
        $result = $this->service->getDetails($offre->id);

        $this->assertEquals($offre->id, $result->id);
        $this->assertNotNull($result->entreprise);
    }

    public function test_it_can_create_an_offer()
    {
        $entreprise = Entreprise::first();
        $ville = Ville::first();

        $data = [
            'titre' => 'Nouveau Stage Test',
            'description' => 'Description de test',
            'type_stage' => 'Technique',
            'duree' => '3 mois',
            'remuneration' => 'Payé',
            'format' => 'Présentiel',
            'secteur' => 'Informatique',
            'ville_id' => $ville->id,
            'status' => 'Active',
            'entreprise_id' => $entreprise->user_id,
            'responsabilites' => 'Développer des fonctionnalités en équipe.',
            'profil_recherche' => 'Étudiant en informatique dynamique.',
            'date_debut' => now()->addDays(10),
            'date_fin' => now()->addDays(100),
        ];

        $offre = $this->service->create($data);

        $this->assertDatabaseHas('offres', [
            'titre' => 'Nouveau Stage Test',
            'entreprise_id' => $entreprise->user_id
        ]);
    }

    public function test_it_can_update_an_offer()
    {
        $offre = Offre::first();

        $this->service->update($offre->id, [
            'titre' => 'Titre Modifié'
        ]);

        $this->assertDatabaseHas('offres', [
            'id' => $offre->id,
            'titre' => 'Titre Modifié'
        ]);
    }

    public function test_it_can_delete_an_offer()
    {
        $offre = Offre::first();

        $this->service->delete($offre->id);

        $this->assertDatabaseMissing('offres', [
            'id' => $offre->id
        ]);
    }

    public function test_it_can_get_recommended_offers()
    {
        $result = $this->service->getRecommended(3);

        $this->assertGreaterThan(0, $result->count());
    }
}
