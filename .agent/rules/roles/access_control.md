---
trigger: always_on
type: rule
id: stageflow-access-control
---

# CONTRÔLE D'ACCÈS ET RÔLES (RBAC) - STAGEFLOW

## Matrice des Rôles et Permissions

Le système s'appuie sur `Spatie Laravel Permission` pour la gestion fine des droits d'accès. Il existe quatre profils d'utilisateurs distincts.

| Rôle | Périmètre d'Accès | Permissions Associées |
|---|---|---|
| **admin** | Accès complet à l'espace d'administration et configuration complète. | `gerer-utilisateurs`, `gerer-feedbacks` |
| **moderateur** | Supervision des contenus de la plateforme. | `gerer-feedbacks` |
| **entreprise** | Accès à l'espace recruteur (gestion de ses offres et candidatures reçues). | Pas de permission globale (limité par scope de données) |
| **etudiant** | Accès à l'espace stagiaire (postulation, favoris, feedbacks, profil public). | Pas de permission globale (limité par scope de données) |

## Routage Middleware dans `routes/web.php`

```php
// Espace Étudiant
Route::middleware(['auth', 'role:etudiant'])
    ->prefix('student')
    ->name('student.')
    ->group(function () { ... });

// Espace Entreprise
Route::middleware(['auth', 'role:entreprise'])
    ->prefix('entreprise')
    ->name('entreprise.')
    ->group(function () { ... });

// Espace Admin / Modérateur
Route::middleware(['auth', 'role:admin|moderateur'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () { ... });
```

## Protection au Niveau des Contrôleurs (Permissions fines)

*   **Modération des Utilisateurs** : Seul l'administrateur possède le droit de suspendre, réactiver ou supprimer un compte utilisateur.
    ```php
    Route::middleware('can:gerer-utilisateurs')->group(function () {
        Route::post('{id}/suspend', [AdminUser::class, 'suspend']);
        Route::post('{id}/reactivate', [AdminUser::class, 'reactivate']);
        Route::delete('{id}', [AdminUser::class, 'destroy']);
    });
    ```
*   **Modération des Feedbacks** : Les administrateurs et modérateurs peuvent approuver ou rejeter les avis.
    ```php
    Route::middleware('can:gerer-feedbacks')->group(function () {
        Route::post('{id}/approve', [AdminFeedback::class, 'approve']);
        Route::delete('{id}', [AdminFeedback::class, 'destroy']);
    });
    ```

## Accesseurs et Méthodes d'Aide sur `User.php`

```php
public function getRoleAttribute(): string
{
    if ($this->etudiant) return 'etudiant';
    if ($this->entreprise) return 'entreprise';
    if ($this->hasRole('moderateur')) return 'moderateur';
    return 'admin';
}
```
