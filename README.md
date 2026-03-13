# StageFlow — Plateforme Intégrée de Gestion des Stages

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS 3.x](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![MySQL 8.0](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)

## À Propos du Projet
**StageFlow** est une plateforme web moderne conçue pour dynamiser et simplifier la mise en relation entre les étudiants et le monde professionnel. L'application transforme le processus traditionnel de recherche de stage en une expérience digitale fluide et structurée.

L'enjeu est de centraliser les opportunités, d'automatiser le suivi des candidatures et d'offrir aux recruteurs un outil de gestion performant pour identifier leurs futurs talents.

---

## Piliers & Fonctionnalités Clés
- **Matching Intelligent** : Suggestion d'offres personnalisées en fonction du profil et du secteur d'activité de l'étudiant.
- **Gestion 360° des Candidatures** : Suivi en temps réel de l'état des demandes (En attente, Acceptée, Refusée).
- **Interface Premium** : Design épuré et réactif basé sur un design system rigoureux (Tailwind CSS & Preline UI).
- **Espaces Dédiés** : Tableaux de bord spécifiques pour les Étudiants (suivi), les Entreprises (gestion d'offres) et les Administrateurs (modération).
- **Système de Feedback** : Collecte et analyse des avis pour garantir la qualité des expériences de stage.

---

## Écosystème Technique
- **Backend Core** : PHP 8.4 avec le framework Laravel 12.x (MVC, Services Pattern).
- **Frontend Dynamique** : Blade, Alpine.js pour l'interactivité légère, et Tailwind CSS.
- **Workflow de Build** : Utilisation de Vite pour une compilation ultra-rapide.
- **Stockage de Données** : Base de données relationnelle MySQL 8.
- **Gestion des Fichiers** : Upload sécurisé des CVs et logos via le Storage Laravel.

---

## Documentation du Projet
Accédez aux différentes ressources de conception et d'analyse :
- [**📂 Analyse**](./Analyse/) : Étude des besoins, Cas d'utilisation et Diagrammes UML.
- [**🎨 Maquettes**](./Maquettes/) : Prototypes haute fidélité et parcours utilisateurs UX/UI.
- [**📊 Presentation**](./Presentation/) : Support visuel pour la soutenance technique du projet.
- [**📄 Rapport**](./Rapport/) : Documentation finale détaillant l'ensemble du cycle de développement.

---

## Cadre Académique
> **Projet de Fin d'Études (PFE)** — Solicode Tanger.  
> **Auteur :** Salma Akajou  
> **Encadrant :** M. ESSARRAJ Fouad  
> **Session :** 2025/2026

---

## Guide d'Installation (Développement)
```bash
# Se déplacer dans le dossier du projet Laravel
cd stage_flow

# Lancer le serveur de développement
php artisan serve

# Build et compilation des assets
npm install
npm run dev
```
