<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Etudiant;
use App\Models\Offre;
use App\Services\FavoriService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected FavoriService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FavoriService();
    }

    public function test_it_can_add_an_offer_to_favorites()
    {
        $etudiant = Etudiant::first();
        $offre = Offre::first();

        // Detach first to ensure a clean state
        $etudiant->favoris()->detach($offre->id);

        $result = $this->service->toggle($etudiant->user_id, $offre->id);

        $this->assertTrue($result['attached']);
        $this->assertDatabaseHas('favoris', [
            'etudiant_id' => $etudiant->user_id,
            'offre_id' => $offre->id
        ]);
    }

    public function test_it_can_remove_an_offer_from_favorites()
    {
        $etudiant = Etudiant::first();
        $offre = Offre::first();

        // Ensure it's attached first
        $etudiant->favoris()->syncWithoutDetaching([$offre->id]);

        $result = $this->service->toggle($etudiant->user_id, $offre->id);

        $this->assertTrue($result['detached']);
        $this->assertDatabaseMissing('favoris', [
            'etudiant_id' => $etudiant->user_id,
            'offre_id' => $offre->id
        ]);
    }

    public function test_it_can_list_etudiant_favorites()
    {
        $etudiant = Etudiant::first();
        $result = $this->service->list($etudiant->user_id);

        $this->assertNotNull($result);
    }
}
