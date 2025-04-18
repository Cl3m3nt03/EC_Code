# 🚀 Coding Tool Box – Guide d'installation

Bienvenue dans **Coding Tool Box**, un outil complet de gestion pédagogique conçu pour la Coding Factory.  
Ce projet Laravel inclut la gestion des groupes, promotions, étudiants, rétro (Kanban), QCM  dynamiques, et bien plus.

---

## 📦 Prérequis

Assurez-vous d’avoir les éléments suivants installés sur votre machine :

- PHP ≥ 8.1
- Composer
- MySQL ou MariaDB
- Node.js + npm (pour les assets frontend si nécessaire)
- Laravel CLI (`composer global require laravel/installer`)

---

## ⚙️ Installation du projet

Exécutez les étapes ci-dessous pour lancer le projet en local :

### 1. Cloner le dépôt

```bash
git clone https://m_thibaud@bitbucket.org/m_thibaud/projet-web-2025.git
cd coding-tool-box
cp .env.example .env
```

### 2. Configuration de l'environnement

```bash
✍️ Ouvrez le fichier .env et configurez les paramètres liés à votre base de données :

DB_DATABASE=nom_de_votre_bdd
DB_USERNAME=utilisateur
DB_PASSWORD=motdepasse
```

### 3. Installation des dépendances PHP

```bash
composer install
```

### 4. Nettoyage et optimisation du cache

```bash
php artisan optimize:clear
```

### 5. Génération de la clé d'application

```bash
php artisan key:generate
```

### 6. Migration de la base de données

```bash
php artisan migrate
```

### 7. Population de la base (Données de test)

```bash
php artisan db:seed
```

---

## 💻 Compilation des assets (si nécessaire)

```bash
npm install
npm run dev
```

---

## 👤 Comptes de test disponibles

| Rôle       | Email                         | Mot de passe |
|------------|-------------------------------|--------------|
| **Admin**  | admin@codingfactory.com       | 123456       |
| Enseignant | teacher@codingfactory.com     | 123456       |
| Étudiant   | student@codingfactory.com     | 123456       |

---

## 🚧 Fonctionnalités principales

- 🔧 Gestion des groupes, promotions, étudiants
- 📅 Vie commune avec système de pointage
- 📊 Bilans semestriels étudiants via QCM générés par IA
- 🧠 Génération automatique de QCM par langage sélectionné
- ✅ Système de Kanban pour les rétrospectives
- 📈 Statistiques d’usage et suivi pédagogique

## ✅ Réalisation par Clément

### 📌 Création d’une rétrospective (Admin / Enseignant)

- Un outil de rétrospective agile sous forme de **Kanban** pour collecter les retours.
- Mise à jour **en temps réel** grâce à **Pusher.js** pour permettre une collaboration instantanée.
- Interface dynamique avec **jKanban**, gestion des cartes en **AJAX**, suppression via bouton dédié.

### 📌 Affichage de la liste des rétrospectives (Admin / Enseignant)

- L’enseignant ne voit que **ses propres rétrospectives**.
- L’administrateur a accès à **toutes les rétrospectives**, triées par **promotion**.

### 📌 Création automatique de groupes (Admin)

- L’administrateur sélectionne une **promotion**.
- Des groupes **homogènes** sont générés automatiquement via une **IA**, en fonction du niveau des étudiants (`skill_assessment`).
- Les anciens groupes sont pris en compte pour **éviter les doublons**.
- Les résultats des **bilans de compétence** sont également pris en compte.

## 🧪 Données de test à insérer manuellement

### 📘 Promotion

