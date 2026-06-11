<?php

namespace App\Services;

use App\Models\Offre;
use App\Models\Secteur;
use App\Models\Candidature;
use App\Models\Feedback;
use App\Models\Ville;
use App\Models\Etablissement;
use App\Models\Filiere;

class ChatbotCommandHandler
{
    public function handle(array $aiResponse, int $userId): array
    {
        $action = $aiResponse['action'] ?? 'respond_user';
        $data = $aiResponse['data'] ?? [];
        $message = $aiResponse['message'] ?? '';

        switch ($action) {
            case 'creer_offre':
                if (empty($data['titre'])) {
                    return [
                        'success' => false,
                        'message' => 'Le titre de l\'offre est obligatoire.'
                    ];
                }

                // Trouver la ville par son nom ou son ID
                $villeNom = $data['ville'] ?? '';
                $ville = Ville::where('nom', 'like', "%{$villeNom}%")->first();
                $villeId = $ville ? $ville->id : ($data['ville_id'] ?? null);
                if (!$villeId || !Ville::find($villeId)) {
                    $villeId = Ville::first()->id ?? 1;
                }
                $data['ville_id'] = $villeId;

                // Normalisation du Type de Stage
                $typeStage = $data['type_stage'] ?? 'Technique';
                if ($typeStage === 'Professionnel') {
                    $typeStage = 'Technique';
                }
                if (!in_array($typeStage, ['PFE', 'Technique', 'Observation'])) {
                    $typeStage = 'Technique';
                }
                $data['type_stage'] = $typeStage;

                // Normalisation de la Rémunération
                $remuneration = $data['remuneration'] ?? 'Non-payé';
                if ($remuneration === 'Non payé' || $remuneration === 'Non paye') {
                    $remuneration = 'Non-payé';
                }
                if (!in_array($remuneration, ['Payé', 'Non-payé'])) {
                    $remuneration = 'Non-payé';
                }
                $data['remuneration'] = $remuneration;

                // Normalisation des dates (obligatoires)
                $data['date_debut'] = $data['date_debut'] ?? now()->format('Y-m-d');
                $data['date_fin'] = $data['date_fin'] ?? now()->addMonths(3)->format('Y-m-d');

                // Formatage des responsabilités sous forme de liste avec tirets et retours à la ligne
                if (isset($data['responsabilites'])) {
                    $resps = $data['responsabilites'];
                    if (!empty($resps)) {
                        $resps = preg_replace('/^\s*[-*•]\s*/', '', $resps);
                        $parts = preg_split('/\s*[\n\r|]+\s*[-*•]?\s*|\s+[-*•]\s+/', $resps);
                        $lines = [];
                        foreach ($parts as $part) {
                            $part = trim(ltrim(trim($part), '-*•'));
                            if (!empty($part)) {
                                $lines[] = "- " . $part;
                            }
                        }
                        $data['responsabilites'] = implode("\n", $lines);
                    }
                }

                // Formatage du profil recherché sous forme de liste avec tirets et retours à la ligne
                if (isset($data['profil_recherche'])) {
                    $profils = $data['profil_recherche'];
                    if (!empty($profils)) {
                        $profils = preg_replace('/^\s*[-*•]\s*/', '', $profils);
                        $parts = preg_split('/\s*[\n\r|]+\s*[-*•]?\s*|\s+[-*•]\s+/', $profils);
                        $lines = [];
                        foreach ($parts as $part) {
                            $part = trim(ltrim(trim($part), '-*•'));
                            if (!empty($part)) {
                                $lines[] = "- " . $part;
                            }
                        }
                        $data['profil_recherche'] = implode("\n", $lines);
                    }
                }

                // Conversion des tirets/retours à la ligne en barres verticales | pour competences_techniques (attendu par OffreService)
                if (isset($data['competences_techniques'])) {
                    $comps = $data['competences_techniques'];
                    if (!empty($comps)) {
                        $comps = preg_replace('/^\s*[-*•]\s*/', '', $comps);
                        $comps = preg_replace('/\s*[\n\r|]+\s*[-*•]?\s*/', '|', $comps);
                        $comps = preg_replace('/\s+[-*•]\s+/', '|', $comps);
                        $data['competences_techniques'] = trim($comps, '| ');
                    }
                }

                // Ajout des valeurs par défaut pour les champs requis si vides
                $data['description'] = $data['description'] ?? 'Offre de stage publiée via l\'assistant IA.';
                $data['responsabilites'] = $data['responsabilites'] ?? "- Tâches associées au stage.";
                $data['profil_recherche'] = $data['profil_recherche'] ?? "- Profil correspondant aux exigences.";
                $data['status'] = 'Active';
                $data['date_publication'] = now();

                // Publier via OffreService pour gérer l'association des compétences et les notifications
                $offreService = app(\App\Services\OffreService::class);
                $offre = $offreService->publierOffre($userId, $data, $data['secteur'] ?? 'Digital');

                return [
                    'success' => true,
                    'message' => "L'offre de stage '{$offre->titre}' a été créée et publiée avec succès !",
                    'data' => $offre
                ];

            case 'modifier_offre':
                $titreOriginal = $data['titre_original'] ?? ($data['titre'] ?? null);
                $offreId = $data['id'] ?? null;

                if ($offreId) {
                    $offre = Offre::where('id', $offreId)->where('entreprise_id', $userId)->first();
                } elseif ($titreOriginal) {
                    $offre = Offre::where('titre', 'like', "%{$titreOriginal}%")->where('entreprise_id', $userId)->first();
                } else {
                    return [
                        'success' => false,
                        'message' => ' le titre de l\'offre à modifier est manquant.'
                    ];
                }

                if (!$offre) {
                    return [
                        'success' => false,
                        'message' => 'Offre introuvable ou vous n\'êtes pas autorisé à la modifier.'
                    ];
                }

                // Formatage des responsabilités sous forme de liste avec tirets et retours à la ligne (si présent)
                if (isset($data['responsabilites'])) {
                    $resps = $data['responsabilites'];
                    if (!empty($resps)) {
                        $resps = preg_replace('/^\s*[-*•]\s*/', '', $resps);
                        $parts = preg_split('/\s*[\n\r|]+\s*[-*•]?\s*|\s+[-*•]\s+/', $resps);
                        $lines = [];
                        foreach ($parts as $part) {
                            $part = trim(ltrim(trim($part), '-*•'));
                            if (!empty($part)) {
                                $lines[] = "- " . $part;
                            }
                        }
                        $data['responsabilites'] = implode("\n", $lines);
                    }
                }

                // Formatage du profil recherché sous forme de liste avec tirets et retours à la ligne (si présent)
                if (isset($data['profil_recherche'])) {
                    $profils = $data['profil_recherche'];
                    if (!empty($profils)) {
                        $profils = preg_replace('/^\s*[-*•]\s*/', '', $profils);
                        $parts = preg_split('/\s*[\n\r|]+\s*[-*•]?\s*|\s+[-*•]\s+/', $profils);
                        $lines = [];
                        foreach ($parts as $part) {
                            $part = trim(ltrim(trim($part), '-*•'));
                            if (!empty($part)) {
                                $lines[] = "- " . $part;
                            }
                        }
                        $data['profil_recherche'] = implode("\n", $lines);
                    }
                }

                // Conversion des tirets/retours à la ligne en barres verticales | pour competences_techniques (si présent)
                if (isset($data['competences_techniques'])) {
                    $comps = $data['competences_techniques'];
                    if (!empty($comps)) {
                        $comps = preg_replace('/^\s*[-*•]\s*/', '', $comps);
                        $comps = preg_replace('/\s*[\n\r|]+\s*[-*•]?\s*/', '|', $comps);
                        $comps = preg_replace('/\s+[-*•]\s+/', '|', $comps);
                        $data['competences_techniques'] = trim($comps, '| ');
                    }
                }

                $updateData = array_filter([
                    'titre' => $data['titre'] ?? null,
                    'description' => $data['description'] ?? null,
                    'type_stage' => $data['type_stage'] ?? null,
                    'duree' => $data['duree'] ?? null,
                    'remuneration' => $data['remuneration'] ?? null,
                    'format' => $data['format'] ?? null,
                    'responsabilites' => $data['responsabilites'] ?? null,
                    'profil_recherche' => $data['profil_recherche'] ?? null,
                    'date_debut' => $data['date_debut'] ?? null,
                    'date_fin' => $data['date_fin'] ?? null,
                    'competences_techniques' => $data['competences_techniques'] ?? null,
                ]);

                if (isset($updateData['type_stage'])) {
                    if ($updateData['type_stage'] === 'Professionnel') {
                        $updateData['type_stage'] = 'Technique';
                    }
                    if (!in_array($updateData['type_stage'], ['PFE', 'Technique', 'Observation'])) {
                        unset($updateData['type_stage']);
                    }
                }

                if (isset($updateData['remuneration'])) {
                    if ($updateData['remuneration'] === 'Non payé' || $updateData['remuneration'] === 'Non paye') {
                        $updateData['remuneration'] = 'Non-payé';
                    }
                    if (!in_array($updateData['remuneration'], ['Payé', 'Non-payé'])) {
                        unset($updateData['remuneration']);
                    }
                }

                if (isset($data['secteur'])) {
                    $secteur = Secteur::where('nom', 'like', "%{$data['secteur']}%")->first();
                    if ($secteur) {
                        $updateData['secteur_id'] = $secteur->id;
                    }
                }

                if (isset($data['ville'])) {
                    $ville = Ville::where('nom', 'like', "%{$data['ville']}%")->first();
                    if ($ville) {
                        $updateData['ville_id'] = $ville->id;
                    }
                } elseif (isset($data['ville_id']) && Ville::find($data['ville_id'])) {
                    $updateData['ville_id'] = $data['ville_id'];
                }

                $offreService = app(\App\Services\OffreService::class);
                $offre = $offreService->updateOffre($offre->id, $updateData, $data['secteur'] ?? null);

                return [
                    'success' => true,
                    'message' => "L'offre '{$offre->titre}' a été modifiée avec succès !",
                    'data' => $offre
                ];

            case 'supprimer_offre':
                $titre = $data['titre'] ?? null;
                $offreId = $data['id'] ?? null;

                if ($offreId) {
                    $offre = Offre::where('id', $offreId)->where('entreprise_id', $userId)->first();
                } elseif ($titre) {
                    $offre = Offre::where('titre', 'like', "%{$titre}%")->where('entreprise_id', $userId)->first();
                } else {
                    return [
                        'success' => false,
                        'message' => 'l\'offre à supprimer est manquant.'
                    ];
                }

                if (!$offre) {
                    return [
                        'success' => false,
                        'message' => 'Offre introuvable ou vous n\'êtes pas autorisé à la supprimer.'
                    ];
                }

                $titreValide = $offre->titre;
                $offre->delete();

                return [
                    'success' => true,
                    'message' => "L'offre '{$titreValide}' a été supprimée avec succès.",
                    'data' => null
                ];

            case 'gerer_ressources_admin':
                $etablissements = $data['etablissements'] ?? [];
                $filieres = $data['filieres'] ?? [];
                $secteurs = $data['secteurs'] ?? [];

                $summary = [];

                // Etablissements
                if (!empty($etablissements['creer'])) {
                    foreach ($etablissements['creer'] as $nom) {
                        Etablissement::firstOrCreate(['nom' => $nom]);
                    }
                    $summary[] = count($etablissements['creer']) . " établissement(s) créé(s)";
                }
                if (!empty($etablissements['modifier'])) {
                    foreach ($etablissements['modifier'] as $mod) {
                        if (isset($mod['id'], $mod['nom'])) {
                            Etablissement::where('id', $mod['id'])->update(['nom' => $mod['nom']]);
                        }
                    }
                    $summary[] = count($etablissements['modifier']) . " établissement(s) modifié(s)";
                }
                if (!empty($etablissements['supprimer'])) {
                    Etablissement::whereIn('id', $etablissements['supprimer'])->delete();
                    $summary[] = count($etablissements['supprimer']) . " établissement(s) supprimé(s)";
                }

                // Filieres
                if (!empty($filieres['creer'])) {
                    foreach ($filieres['creer'] as $nom) {
                        Filiere::firstOrCreate(['nom' => $nom]);
                    }
                    $summary[] = count($filieres['creer']) . " filière(s) créée(s)";
                }
                if (!empty($filieres['modifier'])) {
                    foreach ($filieres['modifier'] as $mod) {
                        if (isset($mod['id'], $mod['nom'])) {
                            Filiere::where('id', $mod['id'])->update(['nom' => $mod['nom']]);
                        }
                    }
                    $summary[] = count($filieres['modifier']) . " filière(s) modifiée(s)";
                }
                if (!empty($filieres['supprimer'])) {
                    Filiere::whereIn('id', $filieres['supprimer'])->delete();
                    $summary[] = count($filieres['supprimer']) . " filière(s) supprimée(s)";
                }

                // Secteurs
                if (!empty($secteurs['creer'])) {
                    foreach ($secteurs['creer'] as $nom) {
                        Secteur::firstOrCreate(['nom' => $nom]);
                    }
                    $summary[] = count($secteurs['creer']) . " secteur(s) créé(s)";
                }
                if (!empty($secteurs['modifier'])) {
                    foreach ($secteurs['modifier'] as $mod) {
                        if (isset($mod['id'], $mod['nom'])) {
                            Secteur::where('id', $mod['id'])->update(['nom' => $mod['nom']]);
                        }
                    }
                    $summary[] = count($secteurs['modifier']) . " secteur(s) modifié(s)";
                }
                if (!empty($secteurs['supprimer'])) {
                    Secteur::whereIn('id', $secteurs['supprimer'])->delete();
                    $summary[] = count($secteurs['supprimer']) . " secteur(s) supprimé(s)";
                }

                $msgResult = empty($summary) ? "Aucun changement effectué." : "Modifications effectuées : " . implode(', ', $summary) . ".";

                return [
                    'success' => true,
                    'message' => $message ?: $msgResult,
                    'data' => null
                ];

            case 'recommander_offres':

            case 'generer_lettre_motivation':
            case 'analyser_candidature':
            case 'generer_rapport':
            case 'respond_user':
            default:
                // Ces actions renvoient uniquement un message textuel généré par Gemini
                return [
                    'success' => false, // false pour ne pas recharger la page automatiquement
                    'message' => $message ?: 'Je ne parviens pas à traiter votre demande actuellement.'
                ];
        }
    }
}
