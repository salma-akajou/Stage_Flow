<?php

namespace App\Services;

use App\Models\Ville;
use App\Models\Secteur;
use App\Models\Offre;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Candidature;
use App\Models\Feedback;
use App\Models\User;

class ChatbotContextService
{
    public function getContext(string $role, ?int $userId, ?string $message = null): array
    {
        $context = [
            'role_utilisateur' => $role,
            'villes' => Ville::select('id', 'nom')->get(),
            'secteurs' => Secteur::select('id', 'nom')->get(),
        ];

        if ($role === 'guest' || !$userId) {
            $context['stats_site'] = [
                'total_etudiants' => Etudiant::count(),
                'total_entreprises' => Entreprise::count(),
                'total_offres' => Offre::where('status', 'Active')->count(),
            ];
            return $context;
        }

        $user = User::find($userId);

        if ($role === 'etudiant') {
            $etudiant = Etudiant::with(['user', 'ville', 'filiere', 'etablissement'])->find($userId);
            if ($etudiant) {
                $context['profil_etudiant'] = [
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                    'ville' => $etudiant->ville->nom ?? 'Non spécifiée',
                    'filiere' => $etudiant->filiere->nom ?? 'Non spécifiée',
                    'etablissement' => $etudiant->etablissement->nom ?? 'Non spécifié',
                    'niveau_etudes' => $etudiant->niveau_etudes,
                    'bio' => $etudiant->bio,
                ];

                $context['mes_candidatures'] = Candidature::where('etudiant_id', $userId)
                    ->with(['offre.entreprise'])
                    ->get()
                    ->map(fn($c) => [
                        'candidature_id' => $c->id,
                        'offre_titre' => $c->offre->titre ?? 'Offre',
                        'entreprise' => $c->offre->entreprise->nom_entreprise ?? 'STAGEFLOW',
                        'statut' => $c->statut,
                        'date_postulation' => $c->created_at->format('d/m/Y'),
                    ]);
            }

            // Liste simplifiée des offres actives disponibles
            $context['offres_disponibles'] = Offre::where('status', 'Active')
                ->with(['entreprise', 'ville', 'secteur'])
                ->latest()
                ->take(15)
                ->get()
                ->map(fn($o) => [
                    'id' => $o->id,
                    'titre' => $o->titre,
                    'entreprise' => $o->entreprise->nom_entreprise ?? 'STAGEFLOW',
                    'ville' => $o->ville->nom ?? 'Maroc',
                    'secteur' => $o->secteur->nom ?? 'Digital',
                    'duree' => $o->duree,
                    'remuneration' => $o->remuneration,
                    'format' => $o->format,
                ]);
        }

        if ($role === 'entreprise') {
            $entreprise = Entreprise::with(['user', 'ville'])->find($userId);
            if ($entreprise) {
                $context['profil_entreprise'] = [
                    'nom_entreprise' => $entreprise->nom_entreprise,
                    'ville' => $entreprise->ville->nom ?? 'Non spécifiée',
                    'bio' => $entreprise->bio,
                ];

                $context['mes_offres'] = Offre::where('entreprise_id', $userId)
                    ->with(['ville', 'secteur'])
                    ->latest()
                    ->get()
                    ->map(fn($o) => [
                        'id' => $o->id,
                        'titre' => $o->titre,
                        'status' => $o->status,
                        'ville' => $o->ville->nom ?? 'Maroc',
                        'secteur' => $o->secteur->nom ?? 'Digital',
                    ]);

                // Candidatures reçues pour cette entreprise
                $offreIds = Offre::where('entreprise_id', $userId)->pluck('id')->toArray();
                
                $msgLower = $message ? mb_strtolower($message) : '';
                $isAnalysisRequest = str_contains($msgLower, 'analys') || str_contains($msgLower, 'évalu') || str_contains($msgLower, 'cv');

                $context['candidatures_recues'] = Candidature::whereIn('offre_id', $offreIds)
                    ->with(['offre', 'etudiant.user', 'etudiant.filiere', 'etudiant.etablissement', 'cv'])
                    ->latest()
                    ->get()
                    ->map(function($c, $index) use ($msgLower, $isAnalysisRequest) {
                        $rowNumber = $index + 1;
                        $cvText = 'Non fourni ou illisible';
                        
                        $candidatPrenom = mb_strtolower($c->etudiant->user->prenom ?? '');
                        $candidatNomFamille = mb_strtolower($c->etudiant->user->nom ?? '');
                        
                        $isTargetCandidate = false;
                        if ($isAnalysisRequest && !empty($msgLower)) {
                            if ((!empty($candidatPrenom) && str_contains($msgLower, $candidatPrenom)) || 
                                (!empty($candidatNomFamille) && str_contains($msgLower, $candidatNomFamille))) {
                                $isTargetCandidate = true;
                            }
                            elseif (str_contains($msgLower, '#' . $c->id) || 
                                    str_contains($msgLower, 'id ' . $c->id) || 
                                    str_contains($msgLower, 'no ' . $c->id) || 
                                    str_contains($msgLower, 'n° ' . $c->id) ||
                                    str_contains($msgLower, 'numéro ' . $c->id)) {
                                $isTargetCandidate = true;
                            }
                            elseif (preg_match('/\b' . $rowNumber . '\b/', $msgLower) || 
                                    str_contains($msgLower, $rowNumber . 'e') ||
                                    ($rowNumber == 1 && (str_contains($msgLower, 'premier') || str_contains($msgLower, 'première'))) ||
                                    ($rowNumber == 2 && (str_contains($msgLower, 'deuxième') || str_contains($msgLower, 'second'))) ||
                                    ($rowNumber == 3 && str_contains($msgLower, 'troisième')) ||
                                    ($rowNumber == 4 && str_contains($msgLower, 'quatrième')) ||
                                    ($rowNumber == 5 && str_contains($msgLower, 'cinquième'))) {
                                $isTargetCandidate = true;
                            }
                        }

                        if ($isTargetCandidate) {
                            if ($c->cv && $c->cv->file_path) {
                                $filePath = storage_path('app/public/' . $c->cv->file_path);
                                if (file_exists($filePath)) {
                                    try {
                                        $parser = new \Smalot\PdfParser\Parser();
                                        $pdf = $parser->parseFile($filePath);
                                        $extractedText = trim($pdf->getText());
                                        if (!empty($extractedText)) {
                                            $cvText = mb_substr($extractedText, 0, 1500);
                                        }
                                    } catch (\Throwable $e) {
                                        $cvText = "[Erreur de lecture du CV: " . $e->getMessage() . "]";
                                    }
                                }
                            }
                        } else {
                            $cvText = '[Contenu du CV masqué pour économiser les ressources. Demandez l\'analyse de ce candidat spécifique pour lire son CV]';
                        }

                        return [
                            'candidature_id' => $c->id,
                            'position_dans_la_liste' => $rowNumber,
                            'offre_id' => $c->offre_id,
                            'offre_titre' => $c->offre->titre ?? 'Offre',
                            'candidat_nom' => ($c->etudiant->user->prenom ?? '') . ' ' . ($c->etudiant->user->nom ?? ''),
                            'candidat_filiere' => $c->etudiant->filiere->nom ?? 'Non spécifiée',
                            'candidat_etablissement' => $c->etudiant->etablissement->nom ?? 'Non spécifié',
                            'candidat_niveau' => $c->etudiant->niveau_etudes,
                            'candidat_bio' => $c->etudiant->bio,
                            'statut' => $c->statut,
                            'lettre_motivation' => $c->message_motivation ?? 'Non fournie',
                            'cv_contenu' => $cvText,
                        ];
                    });
            }
        }

        if ($role === 'admin') {
            $context['stats_globales'] = [
                'total_utilisateurs' => User::count(),
                'total_etudiants' => Etudiant::count(),
                'total_entreprises' => Entreprise::count(),
                'total_offres' => Offre::count(),
                'total_candidatures' => Candidature::count(),
                'total_feedbacks' => Feedback::count(),
            ];

            $context['etablissements'] = \App\Models\Etablissement::select('id', 'nom')->get()->map(fn($e) => ['id' => $e->id, 'nom' => $e->nom]);
            $context['filieres'] = \App\Models\Filiere::select('id', 'nom')->get()->map(fn($f) => ['id' => $f->id, 'nom' => $f->nom]);
        }

        return $context;
    }
}
