<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Feedback;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected DashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DashboardService();
    }

    public function test_it_can_get_landing_stats()
    {
        $stats = $this->service->getLandingStats();

        $this->assertArrayHasKey('partenaires', $stats);
        $this->assertArrayHasKey('offres_an', $stats);
        $this->assertArrayHasKey('etudiants', $stats);
        $this->assertArrayHasKey('satisfaction', $stats);
        $this->assertGreaterThan(0, $stats['partenaires']);
        $this->assertGreaterThan(0, $stats['etudiants']);
    }

    public function test_it_can_get_etudiant_stats()
    {
        $etudiant = Etudiant::first();
        $stats = $this->service->getEtudiantStats($etudiant->user_id);

        $this->assertArrayHasKey('candidatures', $stats);
        $this->assertArrayHasKey('vues', $stats);
        $this->assertArrayHasKey('retenues', $stats);
        $this->assertArrayHasKey('favoris', $stats);
    }

    public function test_it_can_get_entreprise_stats()
    {
        $entreprise = Entreprise::first();
        $stats = $this->service->getEntrepriseStats($entreprise->user_id);

        $this->assertArrayHasKey('offres', $stats);
        $this->assertArrayHasKey('candidatures_recues', $stats);
        $this->assertArrayHasKey('en_attente', $stats);
        $this->assertArrayHasKey('vues_offres', $stats);
    }

    public function test_it_can_get_admin_stats()
    {
        $stats = $this->service->getAdminStats();

        $this->assertArrayHasKey('total_utilisateurs', $stats);
        $this->assertArrayHasKey('total_offres', $stats);
        $this->assertArrayHasKey('total_commentaires', $stats);
        $this->assertArrayHasKey('total_candidatures', $stats);
        $this->assertArrayHasKey('repartition_users', $stats);
        $this->assertGreaterThan(0, $stats['total_utilisateurs']);
    }

    public function test_satisfaction_is_calculated_from_validated_feedbacks()
    {
        $stats = $this->service->getLandingStats();
        $avg = Feedback::where('valide', true)->avg('note') ?? 0;

        $this->assertEquals(round($avg, 2), round($stats['satisfaction'], 2));
    }
}
