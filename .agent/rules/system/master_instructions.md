---
trigger: always_on
type: rule
id: stageflow-master-instructions
---

# DIRECTIVES MAÎTRESSES - STAGEFLOW

## Architecture du Projet

### 1. Organisation en Couches (Service Pattern)
*   **Contrôleurs Fins** : Les contrôleurs dans `app/Http/Controllers/Web/` et `app/Http/Controllers/Api/` ne doivent contenir aucune logique métier complexe. Ils valident les requêtes HTTP (via FormRequest) et appellent un service approprié.
*   **Services Riches** : Toute la logique métier réside exclusivement dans la couche `app/Services/`. Chaque modèle principal a son service dédié (ex: `CandidatureService`, `OffreService`, `DashboardService`).
*   **Transactions de Données** : Les écritures multiples en base de données doivent être englobées dans une transaction (`DB::transaction(...)`) pour assurer la cohérence.

### 2. Accès aux Données via Eloquent uniquement
*   Aucune requête SQL brute ni utilisation de `DB::table()` direct pour les écritures.
*   Toujours utiliser les modèles Eloquent (`User`, `Etudiant`, `Entreprise`, `Offre`, `Candidature`, `DocumentCv`, `Ville`, `Feedback`, `Favori`) et leurs relations définies.

### 3. Gestion de l'Authentification et des Mots de Passe
*   **Pas de double hachage** : Le modèle `User` utilise le cast `'password' => 'hashed'`. Ne jamais appeler `Hash::make()` manuellement avant d'assigner une valeur de mot de passe à l'attribut `password`.
*   **Sanctum** pour l'authentification API Mobile.
*   **Sessions** Laravel standard pour le web.

### 4. Norme Linguistique Obligatoire
*   **Tout en Français** : Le code (variables, noms de méthodes, propriétés personnalisées, commentaires, documentations, messages d'erreurs et étiquettes UI) doit être rédigé exclusivement en Français. 
*   Respecter les modèles et tables en Français existants (`Etudiant`, `Entreprise`, `Offre`, `Candidature`, `DocumentCv`, `Ville`, `Feedback`).

### 5. Composants UI et Design System
*   **Preline UI & Tailwind CSS** : Le projet repose sur Tailwind CSS v4 et Preline UI pour les éléments interactifs.
*   **Respect strict de la charte graphique** définie dans les maquettes.
*   **Toasts et Modales** : Les retours d'actions CUD doivent déclencher des notifications toasts et les affichages rapides d'informations d'entreprises ou de candidats doivent utiliser des modales asynchrones via Alpine.js.

### 6. Gestion des Fichiers et Documents
*   Tous les fichiers téléchargés (CVs des étudiants, photos, logos des entreprises) doivent être stockés de manière sécurisée via le système de stockage Laravel (`Storage::disk('public')`).
