---
trigger: always_on
type: rule
id: stageflow-visual-identity
---

# CHARTE GRAPHIQUE ET CONVENTIONS VISUELLES - STAGEFLOW

## 1. Respect Strict de la Charte Graphique
*   Toute nouvelle page ou tout nouveau composant doit se conformer rigoureusement à la **charte graphique** documentée dans le dossier `c:\Solicode\Projects\Stage_Flow\Maquettes`. 
*   Consulter les maquettes haute fidélité pour les espacements, l'arrondi des angles (généralement `rounded-xl` ou `rounded-lg`) et les alignements.

## 2. Palette de Couleurs Intégrée

Le thème Tailwind CSS v4 est configuré dans `resources/css/app.css` sous l'identifiant `--color-primary` (valeur de base Indigo `#4f46e5`).

| Token CSS | Teinte | Rôle Visuel |
|---|---|---|
| `--color-primary-50` | `#eef2ff` | Arrière-plan de sélection active, alertes info douces |
| `--color-primary-500` | `#6366f1` | Bordures actives, focus d'inputs |
| `--color-primary-600` | `#4f46e5` | Couleur primaire de boutons, en-têtes actifs |
| `--color-primary-700` | `#4338ca` | État hover des boutons primaires |
| `success` (Emerald) | `emerald-600` | Statut Candidature **Acceptée**, toast succès |
| `warning` (Amber) | `amber-500` | Statut Candidature **En attente**, toast alerte |
| `danger` (Rose) | `rose-600` | Statut Candidature **Refusée**, toast échec |

## 3. Typographie

*   **Titres principaux et En-têtes** : Police **Outfit** (`font-heading`). Donne un aspect moderne et épuré.
*   **Texte de corps et Inputs** : Police **Inter** (`font-sans`). Assure une lisibilité optimale sur tous les écrans.

## 4. Composants Clés Preline UI et Tailwind

### Badges des Candidatures
```html
<!-- En attente -->
<span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
  En attente
</span>

<!-- Acceptée -->
<span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
  Acceptée
</span>

<!-- Refusée -->
<span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
  Refusée
</span>
```

### Cartes de Contenu (Cards)
```html
<div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 dark:bg-slate-900 dark:border-slate-800">
  <!-- Contenu -->
</div>
```

### Boutons
*   **Bouton Primaire** : `bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors`
*   **Bouton Secondaire** : `bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium py-2 px-4 rounded-lg transition-colors`
*   **Bouton Danger** : `bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-4 rounded-lg transition-colors`
