<?php

namespace App\Services;

use App\Models\Candidature;
use App\Models\DocumentCv;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CandidatureService extends BaseService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->model = new Candidature();
        $this->notificationService = $notificationService;
    }

    public function postuler(int $etudiantId, int $offreId, array $data): Candidature
    {
        $cvId = null;
        if (isset($data['cv'])) {
            $path = $data['cv']->store('cvs', 'public');
            $cv = DocumentCv::create([
                'file_path' => $path,
                'etudiant_id' => $etudiantId,
                'date_upload' => now(),
            ]);
            $cvId = $cv->id;
        }

        $photoPath = null;
        if (isset($data['photo'])) {
            $photoPath = $data['photo']->store('photos/candidatures', 'public');
        }

        $candidature = $this->create([
            'etudiant_id'        => $etudiantId,
            'offre_id'           => $offreId,
            'cv_id'              => $cvId,
            'statut'             => 'En attente',
            'telephone'          => $data['telephone'] ?? 'Non renseigné',
            'message_motivation' => $data['message_motivation'] ?? '',
            'photo'              => $photoPath,
            'portfolio_url'      => $data['portfolio_url'] ?? null,
        ]);

        // Notify the company user
        $candidature->load(['offre.entreprise.user']);
        $entrepriseUser = $candidature->offre->entreprise->user ?? null;
        if ($entrepriseUser) {
            $studentNom = auth()->user()->prenom . ' ' . auth()->user()->nom;
            $offreTitre = $candidature->offre->titre;
            
            $title = "Nouvelle candidature reçue";
            $message = "Le candidat {$studentNom} a postulé à votre offre : \"{$offreTitre}\".";

            $this->notificationService->createNotification(
                $entrepriseUser->id,
                'new_candidature',
                $title,
                $message,
                [
                    'candidature_id' => $candidature->id,
                    'offre_id' => $candidature->offre_id,
                    'student_name' => $studentNom
                ]
            );
        }

        return $candidature;
    }

    public function listEtudiantCandidatures(int $etudiantId, array $filters = [], int $perPage = 9, bool $includeStats = false): LengthAwarePaginator|array
    {
        $query = $this->model->where('etudiant_id', $etudiantId)->with(['offre.entreprise', 'offre.ville']);

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('offre', function ($q) use ($filters) {
                $q->where('titre', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('entreprise', function ($q2) use ($filters) {
                      $q2->where('nom_entreprise', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }

        $results = $query->latest()->paginate($perPage);

        if ($includeStats) {
            return [
                'candidatures' => $results,
                'stats' => [
                    'total' => $this->model->where('etudiant_id', $etudiantId)->count(),
                    'attente' => $this->model->where('etudiant_id', $etudiantId)->where('statut', 'En attente')->count(),
                    'accepte' => $this->model->where('etudiant_id', $etudiantId)->where('statut', 'Accepté')->count(),
                    'refuse' => $this->model->where('etudiant_id', $etudiantId)->where('statut', 'Refusé')->count(),
                ]
            ];
        }

        return $results;
    }

    private function buildEntrepriseCandidaturesQuery(int $entrepriseId, array $filters = [])
    {
        $query = $this->model->whereHas('offre', function ($q) use ($entrepriseId) {
            $q->where('entreprise_id', $entrepriseId);
        })->with(['etudiant.user', 'offre']);

        if (!empty($filters['offre_id'])) {
            $query->where('offre_id', $filters['offre_id']);
        }

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('etudiant.user', function ($q) use ($filters) {
                $q->where('prenom', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('nom', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest();
    }

    public function listEntrepriseCandidatures(int $entrepriseId, array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        return $this->buildEntrepriseCandidaturesQuery($entrepriseId, $filters)->paginate($perPage);
    }

    public function exportCandidaturesToCsv(int $entrepriseId, array $filters = []): void
    {
        $candidatures = $this->buildEntrepriseCandidaturesQuery($entrepriseId, $filters)->get();

        // Add UTF-8 BOM for Microsoft Excel compatibility
        echo chr(0xEF).chr(0xBB).chr(0xBF);

        $file = fopen('php://output', 'w');
        
        fputcsv($file, [
            'Candidat',
            'Email',
            'Téléphone',
            'Offre de stage',
            'Statut',
            'Date de postulation',
            'Lien Portfolio'
        ], ';');

        foreach ($candidatures as $candidature) {
            fputcsv($file, [
                $candidature->etudiant->user->prenom . ' ' . $candidature->etudiant->user->nom,
                $candidature->etudiant->user->email,
                $candidature->telephone,
                $candidature->offre->titre,
                $candidature->statut,
                $candidature->created_at->format('d/m/Y H:i'),
                $candidature->portfolio_url ?? 'N/A'
            ], ';');
        }

        fclose($file);
    }

    public function changeStatus(int $id, string $status): bool
    {
        $candidature = $this->model->with(['etudiant.user', 'offre.entreprise'])->findOrFail($id);
        $updated = (bool) $candidature->update(['statut' => $status]);

        if ($updated) {
            $studentUser = $candidature->etudiant->user ?? null;
            if ($studentUser) {
                $entrepriseNom = $candidature->offre->entreprise->nom_entreprise ?? 'Une entreprise';
                $offreTitre = $candidature->offre->titre;
                
                $title = "Candidature " . ($status === 'Accepté' ? 'acceptée' : 'refusée');
                $message = "Votre candidature pour l'offre \"{$offreTitre}\" chez {$entrepriseNom} a été " . ($status === 'Accepté' ? 'acceptée' : 'refusée') . ".";

                $this->notificationService->createNotification(
                    $studentUser->id,
                    'candidature_status',
                    $title,
                    $message,
                    [
                        'candidature_id' => $candidature->id,
                        'offre_id' => $candidature->offre_id,
                        'status' => $status
                    ]
                );
            }
        }

        return $updated;
    }

    public function delete(int $id): ?bool
    {
        $candidature = $this->findOrFail($id);

        if ($candidature->photo && Storage::disk('public')->exists($candidature->photo)) {
            Storage::disk('public')->delete($candidature->photo);
        }

        return $candidature->delete();
    }

    public function retirerCandidature(int $id, int $etudiantId): bool|string
    {
        $candidature = $this->findOrFail($id);

        if ($candidature->etudiant_id !== $etudiantId) {
            abort(403);
        }

        if ($candidature->statut !== 'En attente') {
            return 'Impossible de retirer une candidature déjà traitée.';
        }

        $this->delete($id);

        return true;
    }

    public function getRecentsCandidatures(int $etudiantId, int $limit = 3): \Illuminate\Support\Collection
    {
        return $this->model->where('etudiant_id', $etudiantId)
            ->with(['offre.entreprise', 'offre.ville']) 
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getRecentByEntreprise(int $entrepriseId, int $limit = 4): \Illuminate\Support\Collection
    {
        return $this->model->whereHas('offre', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->with(['etudiant.user', 'offre'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function findWithDetails(int $id): Candidature
    {
        return Candidature::with(['offre', 'etudiant.user', 'cv'])->findOrFail($id);
    }
}
