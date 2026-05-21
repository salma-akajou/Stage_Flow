---
description: Gestion de l'espace entreprise, publication d'offres de stage et traitement des candidatures étudiantes reçues.
trigger: /entreprise-dashboard
---

# 💼 WORKFLOW : ESPACE ENTREPRISE (RECRUTEUR)

## Commandes Déclencheuses
*   `/entreprise-dashboard` : Statistiques de recrutement et d'offres.
*   `/entreprise-offres` : CRUD complet des offres de stages.
*   `/entreprise-candidatures` : Gestion des statuts et profil candidat.

## Étapes d'Exécution

### 1. Tableau de Bord Entreprise
*   **Contrôleur** : `App\Http\Controllers\Web\Entreprise\DashboardController`.
*   **Service** : `App\Services\DashboardService`.
*   **KPIs affichés** : Offres de stage actives, total des candidatures reçues, candidatures en attente de traitement.

### 2. Publication et Gestion des Offres (CRUD)
*   **Création/Édition** : Formulaire multi-champs (Titre, Description, Durée, Format, Rémunération, Ville, Secteur, Responsabilités, Profil recherché).
*   **Compétences techniques** : Saisies dynamiques converties et stockées sous forme de tableau JSON.
*   **Statuts** : `'active'`, `'inactive'`.

### 3. Traitement des Candidatures Reçues
*   **Visualisation** : Liste tabulaire des candidatures avec filtrage par offre.
*   **Évaluation via AJAX** : Cliquer sur le nom d'un candidat ouvre une modale Alpine.js qui affiche dynamiquement les détails du candidat (Bio, Compétences, Liens GitHub/LinkedIn) et permet de visualiser son CV.
*   **Prise de décision** : Boutons d'acceptation (`acceptee`) ou de refus (`refusee`) mettant à jour le statut en base de données et affichant un toast applicatif.

## Liste de Vérification (Checklist)
- [ ] Une offre créée s'affiche immédiatement dans la bibliothèque des étudiants.
- [ ] Le recruteur peut télécharger et ouvrir le CV PDF téléversé par le candidat.
- [ ] Le changement de statut d'une candidature met bien à jour l'espace de suivi de l'étudiant.