```sql
INSERT INTO `promotions` (`id`, `nom`, `created_at`, `updated_at`) VALUES 
(NULL, 'B1 Cergy', NULL, NULL),
(NULL, 'B1 Paris', NULL, NULL);

### 📘 Étudiant

```sql
INSERT INTO `users` 
(`id`, `promotion_id`, `groupe_id`, `last_name`, `first_name`, `birth_date`, `email`, `email_verified_at`, `password`, `skill_assessment`, `remember_token`, `created_at`, `updated_at`) 
VALUES
(NULL, 1, NULL, 'Martin', 'Alice', '2004-05-12', 'alice.martin@codingfactory.com', NULL, '123456', '10', NULL, NULL, NULL),
(NULL, 2, NULL, 'Durand', 'Thomas', '2005-11-23', 'thomas.durand@codingfactory.com', NULL, '123456', '13', NULL, NULL, NULL),
(NULL, 1, NULL, 'Nguyen', 'Lina', '2003-08-17', 'lina.nguyen@codingfactory.com', NULL, '123456', '9', NULL, NULL, NULL),
(NULL, 1, NULL, 'Petit', 'Lucas', '2004-01-30', 'lucas.petit@codingfactory.com', NULL, '123456', '7', NULL, NULL, NULL),
(NULL, 2, NULL, 'Moreau', 'Emma', '2005-04-15', 'emma.moreau@codingfactory.com', NULL, '123456', '15', NULL, NULL, NULL),
(NULL, 1, NULL, 'Lemoine', 'Noah', '2003-12-02', 'noah.lemoine@codingfactory.com', NULL, '123456', '15', NULL, NULL, NULL),
(NULL, 2, NULL, 'Fabre', 'Chloe', '2004-06-20', 'chloe.fabre@codingfactory.com', NULL, '123456', '10', NULL, NULL, NULL),
(NULL, 1, NULL, 'Bernard', 'Nathan', '2005-02-11', 'nathan.bernard@codingfactory.com', NULL, '123456', '10', NULL, NULL, NULL),
(NULL, 2, NULL, 'Garcia', 'Sarah', '2004-09-08', 'sarah.garcia@codingfactory.com', NULL, '123456', '20', NULL, NULL, NULL),
(NULL, 1, NULL, 'Roux', 'Hugo', '2005-07-04', 'hugo.roux@codingfactory.com', NULL, '123456', '20', NULL, NULL, NULL),
(NULL, 1, NULL, 'Delcourt', 'Manon', '2004-03-18', 'manon.delcourt@codingfactory.com', NULL, '123456', '12', NULL, NULL, NULL),
(NULL, 2, NULL, 'Benoit', 'Arthur', '2003-07-09', 'arthur.benoit@codingfactory.com', NULL, '123456', '8', NULL, NULL, NULL),
(NULL, 1, NULL, 'Renard', 'Jules', '2005-06-25', 'jules.renard@codingfactory.com', NULL, '123456', '16', NULL, NULL, NULL),
(NULL, 1, NULL, 'Colin', 'Camille', '2004-10-14', 'camille.colin@codingfactory.com', NULL, '123456', '6', NULL, NULL, NULL),
(NULL, 2, NULL, 'Lopez', 'Matteo', '2003-05-01', 'matteo.lopez@codingfactory.com', NULL, '123456', '19', NULL, NULL, NULL),
(NULL, 1, NULL, 'Aubert', 'Eva', '2005-09-12', 'eva.aubert@codingfactory.com', NULL, '123456', '11', NULL, NULL, NULL),
(NULL, 2, NULL, 'Marchand', 'Leo', '2004-12-19', 'leo.marchand@codingfactory.com', NULL, '123456', '14', NULL, NULL, NULL),
(NULL, 1, NULL, 'Rolland', 'Nina', '2003-11-30', 'nina.rolland@codingfactory.com', NULL, '123456', '7', NULL, NULL, NULL),
(NULL, 2, NULL, 'Perrot', 'Ethan', '2005-03-04', 'ethan.perrot@codingfactory.com', NULL, '123456', '17', NULL, NULL, NULL),
(NULL, 1, NULL, 'Dumas', 'Léa', '2004-01-10', 'lea.dumas@codingfactory.com', NULL, '123456', '5', NULL, NULL, NULL);

