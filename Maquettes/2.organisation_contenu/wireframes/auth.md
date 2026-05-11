# Wireframe : Authentification

## 1. Connexion (Login)
- **Composant** : Card centrée.
    - Titre : "Connexion à StageFlow".
    - Champs : Email, Mot de passe.
    - Option : "Se souvenir de moi".
    - Action : [Se connecter].
    - Lien : "Pas encore inscrit ? Créer un compte".

## 2. Inscription (Register)
- **Composant** : Card large.
    - Titre : "Créer votre compte".
    - **Toggle Rôle** : [Je suis un Étudiant] | [Je suis une Entreprise].
    - **Formulaire Dynamique** :
        - *Si Étudiant* : Filière, Niveau, Bio, GitHub, LinkedIn, CV.
        - *Si Entreprise* : Nom société, Secteur, Site Web, Taille, Logo.
    - Action : [Finaliser l'inscription].
