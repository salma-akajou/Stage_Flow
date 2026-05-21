---
name: stageflow-builder
description: Logique métier, transactions, calculs statistiques et implémentation des services de la plateforme StageFlow.
---

# 🔨 COMPÉTENCE : STAGEFLOW BUILDER

## Rôle et Domaine d'Action
Cette compétence gère la logique métier de **StageFlow** en encapsulant toutes les requêtes lourdes, les calculs de KPIs et les opérations d'écritures complexes dans `app/Services/`.

## Les Services et leurs KPIs

### 1. Service Dashboard (DashboardService)
Ce service agrège les données clés pour les différents espaces utilisateurs.

*   **KPIs Espace Admin / Modérateur :**
    ```php
    public function obtenirStatsAdmin(): array {
        return [
            'total_etudiants' => Etudiant::count(),
            'total_entreprises' => Entreprise::count(),
            'total_offres' => Offre::count(),
            'candidatures_soumises' => Candidature::count(),
            'feedbacks_en_attente' => Feedback::where('statut', 'en_attente')->count(),
            'taux_acceptation' => $this->calculerTauxAcceptationGlobale(),
        ];
    }
    ```
*   **KPIs Espace Entreprise (Recruteur) :**
    ```php
    public function obtenirStatsEntreprise(int $entrepriseId): array {
        return [
            'offres_actives' => Offre::where('entreprise_id', $entrepriseId)->where('status', 'active')->count(),
            'candidatures_recues' => Candidature::whereHas('offre', function($q) use($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })->count(),
            'candidatures_a_traiter' => Candidature::where('statut', 'en_attente')->whereHas('offre', function($q) use($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })->count(),
        ];
    }
    ```

### 2. Service Offre (OffreService)
Gère le cycle de vie des offres de stage et le moteur de recherche par filtres.
*   **Filtrage Multicritère :** Permet de croiser le mot-clé, le secteur, la ville, le format (présentiel, télétravail, hybride), le type de stage et d'ordonner par pertinence ou date de publication.
*   **Recommandation (Matching) :** Récupère les offres qui correspondent à la filière de l'étudiant connecté.

### 3. Service Candidature (CandidatureService)
*   **Sécurité de Postulation :** Vérifie que l'étudiant a téléversé au moins un document CV valide avant de lui permettre de postuler.
*   **Historique :** Enregistre la candidature avec un statut initial de `'en_attente'`.
*   **Changement de statut sécurisé :** Seule l'entreprise propriétaire de l'offre ou un administrateur peut modifier le statut d'une candidature (`'acceptee'`, `'refusee'`).

## Normes d'Écriture
*   Toutes les méthodes doivent lever des exceptions explicites en cas d'erreur métier (ex: `ModelNotFoundException`, `AuthorizationException`).
*   Ne jamais faire de calcul de moyenne ou de pourcentage en dehors de la base de données quand un appel SQL `AVG()` ou `COUNT()` est possible pour des raisons de performance.
