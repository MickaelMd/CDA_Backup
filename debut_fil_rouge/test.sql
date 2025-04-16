CREATE TABLE facture (
   Id_facture INT AUTO_INCREMENT,
   date_facture DATETIME NOT NULL,
   PRIMARY KEY(Id_facture)
);

CREATE TABLE commercial (
   Id_commercial INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   telephone VARCHAR(50) NOT NULL,
   PRIMARY KEY(Id_commercial)
);

CREATE TABLE categorie (
   Id_categorie INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   image VARCHAR(100) NOT NULL,
   active BOOLEAN NOT NULL,
   PRIMARY KEY(Id_categorie)
);

CREATE TABLE fournisseur (
   Id_fournisseur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   telephone VARCHAR(50) NOT NULL,
   adresse VARCHAR(50) NOT NULL,
   Id_commercial INT NOT NULL,
   PRIMARY KEY(Id_fournisseur),
   FOREIGN KEY(Id_commercial) REFERENCES commercial(Id_commercial)
);

CREATE TABLE livraison (
   Id_livraison INT AUTO_INCREMENT,
   etat VARCHAR(50) NOT NULL,
   date_livraison DATETIME NOT NULL,
   PRIMARY KEY(Id_livraison)
);

CREATE TABLE sous_categorie (
   Id_sous_categorie INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   image VARCHAR(100) NOT NULL,
   active BOOLEAN NOT NULL,
   Id_categorie INT NOT NULL,
   PRIMARY KEY(Id_sous_categorie),
   FOREIGN KEY(Id_categorie) REFERENCES categorie(Id_categorie)
);

CREATE TABLE commande (
   Id_commande INT AUTO_INCREMENT,
   date_commande DATETIME NOT NULL,
   mode_paiement VARCHAR(50) NOT NULL,
   statut VARCHAR(50) NOT NULL,
   tva INT NOT NULL,
   reduction DECIMAL(15,2) NOT NULL,
   total DECIMAL(15,2) NOT NULL,
   total_ht DECIMAL(15,2) NOT NULL,
   Id_facture INT NOT NULL,
   PRIMARY KEY(Id_commande),
   FOREIGN KEY(Id_facture) REFERENCES facture(Id_facture)
);

CREATE TABLE produit (
   Id_produit INT AUTO_INCREMENT,
   libelle_court VARCHAR(50) NOT NULL,
   libelle_long VARCHAR(500) NOT NULL,
   image VARCHAR(50) NOT NULL,
   prix_ht DECIMAL(15,2) NOT NULL,
   prix_fournisseur DECIMAL(15,2) NOT NULL,
   stock INT NOT NULL,
   active BOOLEAN NOT NULL,
   ref_fournisseur VARCHAR(50) NOT NULL,
   Id_fournisseur INT NOT NULL,
   PRIMARY KEY(Id_produit),
   FOREIGN KEY(Id_fournisseur) REFERENCES fournisseur(Id_fournisseur)
);

CREATE TABLE client (
   Id_client INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   telephone VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL,
   pass VARCHAR(255) NOT NULL,
   type_client BOOLEAN NOT NULL,
   coefficient DECIMAL(15,2) NOT NULL,
   adresse_livraison VARCHAR(100) NOT NULL,
   adresse_facturation VARCHAR(100) NOT NULL,
   ref_client VARCHAR(50) NOT NULL,
   Id_commercial INT NOT NULL,
   PRIMARY KEY(Id_client),
   FOREIGN KEY(Id_commercial) REFERENCES commercial(Id_commercial)
);

CREATE TABLE detail (
   Id_details INT AUTO_INCREMENT,
   quantite INT NOT NULL,
   prix DECIMAL(15,2) NOT NULL,
   Id_commande INT NOT NULL,
   PRIMARY KEY(Id_details),
   FOREIGN KEY(Id_commande) REFERENCES commande(Id_commande)
);

CREATE TABLE Est_dans (
   Id_produit INT,
   Id_sous_categorie INT,
   PRIMARY KEY(Id_produit, Id_sous_categorie),
   FOREIGN KEY(Id_produit) REFERENCES produit(Id_produit),
   FOREIGN KEY(Id_sous_categorie) REFERENCES sous_categorie(Id_sous_categorie)
);

CREATE TABLE Passe (
   Id_commande INT,
   Id_client INT,
   PRIMARY KEY(Id_commande, Id_client),
   FOREIGN KEY(Id_commande) REFERENCES commande(Id_commande),
   FOREIGN KEY(Id_client) REFERENCES client(Id_client)
);

CREATE TABLE Est_transmis (
   Id_commande INT,
   Id_livraison INT,
   PRIMARY KEY(Id_commande, Id_livraison),
   FOREIGN KEY(Id_commande) REFERENCES commande(Id_commande),
   FOREIGN KEY(Id_livraison) REFERENCES livraison(Id_livraison)
);

CREATE TABLE Recupere (
   Id_facture INT,
   Id_details INT,
   PRIMARY KEY(Id_facture, Id_details),
   FOREIGN KEY(Id_facture) REFERENCES facture(Id_facture),
   FOREIGN KEY(Id_details) REFERENCES detail(Id_details)
);

CREATE TABLE Inclut (
   Id_produit INT,
   Id_details INT,
   PRIMARY KEY(Id_produit, Id_details),
   FOREIGN KEY(Id_produit) REFERENCES produit(Id_produit),
   FOREIGN KEY(Id_details) REFERENCES detail(Id_details)
);
