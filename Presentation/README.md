---
marp: true
theme: default
_class: lead
_paginate: false
paginate: true
backgroundColor: #ffffff
style: |
  section {
    font-size: 22px;
    color: #1a1a1a;
    line-height: 1.6;
    padding: 60px 80px;
  }

  footer { 
    width: 100%; 
    text-align: right; 
    font-size: 14px; 
    color: #0B3C5D; 
  }

  .logo-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    top: 40px;   
    left: 60px;
    right: 60px;
  }

  .logo-header img { 
    height: 140px; 
    margin-left:10px; 
    margin-right:10px 
  }

  h1 { 
    color: #0B3C5D; 
    font-size: 2.8em; 
    margin-top: 100px; 
    text-align: left; 
  }

  h2 { 
    color: #0B3C5D; 
    font-size: 2em; 
    border-bottom: 3px solid #0B3C5D; 
    margin-bottom: 40px;
  }

  h3 { 
    text-align: left; 
    color: #123; 
    margin-top: 0; 
  }

  .sommaire-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
  }

  .sommaire-item {
    display: flex;
    align-items: center;
    background: #eaf2f8;
    border-radius: 12px;
    padding: 15px 20px;
    border-left: 6px solid #0B3C5D;
  }

  .sommaire-num {
    background: #0B3C5D; 
    color: white; 
    width: 35px; 
    height: 35px;
    display: flex; 
    justify-content: center; 
    align-items: center;
    border-radius: 50%; 
    font-weight: bold; 
    margin-right: 15px; 
    flex-shrink: 0;
  }

  .img-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
  }

  .img-methodo {
    width: 85%;
    height: auto;
    max-height: 450px;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(11,60,93,0.2);
  }

  .dt-card {
    background: #f4f9fc;
    padding: 30px;
    border-radius: 12px;
    border-top: 6px solid #0B3C5D;
    text-align: left;
    margin-top: 20px;
    width: 100%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }

  .tech-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
  }

  .badge-simple {
    padding: 8px 18px;
    border-radius: 6px;
    font-weight: 600;
    background-color: #0B3C5D;
    color: #ffffff !important;
    font-size: 0.85em;
    border: none;
  }

  .maquette-grid {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: flex-start;
    height: 350px;
  }
---

<div class="logo-header">
  <img src="images/ofppt-logo.png" alt="Logo Left">
  <img src="images/logo-solicode.png" alt="Logo Right">
</div>

# **Projet de Fin de Formation**
### **StageFlow : Développement d’une Solution en ligne pour la recherche et la gestion des stages**

**Réalisée par :** <span class="highlight">Salma Akajou</span>  
**Encadré par :** <span class="highlight">M. ESSARRAJ Fouad</span>  
**Filière :** Développement Mobile 

---

## Sommaire

<div class="sommaire-grid">
  <div class="sommaire-item"><div class="sommaire-num">1</div><div class="sommaire-text">Contexte du projet</div></div>
  <div class="sommaire-item"><div class="sommaire-num">2</div><div class="sommaire-text">Méthodologie de travail</div></div>
  <div class="sommaire-item"><div class="sommaire-num">3</div><div class="sommaire-text">Branche Fonctionnelle</div></div>
  <div class="sommaire-item"><div class="sommaire-num">4</div><div class="sommaire-text">Conception</div></div>
    <div class="sommaire-item"><div class="sommaire-num">5</div><div class="sommaire-text">Réalisation</div></div>
  <div class="sommaire-item"><div class="sommaire-num">6</div><div class="sommaire-text">Conclusion</div></div>
</div>

---
## 1. Contexte du projet

<div class="img-container">
  <img src="images/contexte.png" class="img-methodo" alt="Scrum">
</div>

---

## 2. Méthodologie : Design Thinking



<div class="img-container">
  <img src="images/designThinking.png" class="img-methodo" alt="Design Thinking">
</div>

---

## Méthodologie : Scrum (Agile)



<div class="img-container">
  <img src="images/scrum.png" class="img-methodo" alt="Scrum">
</div>

---

## 3. Branche Fonctionnelle : Design Thinking
###  DÉFINITION

<div class="img-container">
  <div class="dt-card" style="border-top-color: #f39c12;">
    <h4>Cadrage du problème</h4>
    <blockquote style="font-style: italic; background: white; padding: 15px; border-radius: 8px;">
      <p>Les étudiants rencontrent des difficultés à trouver des stages adaptés et à suivre leurs candidatures, tandis que les entreprises manquent d’un moyen simple pour publier et gérer leurs offres, ce qui rend le processus de stage dispersé et inefficace.</p>
      <h5>How Might We:</h5><p>Comment pourrions-nous centraliser la recherche de stages et simplifier la gestion des offres et des candidatures pour les étudiants et les entreprises ?</p>
    </blockquote>
    
  </div>
</div>

---

## Branche Fonctionnelle : Cas d'utilisation global

### Diagramme cas d'utilisation global: Partie Public

<div class="img-container">
  <img src="images/global_usecase_public.png" class="img-usecase" alt="Global Use Case public">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Diagramme cas d'utilisation global: Partie Admin

**Espace Entreprise**

<div class="img-container">
  <img src="images/global_usecase_admin_entreprise.png" class="img-usecase" alt="Global Use Case admin">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Diagramme cas d'utilisation global: Partie Admin

**Espace Admin**

<div class="img-container">
  <img src="images/global_use_case_admin.png" class="img-usecase" alt="Global Use Case admin">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Diagramme cas d'utilisation global: Partie Admin

**Espace Etudiant**

<div class="img-container">
  <img src="images/global_usecase_admin_etudiant.png" class="img-usecase" alt="Global Use Case admin">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Diagramme cas d'utilisation global: Mobile


<div class="img-container">
  <img src="images/global_usecase_mobile.png" class="img-usecase" alt="Global Use Case mobile">
</div>

---





## 4. Conception : Diagramme de classe

<h3>Modélisation des données</h3>
<div class="img-container">
  <img src="images/diagram_class.png" class="img-diagram-class" alt="MLD Diagram">
</div>

---

## 5. Réalisation : Stack technique
<div class="sommaire-grid">

  <div class="dt-card" style="margin-top:0;">
    <h4>Backend</h4>
    <ul>
      <li><strong>Framework :</strong> Laravel 12</li>
      <li><strong>Base de données :</strong> MySQL</li>
      <li><strong>Architecture :</strong> MVC / N-Tiers</li>
    </ul>
  </div>

  <div class="dt-card" style="margin-top:0; border-top-color: #27ae60;">
    <h4>Frontend</h4>
    <ul>
      <li><strong>Preline, tailwind Css</strong></li>
      <li><strong>Alpine.js</strong></li>
      <li><strong>Lucide icons</strong></li>
    </ul>
  </div>
  
</div>

---

## 5. Réalisation : Outils utilisés
<div class="sommaire-grid">

  <div class="dt-card" style="margin-top:0;">
    <ul>
      <li><strong>MySQL Workbench</strong></li>
      <li><strong>Github</strong></li>
    </ul>
  </div>

  <div class="dt-card" style="margin-top:0; border-top-color: #27ae60;">
    <ul>
      <li><strong>PlantUML</strong></li>
      <li><strong>Mermaid</strong></li>
    </ul>
  </div>


</div>


---


## Réalisation : Architecture de projet

<div class="img-container">
  <img src="images/architecture.png" class="img-methodo" alt="architecture ">
</div>

  



---

## 6. Conclusion


### Merci pour votre attention !