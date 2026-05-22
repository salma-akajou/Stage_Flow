---
name: stageflow-developer
description: Intégration frontend, Blade templates, Preline UI, Tailwind v4, formulaires asynchrones et Alpine.js pour StageFlow.
---

# 🎨 COMPÉTENCE : STAGEFLOW DEVELOPER

## Rôle et Domaine d'Action
Cette compétence gère l'interface utilisateur de **StageFlow**. Elle assure l'écriture de Blade propre, sémantique et réactive, ainsi que l'utilisation cohérente de la charte graphique et des composants dynamiques (onglets, modales, toasts).

## Organisation des Squelettes (Layouts)

Le projet intègre trois structures de pages distinctes selon l'espace utilisateur :

1.  **`layouts/student.blade.php`** : Navigation fluide avec un en-tête épuré et des onglets pour accéder rapidement aux offres de stages, favoris, candidatures soumises et aux paramètres du profil étudiant.
2.  **`layouts/entreprise.blade.php`** : Sidebar moderne (Preline UI), axée sur l'analyse des candidatures reçues et la gestion des offres.
3.  **`layouts/admin.blade.php`** : Tableau de bord sobre, axé sur la gestion tabulaire des comptes et des feedbacks.

## Intégration Preline UI et Interactivité Alpine.js

### 1. Affichage Asynchrone dans les Modales (AJAX)
Pour éviter les rechargements complets de pages, StageFlow s'appuie sur des requêtes AJAX combinées avec Alpine.js pour charger le profil d'une entreprise ou le CV d'un candidat directement dans une modale.

**Exemple d'affichage d'un profil entreprise dans une modale :**
```html
<div x-data="{ open: false, content: '', chargement: false }">
  <!-- Bouton d'activation -->
  <button @click="open = true; chargement = true; fetch('/student/entreprises/' + id + '/profile')
    .then(res => res.text())
    .then(html => { content = html; chargement = false; })" 
    class="text-primary-600 hover:text-primary-700">
    Voir le profil
  </button>

  <!-- Structure de la Modale -->
  <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
    <div @click.outside="open = false" class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6">
      <div x-show="chargement" class="flex justify-center p-8">
        <!-- Spinner Preline -->
        <div class="animate-spin inline-block w-6 h-6 border-2 border-primary-600 rounded-full border-t-transparent"></div>
      </div>
      <div x-show="!chargement" x-html="content"></div>
    </div>
  </div>
</div>
```

### 2. Gestion des Toasts Applicatifs
Toute action CUD (ex: enregistrement d'une candidature, suppression d'un favori) doit afficher une notification Toast temporaire.

```html
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
     class="fixed bottom-4 right-4 z-50 flex items-center p-4 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl shadow-lg">
  <p class="text-sm font-medium">Action effectuée avec succès !</p>
</div>
```
