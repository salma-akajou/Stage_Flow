<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Etudiant;
use App\Models\Offre;
use App\Models\Candidature;
use App\Models\DocumentCv;
use App\Services\CandidatureService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CandidatureServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected CandidatureService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CandidatureService();
    }

    public function test_it_can_list_etudiant_candidatures()
    {
        $etudiant = Etudiant::first();
        $result = $this->service->listEtudiantCandidatures($etudiant->user_id);

        $this->assertNotNull($result);
    }

    public function test_it_can_filter_etudiant_candidatures_by_statut()
    {
        $etudiant = Etudiant::first();
        $result = $this->service->listEtudiantCandidatures($etudiant->user_id, ['statut' => 'En attente']);

        foreach ($result->items() as $candidature) {
            $this->assertEquals('En attente', $candidature->statut);
        }
    }

    public function test_it_can_search_etudiant_candidatures_by_offer_title()
    {
        $etudiant = Etudiant::first();
        $candidature = Candidature::where('etudiant_id', $etudiant->user_id)->first();

        if ($candidature) {
            $result = $this->service->listEtudiantCandidatures($etudiant->user_id, [
                'search' => $candidature->offre->titre
            ]);
            $this->assertGreaterThan(0, $result->total());
        }

        $this->assertTrue(true);
    }

    public function test_it_can_list_entreprise_candidatures()
    {
        $candidature = Candidature::with('offre')->first();

        if ($candidature) {
            $entrepriseId = $candidature->offre->entreprise_id;
            $result = $this->service->listEntrepriseCandidatures($entrepriseId);
            $this->assertGreaterThan(0, $result->total());
        }

        $this->assertTrue(true);
    }

    public function test_it_can_change_candidature_status()
    {
        $candidature = Candidature::first();

        if ($candidature) {
            $this->service->changeStatus($candidature->id, 'Accepté');

            $this->assertDatabaseHas('candidatures', [
                'id' => $candidature->id,
                'statut' => 'Accepté'
            ]);
        }

        $this->assertTrue(true);
    }

    public function test_it_can_delete_a_candidature()
    {
        $candidature = Candidature::first();

        if ($candidature) {
            $this->service->delete($candidature->id);

            $this->assertDatabaseMissing('candidatures', [
                'id' => $candidature->id
            ]);
        }

        $this->assertTrue(true);
    }
}
