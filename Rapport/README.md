# Rapport de Projet de Fin formation
**Stage Flow : Développement d’une Solution en ligne pour la recherche et gestion des stages**  
*Formation de développement Mobile – Mode Bootcamp*

---

**Réalisée par:** Salma Akajou  
**Encadré par:** Mr. Essarraj Fouad  
**Année de Formation :** 2025/2026  

---

## Table de matière

- [Liste des figures](#liste-des-figures)
- [Remerciement](#remerciement)
- [Introduction](#introduction)
- [Contexte de projet](#contexte-de-projet)
- [Cahier de charge](#cahier-de-charge)
- [Méthode de travail](#méthode-de-travail)
  - [Scrum](#scrum)
  - [Design thinking](#design-thinking)
  - [2TUP](#2tup)
- [Branche fonctionnelle](#branche-fonctionnelle)
  - [Carte d’empathie](#carte-dempathie)
  - [Définition de problème](#définition-de-problème)
  - [Idéation](#idéation)
  - [Diagramme de cas d’utilisation générale](#diagramme-de-cas-dutilisation-générale)
  - [Diagramme de cas d’utilisation sprint 1](#diagramme-de-cas-dutilisation-sprint-1)
  - [Diagramme de cas d’utilisation sprint 2](#diagramme-de-cas-dutilisation-sprint-2)
- [Branche technique](#branche-technique)
  - [Choix technologiques](#choix-technologiques)
  - [Architecture de projet](#architecture-de-projet)
  - [Prototype (Fonctionnalitées, Classes)](#prototype-fonctionnalitées-classes)
  - [Conception](#conception)
    - [Diagramme de classe](#diagramme-de-classe)
    - [Charte graphique](#charte-graphique)
    - [Maquettes](#maquettes)
- [Réalisation](#réalisation)
  - [Interfaces](#interfaces)
- [Conclusion](#conclusion)

---

## Liste des figures



---

## Remerciement

Je tiens à adresser mes sincères remerciements à Monsieur ESSARRAJ Fouad pour son accompagnement tout au long de la réalisation de ce projet de fin d’études. Grâce à ses conseils avisés, sa disponibilité et son encadrement de qualité, j’ai pu développer mes compétences techniques et mener à bien ce travail dans les meilleures conditions.

Je lui suis particulièrement reconnaissante pour sa patience, ses remarques constructives et son soutien constant, qui ont été d’une grande aide à chaque étape du projet.

J’exprime également ma gratitude à l’ensemble des formateurs et de l’équipe pédagogique pour la qualité de la formation dispensée et pour les connaissances précieuses acquises durant mon parcours.

Enfin, je remercie chaleureusement toutes les personnes qui m’ont soutenue et encouragée de près ou de loin durant la réalisation de ce projet.

---

## Introduction

La recherche de stage constitue une étape essentielle dans le parcours des étudiants en formation supérieure, permettant de mettre en pratique les compétences acquises et de préparer l’insertion professionnelle. Cependant, de nombreux étudiants rencontrent des difficultés pour trouver des stages adaptés à leur profil, en raison de la dispersion des offres, d’informations souvent incomplètes et d’un suivi des candidatures complexe.

De leur côté, les entreprises éprouvent des difficultés à gérer efficacement les candidatures et à identifier rapidement les profils correspondant à leurs besoins. Face à ce constat, le projet StageFlow vise à centraliser les offres de stages et à faciliter la mise en relation entre étudiants et entreprises, afin de rendre le processus de recherche et de gestion des stages plus simple, clair et efficace.

---

## Contexte de projet

![Contexte du projet](images/contexte.png)

Dans le cadre de ma formation en développement web, nous devons réaliser un projet de fin de formation qui reflète nos compétences et répond à un besoin réel. En discutant avec mes collègues et en observant les difficultés rencontrées par les étudiants de mon établissement, j’ai constaté que beaucoup avaient du mal à trouver un stage correspondant à leur profil.

Les offres étaient dispersées sur plusieurs sites et réseaux sociaux, et il était difficile de suivre l’état des candidatures. Cette situation a inspiré l’idée du projet Stage Flow, une application web visant à centraliser les offres de stages, simplifier la recherche pour les étudiants et faciliter la gestion des candidatures pour les entreprises.

---

## Cahier de charge

### Description
Stage Flow est une plateforme web centralisée qui permet aux étudiants de rechercher, consulter et postuler aux offres de stage, et aux entreprises de publier et gérer leurs offres et candidatures facilement. 

### Objectifs principaux :
- Centraliser la recherche et la gestion des stages.
- Simplifier la candidature pour les étudiants et le suivi des candidatures.
- Permettre aux entreprises de gérer efficacement leurs offres et candidats.
- Fournir des statistiques fiables pour améliorer la prise de décision.

### Utilisateurs et rôles :
- **Étudiant :** consulter les offres, postuler et suivre ses candidatures.
- **Entreprise :** publier, modifier, supprimer les offres, examiner les candidatures et suivre les statistiques.
- **Admin :** gérer les utilisateurs et modérer les feedbacks.

### Fonctionnalités clés :
- Création de compte et authentification.
- Recherche et filtrage des offres par secteur, ville et entreprise.
- Suivi des candidatures pour les étudiants.
- Gestion complète des offres et candidatures pour les entreprises.
- Tableau de bord et statistiques pour les entreprises.
- Notifications pour les réponses et les nouvelles offres.

### Contraintes :
- Interface simple et intuitive.
- Compatible mobile et ordinateur.
- Accès sécurisé selon le rôle utilisateur.

### Critères de réussite :
- Les étudiants peuvent trouver et postuler aux stages facilement.
- Les entreprises peuvent gérer correctement leurs offres.
- Le suivi des candidatures et les notifications fonctionnent correctement.
- Les statistiques sont claires et précises.
- Les fonctionnalités prévues dans les deux sprints sont implémentées et testées.

---

## Méthode de travail

Dans le cadre du projet "StageFlow", j’ai utilisée des méthodes de travail à la fois flexibles et bien organisées. Ces méthodes m'ont permis de répondre aux besoins du projet tout en respectant les délais et la qualité attendue. La méthode Agile, le processus 2TUP et l'approche Design thinking ont joué un rôle important dans l'organisation, la création et la réalisation du projet.

### Scrum
La méthodologie Scrum est une méthodologie agile qui permet de gérer un projet de manière flexible et collaborative, en favorisant la livraison progressive de fonctionnalités. Elle repose sur l’itération, la priorisation des tâches et la communication régulière entre les membres de l’équipe.

Dans le cadre de ce projet, nous avons organisé le travail selon les principes de Scrum, ce qui nous a permis de mieux planifier, suivre et livrer les différentes fonctionnalités de manière efficace.

**Principes clés :**
- **Transparence :** Toutes les tâches et objectifs sont visibles par l’équipe.
- **Inspection :** Chaque sprint est évalué pour détecter les améliorations possibles.
- **Adaptation :** L’équipe ajuste le plan de travail selon les résultats des sprints précédents.

![Scrum](images/scrum.jpg)

### Design thinking
Le Design Thinking est une méthodologie de conception centrée sur l’utilisateur, qui vise à comprendre ses besoins réels afin de proposer des solutions innovantes et adaptées. Cette approche favorise la créativité, la collaboration et la résolution efficace de problèmes complexes en plaçant l’expérience de l’utilisateur au cœur du processus.

Cette méthode repose sur cinq étapes principales :
1. L’empathie pour analyser les attentes des utilisateurs,
2. La définition du problème pour identifier la difficulté de l’utilisateur à résoudre.
3. L’idéation pour générer des idées,
4. Le prototypage pour concevoir des maquettes,
5. Les tests pour évaluer et améliorer la solution retenue.

Dans notre projet, le Design Thinking nous a permis de concevoir une plateforme répondant efficacement aux besoins des étudiants, des entreprises et des administrateurs.

![Design thinking](images/designthinking.png)

### 2TUP 
La méthode 2TUP (Two Tracks Unified Process) est un processus de développement logiciel itératif et incrémental, issu du Unified Process (UP). Elle se distingue par une structure en « Y » qui sépare le projet en deux branches complémentaires : la branche fonctionnelle, dédiée à l’analyse des besoins et des fonctionnalités attendues, et la branche technique, consacrée à la conception de l’architecture et au choix des technologies.

Ces deux branches évoluent en parallèle puis se rejoignent dans une phase de convergence, où sont réalisées la conception détaillée, le développement et les tests de l’application. Cette approche permet d’anticiper les contraintes techniques tout en garantissant une solution cohérente et adaptée aux besoins des utilisateurs.

![2TUP](images/2TUP.png)
---

## Branche fonctionnelle

Cette branche fonctionnelle présente l’analyse des besoins des trois principaux acteurs de la plateforme StageFlow : l’étudiant, l’entreprise et l’administrateur. À travers les cartes d’empathie, elle met en évidence les difficultés rencontrées, notamment la dispersion des offres de stage, la complexité du suivi des candidatures, la gestion manuelle des recrutements et le manque de visibilité sur l’activité globale de la plateforme. Cette compréhension des utilisateurs permet de formuler clairement le problème et d’orienter la conception vers une solution centralisée, intuitive et collaborative.

La phase d’idéation transforme ensuite ces besoins en fonctionnalités concrètes, telles que la recherche et le suivi des stages, la gestion des candidatures et l’administration du système. Enfin, les diagrammes de cas d’utilisation des sprints 1 et 2 traduisent ces fonctionnalités en interactions détaillées entre les acteurs et le système, constituant ainsi la base fonctionnelle du projet.

### Carte d’empathie

#### Profil : Apprenant en recherche de stage — Salma
L’apprenant souhaite disposer d’une plateforme centralisée lui permettant de trouver rapidement des offres de stage pertinentes et de suivre facilement l’évolution de ses candidatures.
- **Vision :** Simplifier la recherche de stage en regroupant les offres, les candidatures et les notifications au sein d’une seule interface.
- **Points de douleur (Pains) :**
  - Offres de stage dispersées sur plusieurs sites et réseaux sociaux.
  - Informations parfois incomplètes ou contradictoires.
  - Difficulté à suivre l’état des candidatures.
  - Stress lié à l’attente des réponses des entreprises.
  - Incertitude quant à l’adéquation de son profil avec les exigences des offres.
- **Gains attendus :**
  - Une plateforme unique centralisant les offres de stage.
  - Des filtres de recherche avancés pour trouver des offres adaptées.
  - Un tableau de bord permettant de suivre les candidatures en temps réel.
  - Une interface simple et intuitive.
  - Des notifications pour les nouvelles offres et les réponses des entreprises.

![Carte empathie apprenant](images/carte_d'empathie_apprenant.png)

#### Profil : Entreprise à la recherche de stagiaires — LadrissiCom
L’entreprise souhaite disposer d’une plateforme centralisée lui permettant de recevoir, trier et suivre efficacement les candidatures afin de sélectionner rapidement les profils les plus adaptés à ses besoins.
- **Vision :** Simplifier le processus de recrutement des stagiaires grâce à un outil unique de gestion des candidatures.
- **Points de douleur (Pains) :**
  - Candidatures reçues par email et réseaux sociaux de manière dispersée.
  - CV stockés dans plusieurs dossiers sans organisation claire.
  - Temps important consacré au tri manuel des profils.
  - Nombre élevé de candidatures non adaptées aux besoins de l’entreprise.
  - Absence d’un suivi clair de l’état des candidatures.
- **Gains attendus :**
  - Une plateforme unique pour centraliser toutes les candidatures.
  - Des filtres pour rechercher les profils selon les compétences demandées.
  - La possibilité d’accepter ou de refuser rapidement les candidatures.
  - Un tableau de bord simple pour visualiser et suivre les demandes.
  - Une réduction du temps consacré au traitement des candidatures.

  ![Carte empathie entreprise](images/carte_d'empathie_entreprise.png)

#### Profil : Administrateur de la plateforme 
L’administrateur souhaite disposer d’un espace de gestion lui permettant de superviser l’ensemble de la plateforme, de contrôler les utilisateurs et d’assurer son bon fonctionnement.
- **Vision :** Garantir la stabilité, la sécurité et la qualité de la plateforme à travers des outils de gestion et de supervision centralisés.
- **Points de douleur (Pains) :**
  - Difficultés à gérer efficacement les comptes des étudiants et des entreprises.
  - Absence d’une vue globale sur l’activité de la plateforme.
  - Risque de faux comptes ou de contenus inappropriés.
  - Manque d’outils pour modérer les feedbacks.
- **Gains attendus :**
  - Une interface d’administration centralisée.
  - Un tableau de bord avec des statistiques globales.
  - La possibilité de suspendre ou supprimer des comptes.
  - Des outils de modération et de contrôle du contenu.

![Carte empathie admin](images/carte_d'empathie_admin.png)

### Définition de problème

Malgré l’intérêt des étudiants et des entreprises pour les stages, leur gestion reste difficile en raison de la dispersion des offres, du manque de suivi des candidatures et de l’absence d’une plateforme centralisée. Les étudiants ont du mal à trouver les offres adaptées, les entreprises perdent du temps à trier les candidatures, et les administrateurs manquent d’une vue globale pour superviser efficacement la plateforme. 

**How Might We ?**
Comment pourrions-nous concevoir une plateforme centralisée permettant aux étudiants de trouver et suivre facilement leurs candidatures, aux entreprises de gérer efficacement leurs recrutements, et aux administrateurs de superviser l’ensemble du processus de manière simple et sécurisée ?

### Idéation

À partir des besoins identifiés lors de la phase d’empathie, plusieurs idées de solutions ont été proposées afin de répondre aux attentes des étudiants, des entreprises et des administrateurs. L’objectif était de concevoir une plateforme centralisée permettant de simplifier la recherche de stage, la gestion des candidatures et la supervision globale du système.

La solution retenue, **Stage Flow**, repose sur trois espaces principaux :
- **Espace Étudiant :** consultation des offres de stage, recherche avancée, dépôt de candidatures, suivi de leur état et réception de notifications.
- **Espace Entreprise :** publication des offres, consultation des candidatures reçues, tri des profils et gestion des réponses.
- **Espace Administrateur :** gestion des utilisateurs, modération des contenus, consultation des statistiques et supervision de la plateforme.

Cette phase d’idéation a permis de transformer les problèmes identifiés en fonctionnalités concrètes, servant de base à la modélisation UML et à la planification du développement du projet.

### Diagramme de cas d’utilisation générale

Le diagramme de cas d’utilisation de notre application Stage Flow illustre les principales fonctionnalités accessibles aux trois acteurs du système : l’étudiant, l’entreprise et l’administrateur. Il présente les actions disponibles pour chaque rôle, telles que la consultation et la candidature aux offres de stage pour les étudiants, la publication et la gestion des offres et candidatures pour les entreprises, ainsi que la gestion des comptes et des feedbacks et la consultation des statistiques pour l’administrateur. Ce diagramme permet de visualiser l’organisation fonctionnelle globale de la plateforme et de comprendre les interactions entre les utilisateurs et le système avant la phase de développement.

#### Diagramme de cas d’utilisation globale : Web

**Espace Public :** 
![diagramme use case public](images/global_usecase_public.png)

**Espace Etudiant :** 
![diagramme use case etudiant](images/global_usecase_etudiant.png)

**Espace Entreprise :** 
![diagramme use case entreprise](images/global_usecase_entreprise.png)

**Espace Administrateur :** 
![diagramme use case admin](images/global_usecase_admin.png)

#### Diagramme de cas d’utilisation globale : Mobile
![diagramme use case mobile](images/global_usecase_mobile.png)

### Diagramme de cas d’utilisation sprint 1

#### Sprint 1 : Web
Ce premier sprint correspond au MVP de Stage Flow. Il met en place les fonctionnalités essentielles permettant aux étudiants de consulter et postuler aux offres de stage, aux entreprises de publier et gérer leurs offres et candidatures, et à l’administrateur de gérer les comptes utilisateurs de manière sécurisée et modérer les feedbacks.

![diagramme use case sprint 1 web](images/use_case_sprint1_web.png)

Ce sprint établit ainsi le fonctionnement de base de la plateforme avant l’ajout des fonctionnalités avancées.

#### Sprint 1 : Mobile
Ce premier sprint de l’application mobile met en place les fonctionnalités essentielles destinées aux étudiants. Il permet de consulter la page d’accueil, d’accéder au tableau de bord, de visualiser les offres de stage ainsi que les candidatures soumises. Les données affichées dans l’application mobile sont fournies par l’API développée dans la plateforme web.

![diagramme use case sprint 1 mobile](images/use_case_sprint1_mobile.png)


Ce sprint établit ainsi les fonctionnalités de base de l’application mobile, avant l’intégration des fonctionnalités avancées et des interactions en temps réel. 

### Diagramme de cas d’utilisation sprint 2

#### Sprint 2 : Web
Ce deuxième sprint introduit les fonctionnalités avancées de la plateforme StageFlow, visant à améliorer l’expérience des différents acteurs du système. Il permet aux étudiants et aux entreprises de recevoir des notifications afin de suivre en temps réel les activités et les mises à jour importantes. De plus, les entreprises disposent de la possibilité d’exporter les candidatures au format PDF ou Excel pour faciliter leur gestion et leur analyse.

Par ailleurs, l’administrateur bénéficie de fonctionnalités de supervision avancées, notamment la consultation de statistiques détaillées et l’export des données des utilisateurs.

![diagramme use case sprint 2 web](images/use_case_sprint2_web.png)


Ce sprint renforce ainsi les capacités de gestion et de suivi de la plateforme tout en améliorant la communication entre les différents acteurs. 

#### Sprint 2 : Mobile
Ce deuxième sprint de l’application mobile apporte des fonctionnalités supplémentaires visant à enrichir l’expérience utilisateur des étudiants. Il permet notamment d’ajouter des offres aux favoris afin de les retrouver facilement, ainsi que de consulter le profil utilisateur directement depuis l’application. L’accès à ces fonctionnalités est sécurisé à travers un système d’authentification.

Ce sprint repose également sur une intégration avec le backend web via une API dédiée, garantissant la synchronisation et la continuité des données entre les deux plateformes. 

![diagramme use case sprint 2](images/use_case_sprint2_mobile.png)


Ce sprint a pour objectif d’enrichir l’application mobile avec des fonctionnalités essentielles tout en assurant une synchronisation sécurisée et fluide des données avec le backend web via une API. 

---

## Branche technique

Cette branche technique présente de manière synthétique les choix technologiques et l’architecture adoptés pour le développement du projet. Elle regroupe les principaux outils utilisés côté backend et frontend, ainsi que la base de données, tout en mettant en avant l’organisation générale de l’application selon une architecture structurée et cohérente. Elle introduit également la phase de conception, qui permet de modéliser les entités du système et de préparer la structure globale du projet avant le développement. 

### Choix technologiques

Pour la réalisation de StageFlow, plusieurs technologies ont été sélectionnées afin de garantir la performance, la sécurité, la maintenabilité et la rapidité de développement. 

**🔹 Technologies Backend**
- **PHP 8+ / Laravel 12 :** technologies utilisées pour développer le backend de l’application selon l’architecture MVC, en assurant une structure claire.
- **Native PHP :** solution permettant de transformer l’application Laravel en application mobile Android (APK).
- **Spatie Laravel Permission :** package dédié à la gestion des rôles et des permissions (administrateur, étudiant, entreprise).

**🔹 Technologies Frontend**
- **Blade Templates :** moteur de templates de Laravel pour générer des interfaces dynamiques et réutilisables.
- **Tailwind CSS & Preline :** outils utilisés pour concevoir une interface moderne et responsive.
- **Alpine.js :** bibliothèque JavaScript légère permettant d’ajouter des interactions dynamiques sans complexité.

**🔹 Base de données**
- **MySQL :** système de gestion de base de données relationnelle utilisé pour stocker les informations de l’application.

**🔹 Outils externes**
- **Tiptap :** éditeur de texte riche permettant la création et la mise en forme avancée du contenu. 
- **Vite :** outil de compilation et d’optimisation des ressources frontend. 

**🔹 Outils de modélisation et de documentation**
- **Mermaid :** outil permettant de générer des schémas et diagrammes à partir d’une syntaxe textuelle simple.
- **PlantUML :** solution utilisée pour concevoir les différents diagrammes UML nécessaires à l’analyse et à la documentation du système.

### Architecture de projet 

Le projet StageFlow repose sur une architecture structurée combinant le modèle MVC, l’architecture 3-tiers et une architecture globale intégrant l’application web, l’API et l’application mobile développée avec NativePHP. Cette organisation facilite la maintenance et l’évolution du système. 

**1. Architecture MVC et 3-Tiers**  
L’application Stage Flow est développée avec Laravel en suivant le modèle MVC (Model–View–Controller) et une architecture en trois couches :
- **Couche Présentation :** interfaces web réalisées avec Blade, Tailwind CSS, Preline et Alpine.js, ainsi que l’application mobile générée avec NativePHP.
- **Couche Métier :** logique applicative, validation des données et gestion des rôles et permissions via Spatie Laravel Permission.
- **Couche Données :** modèles Eloquent et base de données MySQL.

Cette organisation assure une séparation claire des responsabilités, facilite la maintenance et améliore l’évolutivité du système.

**2. Architecture globale**  
Le système repose sur une architecture centralisée dans laquelle l’application web, l’API REST et l’application mobile développée avec NativePHP partagent la même logique métier et la même base de données.
Cette approche garantit la cohérence des fonctionnalités sur toutes les plateformes et simplifie l’évolution de l’application.

![architecture](images/architecture.png)


### Prototype (Fonctionnalitées, Classes)

La plateforme StageFlow est organisée en plusieurs espaces sécurisés, accessibles selon le rôle de l’utilisateur (administrateur, étudiant ou entreprise). Chaque espace offre des fonctionnalités adaptées aux besoins de son utilisateur. 

**Espace Administrateur**
- Gestion des comptes utilisateurs (étudiants et entreprises).
- Validation et modération des feedbacks.
- Consultation des statistiques globales de la plateforme.
- Supervision générale du bon fonctionnement du système.

**Espace Étudiant (Web & Mobile)**
- Création et mise à jour du profil personnel.
- Recherche et consultation des offres de stage.
- Ajout d’offres aux favoris.
- Dépôt de candidatures avec CV et message de motivation.
- Suivi de l’état des candidatures.

**Espace Entreprise**
- Gestion du profil de l’entreprise.
- Publication, modification et suppression des offres de stage.
- Consultation des candidatures reçues.
- Évaluation et retour d’expérience via les feedbacks.

**Classes principales du modèle**
- **Utilisateur :** `{id, prénom, nom, email, password, statut}`
- **Étudiant :** `{filière, niveau_etudes, photo, bio, GitHub, LinkedIn}`
- **Entreprise :** `{nom_entreprise, secteur, adresse, logo, taille}`
- **Administrateur :** `gestion et supervision de la plateforme`
- **Offre :** `{titre, description, type_stage, durée, format, secteur, statut}`
- **Candidature :** `{statut, téléphone, message_motivation, date_creation}`
- **DocumentCV :** `{file_path, date_creation}`
- **Favoris :** `{date_creation}`
- **Feedback :** `{texte, note, valide}`

### Conception

Dans la phase de conception, nous avons défini la structure fonctionnelle et technique de StageFlow avant de commencer le développement. Cette étape comprend la réalisation du diagramme de classes UML afin de modéliser les principales entités du système, telles que les utilisateurs, les offres de stage, les candidatures et les favoris, ainsi que les relations entre elles. Elle inclut également la création des maquettes des interfaces pour visualiser l’organisation des pages et les principales fonctionnalités de la plateforme. Cette phase a permis d’établir une vision claire du projet et de préparer une base solide pour l’implémentation. 

#### Diagramme de classe

Le diagramme de classes représente la structure interne de l’application StageFlow et illustre les différentes entités du système ainsi que les relations entre elles. Il met en évidence les classes principales telles que Utilisateur, Étudiant, Entreprise et Administrateur, qui représentent les différents acteurs de la plateforme.

![diagramme de classe](images/diagram_class.png)

- Le diagramme de classes présente la structure interne de l’application StageFlow et les relations entre ses différentes entités. Il met en évidence les classes principales telles que Étudiant, Entreprise et Administrateur, qui représentent les acteurs de la plateforme.
- Les entreprises peuvent publier des offres de stage, tandis que les étudiants peuvent consulter les offres, postuler et suivre leurs candidatures via la classe Candidature. Le système inclut également des fonctionnalités comme les feedbacks, les favoris et les notifications, ainsi qu’un mécanisme de gestion des rôles et des permissions pour contrôler les accès.

#### Charte graphique 

La charte graphique de StageFlow définit l’identité visuelle de la plateforme afin d’assurer une interface cohérente, moderne et agréable à utiliser. Elle repose sur une palette de couleurs principalement basée sur l’indigo, reflétant la confiance et le professionnalisme. La typographie utilise des polices modernes et lisibles pour améliorer l’expérience utilisateur.

Cette charte intègre également un ensemble de composants UI standardisés (boutons, badges, états) permettant d’uniformiser les interfaces et de garantir une meilleure ergonomie sur l’ensemble de la plateforme web et mobile.

![la charte graphique](images/charte_graphique.png)

#### Maquettes

Les maquettes de l’application Stage Flow présentent une interface simple et intuitive destinée aux étudiants, aux entreprises et à l’administrateur. Elles permettent de visualiser clairement les principales fonctionnalités de la plateforme, notamment la consultation des offres de stage, le suivi des candidatures, la gestion des profils et la supervision des utilisateurs. Ces interfaces ont été conçues afin de garantir une expérience utilisateur fluide et une navigation facile sur la plateforme web et mobile. 

**Maquette 1 : Landing page**  
![maquette landing page](images/landing.png)

**Maquette 2 : Tableau de bord étudiant**  
![maquette dashboard étudiant](images/maquette_dashboard_student.png)

**Maquette 3 : Tableau de bord entreprise**  
![maquette dashboard entreprise](images/maquette_dashboard_entreprise.png)

**Maquette 4 : Tableau de bord administrateur**  
![maquette dashboard admin](images/maquette_dashboard_admin.png)

**Maquettes Mobile :**  
![maquettes de l'application mobile](images/maquettes_mobile.png)

En conclusion, ces maquettes illustrent l’interface de l’application Stage Flow sur web et mobile et donnent un aperçu global de l’organisation des écrans et de la navigation.

---

## Réalisation

La phase de réalisation constitue l’étape durant laquelle les maquettes et les spécifications définies lors de la conception sont transformées en une application fonctionnelle. Dans le cadre du projet Stage Flow, cette étape a consisté au développement de la plateforme web et mobile, en mettant en œuvre les différentes fonctionnalités liées à la gestion des stages, des candidatures et des utilisateurs. Elle a également impliqué l’intégration des technologies choisies, le respect de l’architecture du système ainsi que l’application des bonnes pratiques de développement afin de garantir une application stable, cohérente et facile à utiliser. 

### Interfaces

**Interfaces Web Sprint 1 :**  
![iterface dashboard etudiant](images/dashboard_etudiant.png)
![iterface offres etudiant](images/offres.png)
![iterface candidatures etudiant](images/candidatures_etudiant.png)
![iterface dashboard entreprise](images/dashboard_entreprise.png)
![iterface offres entreprise](images/offers.png)
![iterface candidatures entreprise](images/candidatures_entreprise.png)
**Interfaces Mobile Sprint 1 :**  
![iterfaces de l'application mobile](images/interfaces_mobile.png)


**Interfaces Sprint 2 :**  


---

## Conclusion

Ce projet de fin d’études a permis de concevoir et de développer Stage Flow, une plateforme web et mobile dédiée à la gestion des stages. Cette solution facilite la recherche de stages pour les étudiants, simplifie la gestion des candidatures pour les entreprises et fournit à l’administrateur des outils de supervision et de contrôle.

La réalisation de ce projet s’est appuyée sur les méthodologies Design Thinking, 2TUP et Scrum, qui ont permis d’identifier les besoins des utilisateurs, de structurer la conception et d’organiser le développement de manière progressive en deux sprints.

Ce travail a constitué une expérience très enrichissante, me permettant de consolider mes compétences en développement web et mobile, en modélisation UML, en conception de bases de données et en gestion de projet. Il m’a également permis de renforcer mon autonomie, mon sens de l’organisation et ma capacité à concevoir une solution répondant à des besoins concrets.