---
description: Gestion des flux d'authentification, de l'enregistrement avec attribution des profils et des redirections après connexion.
trigger: /auth-roles
---

# 🔐 WORKFLOW : AUTHENTIFICATION & RÔLES

## Commande Déclencheuse
`/auth-roles`

## Étapes d'Exécution

### 1. Inscription Multi-Profils
Lorsqu'un utilisateur s'inscrit, il doit choisir son type de compte (Étudiant ou Entreprise). La transaction de création doit :
1.  Créer l'utilisateur dans la table `users`.
2.  Attribuer le rôle Spatie correspondant (`etudiant` ou `entreprise`).
3.  Créer l'enregistrement lié dans `etudiants` (avec sa clé primaire égale à `user_id` de l'user nouvellement créé) ou dans `entreprises`.

### 2. Algorithme de Redirection après Connexion
Dans le contrôleur de connexion (`LoginController` ou `HomeController`), implémenter la redirection dynamique en fonction de la relation Eloquent présente sur le compte utilisateur :

```php
public function redirigerUtilisateur()
{
    $user = auth()->user();

    if ($user->etudiant) {
        return redirect()->route('student.dashboard');
    }

    if ($user->entreprise) {
        return redirect()->route('entreprise.dashboard');
    }

    if ($user->hasRole('moderateur') || $user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('landing');
}
```

## Liste de Vérification (Checklist)
- [ ] L'inscription d'un étudiant crée bien son profil `etudiant` lié.
- [ ] L'inscription d'une entreprise crée bien son profil `entreprise` lié.
- [ ] La connexion redirige chaque utilisateur vers son espace dédié sans erreur.
