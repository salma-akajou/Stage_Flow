# Règle 02 : Stack Technique

L'implémentation des maquettes doit exclusivement reposer sur la stack suivante :

## 1. Tailwind CSS via CDN
Utiliser la configuration étendue pour inclure les couleurs primaires :
```javascript
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: {
          600: '#4f46e5', // Indigo-600
        }
      }
    }
  }
}
```

## 2. Preline UI
- Charger le script `preline.js`.
- Utiliser les classes standards de Preline pour les composants interactifs (modals, dropdowns, tabs).

## 3. Lucide Icons
- Charger les icônes via CDN ou SVG.
