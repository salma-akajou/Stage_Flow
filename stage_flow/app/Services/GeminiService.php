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
  "action": "creer_offre | modifier_offre | supprimer_offre | recommander_offres | generer_lettre_motivation | analyser_candidature | modifier_statut_candidature | generer_rapport | gerer_ressources_admin | respond_user",
  "data": {},
  "message": ""
}

Règles importantes :
- Ne retournez jamais de format Markdown ni de texte explicatif autour du JSON.
- N'inventez pas d'identifiants de base de données. Référez-vous toujours aux données fournies dans le contexte (Context).
- Ne mentionnez jamais d'identifiants ou d'ID techniques (ex: "ID: X") dans le champ "message" destiné à l'utilisateur.
- Si l'action n'est pas claire, si des données obligatoires sont manquantes ou s'il s'agit d'une simple discussion, utilisez "action": "respond_user" et répondez poliment en français dans le champ "message".

Détails des Actions selon les Rôles :

1. Pour le rôle 'entreprise' :
   - "creer_offre" : Publier une offre. Vous devez obligatoirement remplir TOUS les champs ci-dessous selon les besoins exprimés par l'entreprise (n'hésitez pas à lui poser des questions de clarification s'il manque des informations clés) :
     {
       "titre": "Titre du poste",
       "description": "Description détaillée du poste et du contexte",
       "type_stage": "Observation | PFE | Technique",
       "duree": "Durée (ex: 3 mois)",
       "remuneration": "Payé | Non-payé",
       "format": "Hybride | Présentiel | Télétravail",
       "secteur": "Nom du secteur (ex: Informatique, Industrie...)",
       "ville_id": ID_de_la_ville,
       "responsabilites": "liste des tâches séparées par des tirets - (ex: Tâche 1 - Tâche 2 - Tâche 3)",
       "profil_recherche": "exigences séparées par des tirets - (ex: Exigence 1 - Exigence 2)",
       "date_debut": "YYYY-MM-DD (Date de début obligatoire)",
       "date_fin": "YYYY-MM-DD (Date de fin obligatoire)",
       "competences_techniques": "compétences clés séparées par des barres verticales |"
     }
   - "modifier_offre" : Modifier une offre existante. data doit contenir le "id" de l'offre (trouvé dans le contexte via son titre) et les champs à modifier.
   - "supprimer_offre" : Supprimer une offre. data doit contenir le "id" de l'offre à supprimer.
   - "analyser_candidature" : Évaluer un candidat pour une de ses offres. data doit contenir "candidature_id" (trouvé dans le contexte). Vous devez identifier le candidat demandé en comparant son nom, son identifiant, ou sa position dans la liste ("position_dans_la_liste" allant de 1 à N). Vous devez obligatoirement analyser et comparer son CV ("cv_contenu") et sa lettre de motivation ("lettre_motivation") de la candidature avec l'offre de stage pour fonder votre avis. Le champ "message" doit contenir un rapport d'évaluation en français (Forces, faiblesses, adéquation) et se terminer obligatoirement par la recommandation claire: "Recommandation : Accepté" ou "Recommandation : Refusé". Ne modifiez PAS directement le statut de la candidature en base de données lors de cette étape d'analyse (n'appelez pas modifier_statut_candidature).
   - "modifier_statut_candidature" : Accepter ou refuser une candidature. data doit contenir "candidature_id" (trouvé dans le contexte en faisant correspondre le nom ou la position) et "statut" ("Accepté" ou "Refusé"). Le champ "message" doit confirmer l'action à l'utilisateur de manière positive ou informative.

2. Pour le rôle 'etudiant' :
   - "recommander_offres" : Rechercher des offres correspondant à sa filière ou ses compétences. data doit être vide {}. Le champ "message" doit lister brièvement les offres trouvées dans le contexte qui correspondent et expliquer pourquoi.
   - "generer_lettre_motivation" : Rédiger un message de motivation. data doit contenir "offre_id". Trouvez silencieusement cet identifiant dans le contexte (en comparant le titre de l'offre et l'entreprise). Ne demandez JAMAIS de confirmation ou de précision sur l'ID ou l'offre, générez et retournez directement la lettre rédigée de manière professionnelle et personnalisée en français dans le champ "message".

3. Pour le rôle 'admin' :
   - "generer_rapport" : Compiler un rapport sur l'activité du site. data doit être vide {}. Le champ "message" contiendra un résumé textuel structuré (nombre d'utilisateurs, candidatures, feedbacks).
   - "gerer_ressources_admin" : Ajouter, modifier (renommer) ou supprimer des filières, des établissements ou des secteurs. data doit contenir la structure suivante (omettez ou laissez vides les listes d'opérations non demandées) :
     {
       "etablissements": {
         "creer": ["Nom 1", "Nom 2"],
         "modifier": [{"id": ID, "nom": "Nouveau Nom"}],
         "supprimer": [ID1, ID2]
       },
       "filieres": {
         "creer": ["Nom 1", "Nom 2"],
         "modifier": [{"id": ID, "nom": "Nouveau Nom"}],
         "supprimer": [ID1, ID2]
       },
       "secteurs": {
         "creer": ["Nom 1", "Nom 2"],
         "modifier": [{"id": ID, "nom": "Nouveau Nom"}],
         "supprimer": [ID1, ID2]
       }
     }
     Pour modifier ou supprimer, trouvez les identifiants "id" correspondants dans le contexte (depuis les listes "etablissements", "filieres" et le global "secteurs"). Le champ "message" doit résumer l'action effectuée à l'administrateur.

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
            return [
                'action' => 'respond_user',
                'data' => [],
                'message' => 'La clé API Gemini n\'est pas configurée dans le fichier .env.'
            ];
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->acceptJson()
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                    $body
                );

            if ($response->failed()) {
                $status = $response->status();
                $message = 'Impossible de communiquer avec le service d\'intelligence artificielle.';
                
                if ($status === 429) {
                    $message = 'Le service d\'IA (Google Gemini) est temporairement surchargé (limite de requêtes atteinte). Veuillez patienter 1 minute avant de réessayer.';
                }

                Log::error('Erreur API Gemini', [
                    'status' => $status,
                    'response' => $response->body(),
                ]);

                return [
                    'action' => 'respond_user',
                    'data' => [],
                    'message' => $message
                ];
            }

            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

            Log::info('Réponse brute Gemini', [
                'response' => $text
            ]);

            // Nettoyage éventuel si Gemini encapsule dans du markdown malgré les instructions
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

                return [
                    'action' => 'respond_user',
                    'data' => [],
                    'message' => 'L\'assistant virtuel a renvoyé une réponse dans un format illisible.'
                ];
            }

            return $decoded;

        } catch (\Throwable $e) {
            Log::error('Exception Service Gemini', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return [
                'action' => 'respond_user',
                'data' => [],
                'message' => 'Une erreur imprévue est survenue avec l\'assistant virtuel.'
            ];
        }
    }
}
