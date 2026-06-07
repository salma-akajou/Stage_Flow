<?php

namespace App\Services;

use App\Models\Offre;
use App\Models\Secteur;
use App\Models\Candidature;
use App\Models\Feedback;
use App\Models\Ville;

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

                // Trouver la ville
                $villeId = $data['ville_id'] ?? null;
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

                // Normalisation des dates
                $dateDebut = $data['date_debut'] ?? null;
                if (!$dateDebut) {
                    $dateDebut = now()->format('Y-m-d');
                }
                $dateFin = $data['date_fin'] ?? null;
                if (!$dateFin) {
                    $months = 3;
                    if (isset($data['duree']) && preg_match('/(\d+)\s*mois/i', $data['duree'], $matches)) {
                        $months = (int)$matches[1];
                    }
                    $dateFin = now()->addMonths($months)->format('Y-m-d');
                }
                $data['date_debut'] = $dateDebut;
                $data['date_fin'] = $dateFin;

                // Conversion des tirets - en barres verticales | pour responsabilites
                if (isset($data['responsabilites'])) {
                    $resps = $data['responsabilites'];
                    if (!empty($resps)) {
                        $resps = preg_replace('/^\s*-\s*/', '', $resps);
                        $resps = preg_replace('/\s*[\n|]*\s*-\s*/', '|', $resps);
                        $resps = preg_replace('/\s*-\s*/', '|', $resps);
                        $data['responsabilites'] = $resps;
                    }
                }

                // Conversion des tirets - en barres verticales | pour profil_recherche
                if (isset($data['profil_recherche'])) {
                    $profils = $data['profil_recherche'];
                    if (!empty($profils)) {
                        $profils = preg_replace('/^\s*-\s*/', '', $profils);
                        $profils = preg_replace('/\s*[\n|]*\s*-\s*/', '|', $profils);
                        $profils = preg_replace('/\s*-\s*/', '|', $profils);
                        $data['profil_recherche'] = $profils;
                    }
                }

                // Ajout des valeurs par défaut pour les champs requis si vides
                $data['description'] = $data['description'] ?? 'Offre de stage publiée via l\'assistant IA.';
                $data['responsabilites'] = $data['responsabilites'] ?? 'Tâches associées au stage.';
                $data['profil_recherche'] = $data['profil_recherche'] ?? 'Profil correspondant aux exigences.';
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
                $offreId = $data['id'] ?? null;
                if (!$offreId) {
                    return [
                        'success' => false,
                        'message' => 'L\'identifiant de l\'offre à modifier est manquant.'
                    ];
                }

                $offre = Offre::where('id', $offreId)->where('entreprise_id', $userId)->first();
                if (!$offre) {
                    return [
                        'success' => false,
                        'message' => 'Offre introuvable ou vous n\'êtes pas autorisé à la modifier.'
                    ];
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

                if (isset($data['ville_id']) && Ville::find($data['ville_id'])) {
                    $updateData['ville_id'] = $data['ville_id'];
                }

                $offre->update($updateData);

                return [
                    'success' => true,
                    'message' => "L'offre '{$offre->titre}' a été modifiée avec succès !",
                    'data' => $offre
                ];

            case 'supprimer_offre':
                $offreId = $data['id'] ?? null;
                if (!$offreId) {
                    return [
                        'success' => false,
                        'message' => 'L\'identifiant de l\'offre à supprimer est manquant.'
                    ];
                }

                $offre = Offre::where('id', $offreId)->where('entreprise_id', $userId)->first();
                if (!$offre) {
                    return [
                        'success' => false,
                        'message' => 'Offre introuvable ou vous n\'êtes pas autorisé à la supprimer.'
                    ];
                }

                $titre = $offre->titre;
                $offre->delete();

                return [
                    'success' => true,
                    'message' => "L'offre '{$titre}' a été supprimée avec succès.",
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
                        \App\Models\Etablissement::firstOrCreate(['nom' => $nom]);
                    }
                    $summary[] = count($etablissements['creer']) . " établissement(s) créé(s)";
                }
                if (!empty($etablissements['modifier'])) {
                    foreach ($etablissements['modifier'] as $mod) {
                        if (isset($mod['id'], $mod['nom'])) {
                            \App\Models\Etablissement::where('id', $mod['id'])->update(['nom' => $mod['nom']]);
                        }
                    }
                    $summary[] = count($etablissements['modifier']) . " établissement(s) modifié(s)";
                }
                if (!empty($etablissements['supprimer'])) {
                    \App\Models\Etablissement::whereIn('id', $etablissements['supprimer'])->delete();
                    $summary[] = count($etablissements['supprimer']) . " établissement(s) supprimé(s)";
                }

                // Filieres
                if (!empty($filieres['creer'])) {
                    foreach ($filieres['creer'] as $nom) {
                        \App\Models\Filiere::firstOrCreate(['nom' => $nom]);
                    }
                    $summary[] = count($filieres['creer']) . " filière(s) créée(s)";
                }
                if (!empty($filieres['modifier'])) {
                    foreach ($filieres['modifier'] as $mod) {
                        if (isset($mod['id'], $mod['nom'])) {
                            \App\Models\Filiere::where('id', $mod['id'])->update(['nom' => $mod['nom']]);
                        }
                    }
                    $summary[] = count($filieres['modifier']) . " filière(s) modifiée(s)";
                }
                if (!empty($filieres['supprimer'])) {
                    \App\Models\Filiere::whereIn('id', $filieres['supprimer'])->delete();
                    $summary[] = count($filieres['supprimer']) . " filière(s) supprimée(s)";
                }

                // Secteurs
                if (!empty($secteurs['creer'])) {
                    foreach ($secteurs['creer'] as $nom) {
                        \App\Models\Secteur::firstOrCreate(['nom' => $nom]);
                    }
                    $summary[] = count($secteurs['creer']) . " secteur(s) créé(s)";
                }
                if (!empty($secteurs['modifier'])) {
                    foreach ($secteurs['modifier'] as $mod) {
                        if (isset($mod['id'], $mod['nom'])) {
                            \App\Models\Secteur::where('id', $mod['id'])->update(['nom' => $mod['nom']]);
                        }
                    }
                    $summary[] = count($secteurs['modifier']) . " secteur(s) modifié(s)";
                }
                if (!empty($secteurs['supprimer'])) {
                    \App\Models\Secteur::whereIn('id', $secteurs['supprimer'])->delete();
                    $summary[] = count($secteurs['supprimer']) . " secteur(s) supprimé(s)";
                }

                $msgResult = empty($summary) ? "Aucun changement effectué." : "Modifications effectuées : " . implode(', ', $summary) . ".";

                return [
                    'success' => true,
                    'message' => $message ?: $msgResult,
                    'data' => null
                ];

            case 'modifier_statut_candidature':
                $candidatureId = $data['candidature_id'] ?? null;
                $statut = $data['statut'] ?? null;

                if (!$candidatureId || !$statut) {
                    return [
                        'success' => false,
                        'message' => 'Informations de statut de candidature incomplètes.'
                    ];
                }

                if (!in_array($statut, ['Accepté', 'Refusé'])) {
                    return [
                        'success' => false,
                        'message' => 'Le statut doit être Accepté ou Refusé.'
                    ];
                }

                $candidatureService = app(\App\Services\CandidatureService::class);
                $updated = $candidatureService->changeStatus($candidatureId, $statut);

                if ($updated) {
                    return [
                        'success' => true,
                        'message' => $message ?: "Le statut de la candidature a été modifié avec succès en {$statut}.",
                        'data' => null
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Impossible de modifier le statut de la candidature.'
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
