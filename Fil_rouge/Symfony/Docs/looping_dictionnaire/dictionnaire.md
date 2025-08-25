# Dictionnaire de données - Base Green Village

---

### Table : utilisateur

| Nom colonne         | Description                  | Type                                          |
| ------------------- | ---------------------------- | --------------------------------------------- |
| id                  | Id dans la table             | int(11) AUTO_INCREMENT PRIMARY KEY            |
| email               | Email utilisateur            | varchar(180) NOT NULL UNIQUE                  |
| roles               | Rôles (JSON)                 | longtext NOT NULL (json)                      |
| password            | Mot de passe                 | varchar(255) NOT NULL                         |
| nom                 | Nom utilisateur              | varchar(80) NOT NULL                          |
| prenom              | Prénom utilisateur           | varchar(80) NOT NULL                          |
| telephone           | Téléphone                    | varchar(30) DEFAULT NULL                      |
| coefficient         | Coefficient client           | decimal(5,2) DEFAULT NULL                     |
| adresse_livraison   | Adresse de livraison         | varchar(255) DEFAULT NULL                     |
| adresse_facturation | Adresse de facturation       | varchar(255) DEFAULT NULL                     |
| commercial_id       | Référence commercial associé | int(11) DEFAULT NULL, FK vers utilisateur(id) |
| is_verified         | Email vérifié ou non         | tinyint(1) NOT NULL                           |

---

### Table : reset_password_request

| Nom colonne  | Description           | Type                                           |
| ------------ | --------------------- | ---------------------------------------------- |
| id           | Id dans la table      | int(11) AUTO_INCREMENT PRIMARY KEY             |
| user_id      | Référence utilisateur | int(11) NOT NULL, FK vers utilisateur(id)      |
| selector     | Sélecteur unique      | varchar(20) NOT NULL                           |
| hashed_token | Token haché           | varchar(100) NOT NULL                          |
| requested_at | Date demande          | datetime NOT NULL (DC2Type:datetime_immutable) |
| expires_at   | Date expiration       | datetime NOT NULL (DC2Type:datetime_immutable) |

---

### Table : fournisseur

| Nom colonne   | Description                  | Type                                          |
| ------------- | ---------------------------- | --------------------------------------------- |
| id            | Id dans la table             | int(11) AUTO_INCREMENT PRIMARY KEY            |
| commercial_id | Référence commercial associé | int(11) DEFAULT NULL, FK vers utilisateur(id) |
| nom           | Nom du fournisseur           | varchar(80) NOT NULL                          |
| email         | Email fournisseur            | varchar(320) NOT NULL                         |
| telephone     | Téléphone fournisseur        | varchar(30) NOT NULL                          |
| adresse       | Adresse fournisseur          | varchar(255) NOT NULL                         |

---

### Table : produit

| Nom colonne       | Description              | Type                                          |
| ----------------- | ------------------------ | --------------------------------------------- |
| id                | Id dans la table         | int(11) AUTO_INCREMENT PRIMARY KEY            |
| sous_categorie_id | Référence sous catégorie | int(11) NOT NULL, FK vers sous_categorie(id)  |
| stock             | Stock disponible         | int(11) NOT NULL                              |
| active            | Produit visible ou non   | tinyint(1) NOT NULL                           |
| libelle_court     | Nom du produit           | varchar(80) NOT NULL                          |
| libelle_long      | Description détaillée    | longtext NOT NULL                             |
| image             | Lien image produit       | varchar(255) NOT NULL                         |
| prix_ht           | Prix hors taxe           | decimal(15,2) NOT NULL                        |
| prix_fournisseur  | Prix fournisseur         | decimal(15,2) NOT NULL                        |
| fournisseur_id    | Référence fournisseur    | int(11) DEFAULT NULL, FK vers fournisseur(id) |
| promotion         | Taux promotion           | decimal(10,5) DEFAULT NULL                    |

---

### Table : categorie

| Nom colonne | Description              | Type                               |
| ----------- | ------------------------ | ---------------------------------- |
| id          | Id dans la table         | int(11) AUTO_INCREMENT PRIMARY KEY |
| active      | Catégorie visible ou non | tinyint(1) NOT NULL                |
| nom         | Nom de la catégorie      | varchar(80) NOT NULL               |
| image       | Lien vers l'image        | varchar(255) NOT NULL              |

---

### Table : sous_categorie

| Nom colonne  | Description                   | Type                                    |
| ------------ | ----------------------------- | --------------------------------------- |
| id           | Id dans la table              | int(11) AUTO_INCREMENT PRIMARY KEY      |
| categorie_id | Référence catégorie           | int(11) NOT NULL, FK vers categorie(id) |
| active       | Sous-catégorie visible ou non | tinyint(1) NOT NULL                     |
| nom          | Nom sous-catégorie            | varchar(80) NOT NULL                    |
| image        | Lien vers image               | varchar(255) NOT NULL                   |

---

### Table : commande

| Nom colonne         | Description                      | Type                                           |
| ------------------- | -------------------------------- | ---------------------------------------------- |
| id                  | Id dans la table                 | int(11) AUTO_INCREMENT PRIMARY KEY             |
| client_id           | Référence utilisateur client     | int(11) DEFAULT NULL, FK vers utilisateur(id)  |
| commercial_id       | Référence utilisateur commercial | int(11) DEFAULT NULL, FK vers utilisateur(id)  |
| date_commande       | Date commande                    | datetime NOT NULL (DC2Type:datetime_immutable) |
| mode_paiement       | Mode de paiement                 | varchar(50) NOT NULL                           |
| statut              | Statut de la commande            | varchar(50) NOT NULL                           |
| tva                 | Pourcentage TVA                  | decimal(5,2) NOT NULL                          |
| reduction           | Réduction / promo                | decimal(5,2) DEFAULT NULL                      |
| total               | Total TTC                        | decimal(15,2) NOT NULL                         |
| total_ht            | Total HT                         | decimal(15,2) NOT NULL                         |
| adresse_livraison   | Adresse livraison                | varchar(255) NOT NULL                          |
| adresse_facturation | Adresse facturation              | varchar(255) NOT NULL                          |

---

### Table : detail_commande

| Nom colonne | Description         | Type                                   |
| ----------- | ------------------- | -------------------------------------- |
| id          | Id dans la table    | int(11) AUTO_INCREMENT PRIMARY KEY     |
| produit_id  | Référence produit   | int(11) NOT NULL, FK vers produit(id)  |
| commande_id | Référence commande  | int(11) NOT NULL, FK vers commande(id) |
| quantite    | Quantité de produit | int(11) NOT NULL                       |
| prix        | Prix TTC            | decimal(15,2) NOT NULL                 |

---

### Table : livraison

| Nom colonne | Description          | Type                                           |
| ----------- | -------------------- | ---------------------------------------------- |
| id          | Id dans la table     | int(11) AUTO_INCREMENT PRIMARY KEY             |
| commande_id | Référence commande   | int(11) DEFAULT NULL, FK vers commande(id)     |
| date        | Date livraison       | datetime NOT NULL (DC2Type:datetime_immutable) |
| etat        | État de la livraison | varchar(50) NOT NULL                           |

---
