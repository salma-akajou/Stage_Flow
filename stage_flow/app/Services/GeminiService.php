<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function generate(array $context, string $message, string $role): array
    {
        $systemPrompt = <<<PROMPT
Vous êtes l'assistant virtuel intelligent de StageFlow, une plateforme de gestion des stages.
Votre rôle est d'analyser la requête de l'utilisateur (dont le rôle actuel est : {$role}) et de décider de l'action appropriée à effectuer.

Retournez UNIQUEMENT un objet JSON valide, sans blocs de code markdown (pas de ```json ... ```), avec le schéma suivant :
{
  "action": "creer_offre | modifier_offre | supprimer_offre | recommander_offres | generer_lettre_motivation | analyser_candidature | generer_rapport | gerer_ressources_admin | respond_user",
  "data": {},
  "message": ""
}

Règles importantes :
- Ne retournez jamais de format Markdown ni de texte explicatif autour du JSON.
- N'inventez pas d'identifiants de base de données. Référez-vous toujours aux données fournies dans le contexte (Context).
- Si l'action n'est pas claire, si des données obligatoires sont manquantes ou s'il s'agit d'une simple discussion, utilisez "action": "respond_user" et répondez poliment en français dans le champ "message".
- Pour l'action "creer_offre", si l'utilisateur ne fournit pas explicitement tous les détails de l'offre (titre, description, type_stage, duree, remuneration, format, secteur, ville, responsabilites, profil_recherche, date_debut, date_fin, competences_techniques), n'inventez PAS ces détails. Retournez l'action "respond_user" et demandez poliment à l'utilisateur de fournir les informations manquantes.

Détails des Actions selon les Rôles :

1. Pour le rôle 'entreprise' :
   - "creer_offre" : Publier une offre (uniquement si toutes les informations sont explicitement fournies). data doit contenir :
     {
       "titre": "Titre",
       "description": "Description",
       "type_stage": "Observation | PFE | Technique",
       "duree": "Ex: 3 mois",
       "remuneration": "Payé | Non-payé",
       "format": "Hybride | Présentiel | Télétravail",
       "secteur": "Nom du secteur (ex: Informatique, Industrie...)",
       "ville": "Nom de la ville (ex: Tanger, Casablanca...)",
       "responsabilites": "liste des tâches sous forme de tirets (ex: - tâche 1\\n- tâche 2)",
       "profil_recherche": "exigences sous forme de tirets (ex: - exigence 1\\n- exigence 2)",
       "date_debut": "YYYY-MM-DD (obligatoire)",
       "date_fin": "YYYY-MM-DD (obligatoire)",
       "competences_techniques": "compétences clés sous forme de tirets (ex: - compétence 1\\n- compétence 2)"
     }
   - "modifier_offre" : Modifier une offre existante. data doit contenir le "titre_original" de l'offre à modifier (trouvé dans le contexte) et les champs à modifier.
   - "supprimer_offre" : Supprimer une offre. data doit contenir le "titre" de l'offre à supprimer (trouvé dans le contexte).
   - "analyser_candidature" : Évaluer un candidat par son nom complet. data doit contenir "candidat_nom" (trouvé dans le contexte). Le champ "message" doit contenir un rapport d'évaluation structuré en français (Forces, faiblesses, adéquation). Le "Conseil final" doit obligatoirement être et s'écrire uniquement "Conseil final : Accepté" ou "Conseil final : Refusé", sans aucun paragraphe ou mot d'explication supplémentaire.

2. Pour le rôle 'etudiant' :
   - "recommander_offres" : Rechercher des offres correspondant à sa filière ou ses compétences. data doit être vide {}. Le champ "message" doit lister et recommander les offres du contexte uniquement selon leurs caractéristiques (sans mentionner ou chercher leurs IDs).
   - "generer_lettre_motivation" : Rédiger un message de motivation. data doit contenir "offre_titre" (trouvé dans le contexte). Le champ "message" doit contenir la lettre rédigée de manière professionnelle et personnalisée en français.

3. Pour le rôle 'admin' :
   - "generer_rapport" : Compiler un rapport sur l'activité du site. data doit être vide {}. Le champ "message" contiendra un résumé textuel structuré (nombre d'utilisateurs, candidatures, feedbacks).
   - "gerer_ressources_admin" : Gérer les ressources (créer, modifier, supprimer des filières, secteurs ou établissements). data doit avoir la structure suivante :
     {
       "etablissements": {
         "creer": ["Nom1", "Nom2"],
         "modifier": [{"id": ID, "nom": "NouveauNom"}],
         "supprimer": [ID1, ID2]
       },
       "filieres": {
         "creer": ["Nom1"],
         "modifier": [{"id": ID, "nom": "NouveauNom"}],
         "supprimer": [ID1]
       },
       "secteurs": {
         "creer": ["Nom1"],
         "modifier": [{"id": ID, "nom": "NouveauNom"}],
         "supprimer": [ID1]
       }
     }
     (Retrouvez les IDs requis pour les modifications ou suppressions dans le contexte).

