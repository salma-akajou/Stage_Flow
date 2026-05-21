---
trigger: always_on
type: rule
id: stageflow-schema
---

# SCHÉMA ET RELATIONS DE BASE DE DONNÉES - STAGEFLOW

## Diagramme Relationnel Logique

```
User (1) ◄─────────► (1) Etudiant (1) ───► (N) DocumentCv
User (1) ◄─────────► (1) Entreprise (1) ───► (N) Offre

Ville (1) ───► (N) Etudiant
Ville (1) ───► (N) Entreprise
Ville (1) ───► (N) Offre

Etudiant (1) ───► (N) Candidature
Offre (1) ───► (N) Candidature
DocumentCv (1) ───► (N) Candidature

Etudiant (N) ◄───► (N) Offre (Pivot: favoris)
User (1) ───► (N) Feedback (auteur_id)
```

## Règles Clés et Contraintes de Clés

1.  **Héritage de Table (One-to-One) :**
    *   Les modèles `Etudiant` et `Entreprise` utilisent `user_id` comme clé primaire et clé étrangère référençant `users(id)` avec suppression en cascade.
    *   `incrementing = false` sur ces modèles.

2.  **Modèle Candidature :**
    *   `etudiant_id` référence `etudiants(user_id)`.
    *   `offre_id` référence `offres(id)`.
    *   `cv_id` référence `document_cvs(id)`.
    *   Colonnes : `statut` (Enum: 'en_attente', 'acceptee', 'refusee'), `telephone`, `message_motivation`, `date_postulation`, `portfolio_url`.

3.  **Modèle Offre de Stage :**
    *   `entreprise_id` référence `entreprises(user_id)`.
    *   `ville_id` référence `villes(id)`.
    *   `status` (Enum/String: 'active', 'inactive', 'archivee').
    *   `competences_techniques` stockées au format JSON.

4.  **Favoris (Table Pivot) :**
    *   Clés composites `etudiant_id` (User id) et `offre_id`.
    *   Inclut `date_ajout` comme timestamp personnalisé.

## Ordre Strict des Migrations

1.  `create_users_table` (Modifié pour nom et prenom)
2.  `create_cache_table`
3.  `create_jobs_table`
4.  `create_villes_table` (Villes du Maroc pour localisation)
5.  `create_etudiants_table` (Clé primaire: user_id)
6.  `create_entreprises_table` (Clé primaire: user_id)
7.  `create_offres_table` (Lié à l'entreprise et la ville)
8.  `create_document_cvs_table` (Stockage des chemins des fichiers de CV)
9.  `create_candidatures_table` (Pivot et informations de postulation)
10. `create_feedbacks_table` (Commentaires sur les stages/entreprises)
11. `create_favoris_table` (Sauvegardes d'offres par les étudiants)
12. `create_permission_tables` (Rôles Spatie)
