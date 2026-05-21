---
description: Construction de l'espace administration/modération, de la gestion des comptes et de la validation des feedbacks.
trigger: /admin-dashboard
---

# 👑 WORKFLOW : ESPACE ADMINISTRATION & MODÉRATION

## Commandes Déclencheuses
*   `/admin-dashboard` : Accès global et KPIs administratifs.
*   `/admin-utilisateurs` : Modération des comptes utilisateurs.
*   `/admin-feedbacks` : Approbation/Suppression des avis.

## Étapes d'Exécution

### 1. Tableau de Bord Administratif (Admin Dashboard)
*   **Contrôleur** : `App\Http\Controllers\Web\Admin\DashboardController`.
*   **Service** : `App\Services\DashboardService`.
*   **KPIs affichés** : Nombre d'étudiants, d'entreprises, d'offres en ligne, de candidatures soumises et feedbacks en attente de modération.

### 2. Gestion des Utilisateurs (Modération)
*   Les administrateurs et modérateurs peuvent lister l'ensemble des comptes (Étudiants, Recruteurs, Modérateurs).
*   **Suspension / Réactivation** : La suspension d'un utilisateur désactive sa possibilité de connexion ou rend ses offres inactives.
*   **Action réservée** : Seul le rôle `admin` ayant la permission `gerer-utilisateurs` peut suspendre ou supprimer définitivement un utilisateur.

### 3. Modération des Feedbacks
*   **Validation** : Tout nouveau feedback rédigé par un étudiant reste masqué par défaut (`statut = 'en_attente'`) jusqu'à ce qu'un admin ou modérateur l'approuve via la méthode `approve`.
*   **Suppression** : En cas de propos inappropriés, le feedback est détruit en base de données via la méthode `destroy` avec confirmation préalable dans l'UI.

## Liste de Vérification (Checklist)
- [ ] Les compteurs statistiques sont exacts et mis à jour.
- [ ] La suspension bloque l'accès de l'utilisateur concerné.
- [ ] Les feedbacks non approuvés ne s'affichent pas sur le site public.
