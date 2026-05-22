---
description: Guide d'installation et de configuration initiale de l'environnement de développement pour StageFlow.
trigger: /install-stageflow
---

# 🔧 WORKFLOW : INSTALLATION & CONFIGURATION INITIALE

## Commande Déclencheuse
`/install-stageflow`

## Prérequis Système
*   PHP 8.4+
*   Composer
*   Node.js 20+
*   MySQL 8.0+

## Étapes d'Exécution

### 1. Cloner et configurer le projet
```bash
cd c:\Solicode\Projects\Stage_Flow\stage_flow
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Base de données
Créer le schéma MySQL `stage_flow` en local (via MySQL Workbench ou console) puis configurer le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stage_flow
DB_USERNAME=root
DB_PASSWORD=
```

Lancer les migrations et charger les données initiales :
```bash
php artisan migrate --seed
```

### 3. Installation des dépendances Frontend
```bash
npm install
npm run build
```

### 4. Lancement
```bash
php artisan serve
```

## Liste de Vérification (Checklist)
- [ ] La base de données est migrée sans erreurs.
- [ ] Les rôles Spatie (`admin`, `moderateur`, `entreprise`, `etudiant`) sont injectés via le seeder.
- [ ] Le serveur local se lance correctement et l'url d'accueil est accessible.
