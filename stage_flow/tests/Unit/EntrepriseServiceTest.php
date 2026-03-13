<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entreprise;
use App\Services\EntrepriseService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
