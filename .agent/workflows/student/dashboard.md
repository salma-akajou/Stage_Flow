---
description: Gestion de l'espace étudiant, recherche d'offres par filtres, sauvegarde des favoris et postulation en ligne.
trigger: /student-dashboard
---

# 🎓 WORKFLOW : ESPACE ÉTUDIANT (STAGIAIRE)

## Commandes Déclencheuses
*   `/student-dashboard` : Recommandations et état général.
*   `/student-offres` : Recherche et matching d'offres.
*   `/student-candidatures` : Suivi et processus de postulation.

## Étapes d'Exécution

### 1. Tableau de Bord Étudiant
*   **Contrôleur** : `App\Http\Controllers\Web\Student\DashboardController`.
*   **Service** : `App\Services\DashboardService`.
*   **Matching Intelligent** : Affichage d'offres recommandées basées sur la filière et le niveau d'études de l'étudiant.
*   **KPIs** : Candidatures envoyées, candidatures acceptées, offres favorites actives.

### 2. Recherche et Filtrage des Offres
*   Lister toutes les offres d'emploi actives.
*   **Filtres dynamiques** : Recherche par mot-clé, ville (dropdown), secteur d'activité, type de stage (PFE, observation) et format (présentiel, télétravail, hybride).
*   **Favoris** : Clic sur l'icône de cœur pour ajouter/retirer l'offre des favoris avec requête AJAX asynchrone.

### 3. Processus de Postulation
*   **Validation de CV** : L'étudiant doit d'abord avoir importé au moins un document CV (`.pdf`, `.doc`, `.docx` d'une taille max de 2 Mo) dans son espace profil.
*   **Formulaire de Postulation** : Saisie du numéro de téléphone de contact et rédaction du message de motivation. Choix du CV à joindre.
*   **Statut** : La candidature passe à `'en_attente'` et l'étudiant peut suivre son évolution en temps réel (En attente, Acceptée, Refusée).

## Liste de Vérification (Checklist)
- [ ] L'étudiant ne peut pas postuler si aucun CV n'est téléversé dans son profil.
- [ ] Le bouton cœur de favori s'illumine de manière asynchrone sans recharger la page.
- [ ] L'étudiant reçoit un message d'erreur clair si sa candidature pour une offre donnée existe déjà.
