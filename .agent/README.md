# StageFlow Agent Configuration

Ce dossier `.agent` contient la configuration complète pour le développement et la maintenance de la plateforme **StageFlow** — un système de gestion et de suivi des candidatures de stages pour Solicode.

## Structure du Dossier

```
.agent/
├── README.md                 # Documentation et commandes rapides
├── rules/                    # Règles et normes architecturales
│   ├── system/
│   │   └── master_instructions.md  # Directives d'architecture globale
│   ├── data/
│   │   ├── stageflow_schema.md     # Schéma de base de données et relations
│   │   └── service_layer.md        # Directives de la couche Services
│   ├── roles/
│   │   └── access_control.md       # Droits d'accès et RBAC Spatie
│   └── visual/
│       └── identity.md             # Charte graphique et conventions visuelles
├── skills/                   # Définitions des compétences de l'agent
│   ├── stageflow-architect/  # Base de données, Migrations et Modèles Eloquent
│   ├── stageflow-builder/    # Logique métier, Services et KPIs
│   └── stageflow-developer/  # Interface utilisateur, Blade, Alpine.js et CSS
└── workflows/                # Guides de développement par module
    ├── shared/               # Processus communs (Installation, Auth)
    ├── admin/                # Espace Administrateur / Modérateur
    ├── entreprise/           # Espace Entreprise (Recruteurs)
    └── student/              # Espace Étudiant
```

## Rôles Clés dans StageFlow

*   **Étudiant** : Consulter les offres, gérer ses favoris, postuler via un CV et suivre l'état de ses candidatures.
*   **Entreprise** : Publier et gérer des offres de stage, examiner les candidatures reçues et modifier ses informations de profil.
*   **Administrateur / Modérateur** : Superviser l'écosystème, modérer les utilisateurs (suspension/réactivation) et valider/rejeter les feedbacks.

## Commandes Rapides de l'Agent

| Commande | Description |
|---|---|
| `/install-stageflow` | Initialisation de l'environnement Laravel 12.x et dépendances |
| `/auth-roles` | Configuration Spatie Permissions et Authentification |
| `/admin-dashboard` | Construction du tableau de bord de modération et KPIs |
| `/admin-utilisateurs` | Gestion et modération des comptes (Admin) |
| `/admin-feedbacks` | Modération et approbation des commentaires et notes |
| `/entreprise-dashboard` | Espace recruteur avec KPIs (offres actives, postulations) |
| `/entreprise-offres` | CRUD complet des offres de stage de l'entreprise |
| `/entreprise-candidatures` | Évaluation des candidats et changement de statuts |
| `/student-dashboard` | Espace étudiant personnalisé avec recommandations d'offres |
| `/student-offres` | Recherche d'offres, filtrage et matching d'opportunités |
| `/student-candidatures` | Formulaire de postulation et suivi en direct des statuts |
| `/student-favoris` | Gestion des offres sauvegardées |

## Cadre Académique

> **Projet de Fin d'Études (PFE)** — Solicode Tanger  
> **Auteur :** Salma Akajou  
> **Encadrant :** M. ESSARRAJ Fouad  
> **Session :** 2025/2026  

---
**Projet :** StageFlow  
**Version de l'Agent :** 1.0.0 (Unique et Personnalisée)
