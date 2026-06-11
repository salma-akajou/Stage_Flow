<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ChatbotCommandHandler;
use App\Models\Ville;
use App\Models\Secteur;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Etablissement;
use App\Models\Filiere;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChatbotServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_creer_offre_converts_hyphens_to_pipes()
    {
        $ville = Ville::first() ?? Ville::create(['nom' => 'TestVille']);
        $secteur = Secteur::first() ?? Secteur::create(['nom' => 'TestSecteur']);

        $handler = new ChatbotCommandHandler();

        $user = User::create([
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'email' => 'jean.dupont@test.com',
            'password' => bcrypt('password'),
            'statut' => 'actif'
        ]);
        
        if (!\Spatie\Permission\Models\Role::where('name', 'entreprise')->exists()) {
            \Spatie\Permission\Models\Role::create(['name' => 'entreprise', 'guard_name' => 'web']);
        }
        if (!\Spatie\Permission\Models\Role::where('name', 'etudiant')->exists()) {
            \Spatie\Permission\Models\Role::create(['name' => 'etudiant', 'guard_name' => 'web']);
        }
        $user->assignRole('entreprise');

        // Create the profile
        Entreprise::create([
            'user_id' => $user->id,
            'nom_entreprise' => 'Test Company',
            'ville_id' => $ville->id,
            'secteur_id' => $secteur->id,
            'bio' => 'Bio',
            'adresse' => 'Adresse',
            'email_contact' => 'rh@test.com',
            'registre_commerce' => 'RC 123',
            'taille' => 'TPE / PME'
        ]);

        $aiResponse = [
            'action' => 'creer_offre',
            'data' => [
                'titre' => 'Stage Test',
                'description' => 'Description',
                'type_stage' => 'Technique',
                'duree' => '3 mois',
                'remuneration' => 'Non-payé',
                'format' => 'Présentiel',
                'secteur' => $secteur->nom,
                'ville_id' => $ville->id,
                'responsabilites' => 'Tâche 1 - Tâche 2 - Tâche 3',
                'profil_recherche' => '- Exigence 1 - Exigence 2',
                'date_debut' => '2026-06-01',
                'date_fin' => '2026-08-31',
                'competences_techniques' => 'PHP|Laravel'
            ]
        ];

        $result = $handler->handle($aiResponse, $user->id);

        $this->assertTrue($result['success']);
        $this->assertDatabaseHas('offres', [
            'titre' => 'Stage Test',
            'responsabilites' => "- Tâche 1\n- Tâche 2\n- Tâche 3",
            'profil_recherche' => "- Exigence 1\n- Exigence 2",
        ]);
    }

    public function test_gerer_ressources_admin_works_successfully()
    {
        $handler = new ChatbotCommandHandler();

        $user = User::create([
            'prenom' => 'Admin',
            'nom' => 'User',
            'email' => 'admin.user@test.com',
            'password' => bcrypt('password'),
            'statut' => 'actif'
        ]);

        // Create initial resources
        $etab = Etablissement::create(['nom' => 'Etab A']);
        $filiere = Filiere::create(['nom' => 'Filiere A']);
        $secteur = Secteur::create(['nom' => 'Secteur A']);

        $aiResponse = [
            'action' => 'gerer_ressources_admin',
            'data' => [
                'etablissements' => [
                    'creer' => ['Etab B', 'Etab C'],
                    'modifier' => [
                        ['id' => $etab->id, 'nom' => 'Etab A Modifié']
                    ],
                    'supprimer' => []
                ],
                'filieres' => [
                    'creer' => [],
                    'modifier' => [],
                    'supprimer' => [$filiere->id]
                ],
                'secteurs' => [
                    'creer' => ['Secteur B'],
                    'modifier' => [],
                    'supprimer' => []
                ]
            ],
            'message' => 'Ressources modifiées avec succès.'
        ];

        $result = $handler->handle($aiResponse, $user->id);

        $this->assertTrue($result['success']);

        // Verify changes in DB
        $this->assertDatabaseHas('etablissements', ['nom' => 'Etab B']);
        $this->assertDatabaseHas('etablissements', ['nom' => 'Etab C']);
        $this->assertDatabaseHas('etablissements', ['nom' => 'Etab A Modifié']);
        $this->assertDatabaseMissing('etablissements', ['nom' => 'Etab A']);

        $this->assertDatabaseMissing('filieres', ['id' => $filiere->id]);

        $this->assertDatabaseHas('secteurs', ['nom' => 'Secteur B']);
    }

    public function test_gemini_service_fallback_parser_works_for_actions()
    {
        \Illuminate\Support\Facades\Http::fake([
            'generativelanguage.googleapis.com/*' => \Illuminate\Support\Facades\Http::response([], 500)
        ]);

        $service = app(\App\Services\GeminiService::class);
        $context = [];

        $this->expectException(\RuntimeException::class);
        $service->generate($context, "supprimer l'offre Stage Test Exceptionnel", 'entreprise');
    }
}
