# AutoMoto - Plateforme Web Automobile

AutoMoto est une plateforme complète développée en **Laravel 10+** et **Tailwind CSS**.
Elle intègre :
- Un catalogue de voitures neuves
- Un système d'annonces de voitures d'occasion entre particuliers
- Un forum de discussion communautaire
- Un back-office d'administration complet

---

## 🚀 Prérequis

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB

---

## ⚙️ Installation

1. **Cloner / Télécharger le projet** et ouvrir le dossier dans le terminal.
2. **Installer les dépendances PHP** :
   ```bash
   composer install
   ```
3. **Installer les dépendances Frontend** :
   ```bash
   npm install
   ```
4. **Configuration de l'environnement** :
   Le fichier `.env` est déjà configuré avec la base de données MySQL locale : `automoto`.
   Assurez-vous que votre serveur MySQL est lancé.
   
   Créer la base de données :
   ```bash
   mysql -u root -e "CREATE DATABASE automoto;"
   ```
   *(Si votre utilisateur / mot de passe diffère, modifiez les `DB_*` dans `.env`)*

5. **Générer la clé d'application** :
   ```bash
   php artisan key:generate
   ```

6. **Lier le dossier de stockage (images)** :
   ```bash
   php artisan storage:link
   ```

7. **Migrer et générer les fausses données (Seeders)** :
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Compiler les assets** :
   ```bash
   npm run build
   ```
   *ou `npm run dev` pour le développement actif.*

9. **Lancer l'application** :
   ```bash
   php artisan serve
   ```

---

## 🔑 Accès Démo

Après l'exécution du `--seed`, voici les comptes de démonstration :

### Administrateur
- **Email :** `admin@automoto.com`
- **Mot de passe :** `password`

### Utilisateurs (exemples parmi les 10 générés)
Des utilisateurs aléatoires ont été générés. Vous pouvez créer un nouveau compte via la page d'inscription pour tester l'interface client.

---

## 📂 Architecture

Ce projet respecte l'architecture MVC propre de Laravel :
- **Models** : Les relations complexes, le système de rôles (User) et les attributs virtuels.
- **Controllers** : Séparés en deux namespaces : `Front` (public/client) et `Admin` (back-office).
- **FormRequests** : Toute la validation des données d'entrée est extraite hors des contrôleurs.
- **Policies** : La logique d'autorisation (édition/suppression d'annonces ou commentaires) est sécurisée par des Policies.
- **Views (Blade)** : Utilisation massive des **Components** (`x-car-card`, `x-flash-message`) pour garder le code modulaire. Un layout pour le site public (`app.blade.php`) et un pour l'admin (`admin.blade.php`).
