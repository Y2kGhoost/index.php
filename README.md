# Mini Projet PHP MySQL : Gestion des Évaluations

## Contenu du livrable

- ✅ **Code source complet de l’application**  
  Technologies : HTML/PHP + CSS (Tailwind CSS) + TypeScript (Dark Mode + jsPDF) + MySQL  
  Code source : [GitHub](https://github.com/Y2kGhoost/index.php/tree/master)

- ✅ **Script de création de la base de données**  
  Fichier SQL permettant l’initialisation de la base avec les tables nécessaires.

- ✅ **Documentation utilisateur**  
  Guide pour l’installation, l’utilisation de l’application, et les fonctionnalités principales.

- ⚙️ **(Facultatif) Rapport de projet ou manuel technique**  
  Contient la structure du projet, les choix techniques, les schémas de base de données, et la logique métier.

---

## À propos du projet

**Mini Projet PHP MySQL - Gestion des Évaluations**  
Ce projet a pour objectif de développer une application web permettant de gérer les évaluations (examens, tests, notes, etc.) des utilisateurs (étudiants, enseignants, etc.) à travers une interface simple et intuitive. Il utilise PHP côté serveur et MySQL pour la gestion de la base de données.

---

## 📁 Structure du projet

index.php/<br>
├── node_modules/ # Dépendances (Tailwind CSS, jsPDF)<br>
├── src/<br>
│ ├── assets/ # Images, logos<br>
│ ├── css/ # Fichiers CSS (via Tailwind)<br>
│ ├── html/ # Pages HTML/PHP<br>
│ ├── includes/ # Connexion et gestion BDD (PHP)<br>
│ ├── script/ # Dark Mode et export PDF (JS/TS)<br>
│ └── sql/ # Script SQL de création de BDD<br>
├── .gitignore # Exclusions Git<br>
├── package.json # Dépendances & scripts<br>
├── package-lock.json # Verrou des dépendances<br>
├── tailwind.config.js # Config Tailwind CSS<br>
└── tailwindcss.sh # Script de build CSS<br>


---

## 🛠️ Rapport Technique

### Choix techniques

- **Frontend** : HTML + Tailwind CSS pour un design réactif et épuré.
- **Backend** : PHP pour la logique métier, traitement des formulaires et requêtes SQL.
- **Base de données** : MySQL, utilisée pour stocker les utilisateurs, évaluations et résultats.
- **JavaScript/TypeScript** :
  - Mode sombre dynamique.
  - Génération de rapports PDF via jsPDF.

### Fonctionnalités principales

- Authentification des utilisateurs (enseignants/étudiants)
- Gestion des évaluations (CRUD)
- Saisie et visualisation des résultats
- Exportation en PDF des relevés de notes
- Interface responsive avec mode sombre

---

## 📘 Documentation utilisateur

### Installation

1. Cloner le dépôt :
    ```bash
    #windows:
    git clone https://github.com/Y2kGhoost/index.php.git C:\xampp\htodcs\VOTRE_DIR

    #linux:
    git clone https://github.com/Y2kGhoost/index.php.git /opt/lampp/htdocs/VOTRE_DIR
    cd /opt/lampp/htdocs/VOTRE_DIR 
    ```
2. Installer les dépendances :
    ```bash
    npm install #OBLIGATOIRE DE NODE.JS
    ./tailwindcss.sh
    ```
3. Configurer la base de données :<br>
    - Importer le fichier dans `src/SQL/DataBaseQuery.sql` dans votre serveur MySQL.
    - Modifier les informations de connexion dans `src/includes/dbh.inc.php`

---
## 📄 Licence
Projet libre à usage éducatif.
De Ilyass Gueddari GitHub: [Y2kGhoost](https://github.com/Y2kGhoost) | Zineb Eddehbi | Hiba Harbal