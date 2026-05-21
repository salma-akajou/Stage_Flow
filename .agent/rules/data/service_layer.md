---
trigger: always_on
type: rule
id: stageflow-service-layer
---

# CONVENTIONS DE LA COUCHE SERVICES (SERVICE LAYER) - STAGEFLOW

## Rôles et Responsabilités

### Contrôleurs (Http/Controllers/Web/)
*   **Unique responsabilité** : Valider les entrées utilisateur via les requêtes de formulaire (`FormRequest`), déléguer le travail aux services concernés, et renvoyer la réponse correspondante (vue Blade, redirection ou réponse JSON pour l'asynchrone).
*   **Interdiction** : Pas de requêtes de base de données directes complexes, pas de manipulation de fichiers d'upload, pas de calculs statistiques directs.

### Services (Services/)
*   **Unique responsabilité** : Encapsuler toute la logique métier.
*   Ils gèrent l'upload physique des fichiers (`CV`, `Photo`, `Logo`), les requêtes complexes de filtres, les agrégations de statistiques pour les tableaux de bord et les règles métier complexes.
*   Chaque méthode de service doit être typée au niveau de ses arguments et valeurs de retour.

## Référentiel des Services Existants

| Service | Fonctions Principales et Rôles |
|---|---|
| `BaseService` | Classe mère fournissant des helpers partagés. |
| `UtilisateurService` | CRUD des utilisateurs, assignation des rôles, suspension et réactivation des comptes avec contrôle d'autorisation. |
| `EtudiantService` | Mise à jour du profil, gestion des fichiers photos, incrémentation du compteur de vues du profil étudiant. |
| `EntrepriseService` | Mise à jour du profil de l'entreprise, gestion du logo, récupération des entreprises par secteur. |
| `OffreService` | CRUD des offres, filtrage avancé (par mot-clé, ville, type de stage, secteur) pour le matching des offres. |
| `CandidatureService` | Processus de postulation (vérification de CV, transaction de création de candidature), modification des statuts de candidature par le recruteur. |
| `FavoriService` | Basculement (Ajout/Retrait) d'une offre en favori pour un étudiant. |
| `FeedbackService` | Soumission de feedback par un étudiant ou une entreprise, approbation ou suppression de feedback par l'administrateur. |
| `DashboardService` | Calcul des KPIs complexes selon le rôle (Admin : total comptes, feedbacks en attente ; Entreprise : candidatures à traiter, offres actives ; Étudiant : taux de candidature, offres suggérées). |

## Exemple de Transaction Standard dans OffreService / CandidatureService

```php
public function postuler(array $donnees, int $etudiantId): Candidature
{
    return DB::transaction(function () use ($donnees, $etudiantId) {
        // Enregistrement de la candidature
        $candidature = Candidature::create([
            'etudiant_id' => $etudiantId,
            'offre_id' => $donnees['offre_id'],
            'cv_id' => $donnees['cv_id'],
            'telephone' => $donnees['telephone'],
            'message_motivation' => $donnees['message_motivation'] ?? null,
            'portfolio_url' => $donnees['portfolio_url'] ?? null,
            'statut' => 'en_attente',
            'date_postulation' => now(),
        ]);

        return $candidature;
    });
}
```
