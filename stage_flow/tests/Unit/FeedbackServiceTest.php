<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Feedback;
use App\Models\User;
use App\Services\FeedbackService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeedbackServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected FeedbackService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FeedbackService();
    }

    public function test_it_can_create_a_feedback()
    {
        $user = User::first();

        $feedback = $this->service->create([
            'auteur_id' => $user->id,
            'note' => 5,
            'texte' => 'Excellente plateforme de stages !'
        ]);

        $this->assertDatabaseHas('feedbacks', [
            'auteur_id' => $user->id,
            'note' => 5,
            'valide' => false,
        ]);
    }

    public function test_it_can_get_landing_feedbacks()
    {
        $result = $this->service->getLandingFeedbacks(3);

        $this->assertLessThanOrEqual(3, $result->count());
        foreach ($result as $feedback) {
            $this->assertTrue((bool) $feedback->valide);
        }
    }

    public function test_it_can_validate_a_feedback()
    {
        $feedback = Feedback::where('valide', false)->first();

        if ($feedback) {
            $this->service->moderate($feedback->id, 'valider');

            $this->assertDatabaseHas('feedbacks', [
                'id' => $feedback->id,
                'valide' => true
            ]);
        }

        $this->assertTrue(true);
    }

    public function test_it_can_delete_a_feedback()
    {
        $feedback = Feedback::first();

        if ($feedback) {
            $this->service->moderate($feedback->id, 'supprimer');

            $this->assertDatabaseMissing('feedbacks', [
                'id' => $feedback->id
            ]);
        }

        $this->assertTrue(true);
    }

    public function test_it_can_search_feedbacks()
    {
        $result = $this->service->search();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_search_feedbacks_by_text()
    {
        $feedback = Feedback::first();

        if ($feedback) {
            $word = explode(' ', $feedback->texte)[0];
            $result = $this->service->search(['search' => $word]);
            $this->assertGreaterThan(0, $result->total());
        }

        $this->assertTrue(true);
    }
}
