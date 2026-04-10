<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\User;
use App\Services\UtilisateurService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UtilisateurServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected UtilisateurService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new UtilisateurService();
    }

    public function test_it_can_list_all_users()
    {
        $result = $this->service->listUsers();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_search_user_by_name()
    {
        $user = User::first();

        $result = $this->service->listUsers([
            'search' => $user->nom
        ]);

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_delete_a_user()
    {
        // Create a standalone user with no linked etudiant or entreprise
        $user = User::create([
            'prenom' => 'Test',
            'nom'    => 'Delete',
            'email'  => 'delete_test_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->service->deleteUser($user->id);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
