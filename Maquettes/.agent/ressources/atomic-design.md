# Ressource : Atomic Design

Le projet **StageFlow** utilise une architecture de composants isolés pour maximiser la réutilisation.

## Les Niveaux

### 1. Atoms (Atomes)
Éléments de base indivisibles.
- Boutons
- Inputs
- Badges (états de candidature)
- Liens de navigation

### 2. Molecules (Molécules)
Combinaisons d'atomes formant un bloc fonctionnel.
- `auth-card` : Formulaire de login.
- `stage-card` : Carte affichant un stage (Logo + Titre + Bouton).
- `search-bar` : Input + Filtres.

### 3. Organisms (Non utilisé ici)
Pour ce projet, nous passons directement des molécules aux Compositions/Mockups pour garder une structure légère.

### 4. Mockups
Pages complètes assemblant les molécules.
