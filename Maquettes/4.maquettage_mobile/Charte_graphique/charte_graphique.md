# Charte Graphique Mobile - StageFlow

**Concept Visuel Mobile** : Professionnel, Moderne, Épuré.
L'expérience mobile est conçue pour la recherche de stages en déplacement, avec des cibles tactiles optimisées et une interface épurée pour favoriser la concentration sur de petits écrans.

## 1. Couleurs (Synchronisées Desktop)

### Primaire : Indigo
- Nom Tailwind : `primary`
- Base (500) : `#6366f1` (hsl(239, 84%, 67%))
- 600 : `#4f46e5` - Principal
- Utilisation : Actions principales, boutons, indicateurs actifs.

### Sémantique :
- **Success** : `#10b981` (Emerald) - Validations, acceptations
- **Error** : `#f43f5e` (Rose) - Refus, suppressions
- **Warning** : `#f59e0b` (Amber) - En attente, alertes
- **Info** : `#3b82f6` (Blue) - Notifications

## 2. Typographie
- **Titres** : *Inter* Bold (adapté pour mobile)
- **Corps** : *Inter* Regular (lisibilité à 14px/16px)

## 3. Ergonomie Mobile (Touch First)
- **Cibles Tactiles** : 44x44px minimum pour tous les éléments interactifs.
- **Espacement** : Utilisation de `p-5` et `px-5` pour maintenir des marges de sécurité.
- **Navigation** : Bottom Navigation Bar pour un accès facile au pouce.
- **Feedbacks** : États `:active` (scale 0.98) pour confirmer l'interaction.

## 4. Composants Mobile UI
- **Bottom Sheets** : Panneaux glissants pour les filtres et menus.
- **Safe Areas** : Gestion des encoches via `pb-safe` et `pt-safe`.
- **Cartes** : Coins arrondis `rounded-2xl` pour une esthétique moderne.