4. Pour le rôle 'guest' (visiteur de la landing page) :
   - Toujours retourner "action": "respond_user" et répondre en français dans "message" aux questions sur la plateforme à l'aide des informations publiques du contexte.
PROMPT;

        $body = [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $systemPrompt
                        ],
                        [
                            "text" => "Context actuel du site :\n" . json_encode(
                                $context,
                                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                            )
                        ],
                        [
                            "text" => "Message de l'utilisateur :\n" . $message
                        ]
                    ]
                ]
            ],
            "generationConfig" => [
                "responseMimeType" => "application/json",
                "temperature" => 0.15,
            ]
        ];

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-2.5-flash');

        if (!$apiKey) {
            throw new \RuntimeException("Clé API Gemini non configurée.");
        }

        $maxRetries = 3;
        $attempt = 0;
        $response = null;

        while ($attempt < $maxRetries) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(12)
                    ->acceptJson()
                    ->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                        $body
                    );

                if ($response->successful()) {
                    break;
                }

                if ($response->status() === 503) {
                    Log::warning("Gemini 503 error, retrying...", ['attempt' => $attempt + 1]);
                    $attempt++;
                    if ($attempt < $maxRetries) {
                        usleep(1000000 * $attempt); // Attendre 1s puis 2s
                        continue;
                    }
                }

                break;
            } catch (\Throwable $e) {
                Log::warning("Gemini exception during call, retrying...", ['attempt' => $attempt + 1, 'error' => $e->getMessage()]);
                $attempt++;
                if ($attempt >= $maxRetries) {
                    Log::error('Exception Service Gemini finale', [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ]);
                    throw new \RuntimeException("Exception de connexion Gemini : " . $e->getMessage());
                }
                usleep(1000000 * $attempt);
            }
        }

        if (!$response || $response->failed()) {
            Log::error('Erreur API Gemini finale', [
                'status' => $response ? $response->status() : 'No response',
                'response' => $response ? $response->body() : 'No body',
            ]);
            $status = $response ? $response->status() : 'inconnu';
            throw new \RuntimeException("L'appel API Gemini a échoué avec le statut {$status}.");
        }

        try {
            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

            Log::info('Réponse brute Gemini', [
                'response' => $text
            ]);

            $text = trim($text);
            if (str_starts_with($text, '```json')) {
                $text = substr($text, 7);
            }
            if (str_starts_with($text, '```')) {
                $text = substr($text, 3);
            }
            if (str_ends_with($text, '```')) {
                $text = substr($text, 0, -3);
            }
            $text = trim($text);

            $decoded = json_decode($text, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Gemini invalide', [
                    'json_error' => json_last_error_msg(),
                    'response' => $text
                ]);
                throw new \RuntimeException("La réponse générée par l'IA n'est pas un JSON valide.");
            }

            return $decoded;

        } catch (\Throwable $e) {
            Log::error('Exception Service Gemini traitement', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw new \RuntimeException("Erreur lors du traitement de la réponse Gemini : " . $e->getMessage());
        }
    }
}
