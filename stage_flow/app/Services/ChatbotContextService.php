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
use App\Models\Etablissement;
use App\Models\Filiere;

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
            return $this->getGuestContext($context);
        }

        if ($role === 'etudiant') {
            return $this->getEtudiantContext($context, $userId);
        }

        if ($role === 'entreprise') {
            return $this->getEntrepriseContext($context, $userId, $message);
        }

        if ($role === 'admin') {
            return $this->getAdminContext($context);
        }

        return $context;
    }

    private function getGuestContext(array $context): array
    {
        $context['stats_site'] = [
            'total_etudiants' => Etudiant::count(),
            'total_entreprises' => Entreprise::count(),
            'total_offres' => Offre::where('status', 'Active')->count(),
        ];
        return $context;
    }

    private function getEtudiantContext(array $context, int $userId): array
    {
        $user = User::find($userId);
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

        $context['offres_disponibles'] = Offre::where('status', 'Active')
            ->with(['entreprise', 'ville', 'secteur', 'competences'])
            ->latest()
            ->take(15)
            ->get()
            ->map(fn($o) => [
                'id' => $o->id,
                'titre' => $o->titre,
                'description' => $o->description,
                'entreprise' => $o->entreprise->nom_entreprise ?? 'STAGEFLOW',
                'ville' => $o->ville->nom ?? 'Maroc',
                'secteur' => $o->secteur->nom ?? 'Digital',
                'duree' => $o->duree,
                'remuneration' => $o->remuneration,
                'format' => $o->format,
                'date_debut' => $o->date_debut ? $o->date_debut->format('d/m/Y') : null,
                'date_fin' => $o->date_fin ? $o->date_fin->format('d/m/Y') : null,
                'competences' => $o->competences->pluck('nom')->toArray(),
                'responsabilites' => $o->responsabilites,
                'profil_recherche' => $o->profil_recherche,
            ]);

        return $context;
    }

    private function getEntrepriseContext(array $context, int $userId, ?string $message): array
    {
        $entreprise = Entreprise::with(['user', 'ville'])->find($userId);
        if ($entreprise) {
            $context['profil_entreprise'] = [
                'nom_entreprise' => $entreprise->nom_entreprise,
                'ville' => $entreprise->ville->nom ?? 'Non spécifiée',
                'adresse' => $entreprise->adresse,
                'email_contact' => $entreprise->email_contact,
                'registre_commerce' => $entreprise->registre_commerce,
                'taille' => $entreprise->taille,
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

            $offreIds = Offre::where('entreprise_id', $userId)->pluck('id')->toArray();
            
            $msgLower = $message ? mb_strtolower($message) : '';
            $isAnalysisRequest = str_contains($msgLower, 'analys') || str_contains($msgLower, 'évalu') || str_contains($msgLower, 'cv');

            $candidatures = Candidature::whereIn('offre_id', $offreIds)
                ->with(['offre', 'etudiant.user', 'etudiant.filiere', 'etudiant.etablissement', 'cv'])
                ->latest()
                ->get();

            $scores = [];
            foreach ($candidatures as $c) {
                $score = 0;
                if ($isAnalysisRequest && !empty($msgLower)) {
                    $cPrenom = mb_strtolower($c->etudiant->user->prenom ?? '');
                    $cNom = mb_strtolower($c->etudiant->user->nom ?? '');

                    if (!empty($cPrenom) && !empty($cNom) && 
                        str_contains($msgLower, $cPrenom) && str_contains($msgLower, $cNom)) {
                        $score = 2;
                    }
                    elseif ((!empty($cPrenom) && str_contains($msgLower, $cPrenom)) || 
                            (!empty($cNom) && str_contains($msgLower, $cNom))) {
                        $score = 1;
                    }
                }
                $scores[$c->id] = $score;
            }

            $maxScore = !empty($scores) ? max($scores) : 0;

            $context['candidatures_recues'] = $candidatures->map(function($c, $index) use ($msgLower, $scores, $maxScore) {
                $rowNumber = $index + 1;
                $cvText = 'Non fourni ou illisible';
                
                $isTargetCandidate = ($maxScore > 0 && $scores[$c->id] === $maxScore);

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
        return $context;
    }

    private function getAdminContext(array $context): array
    {
        $context['stats_globales'] = [
            'total_utilisateurs' => User::count(),
            'total_etudiants' => Etudiant::count(),
            'total_entreprises' => Entreprise::count(),
            'total_offres' => Offre::count(),
            'total_candidatures' => Candidature::count(),
            'total_feedbacks' => Feedback::count(),
        ];

        $context['etablissements'] = Etablissement::select('id', 'nom')->get()->map(fn($e) => ['id' => $e->id, 'nom' => $e->nom]);
        $context['filieres'] = Filiere::select('id', 'nom')->get()->map(fn($f) => ['id' => $f->id, 'nom' => $f->nom]);
        $context['secteurs'] = Secteur::select('id', 'nom')->get()->map(fn($s) => ['id' => $s->id, 'nom' => $s->nom]);

        return $context;
    }
}
