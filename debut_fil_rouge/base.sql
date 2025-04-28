-- Active: 1745306493697@@127.0.0.1@3306@green_village
CREATE DATABASE green_village;

USE green_village;

CREATE TABLE commercial(
   id_commercial INT AUTO_INCREMENT,
   nom VARCHAR(60) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL UNIQUE,
   telephone VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_commercial)
);

CREATE TABLE categorie(
   id_categorie INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   image VARCHAR(100) NOT NULL,
   active BOOLEAN NOT NULL DEFAULT TRUE,
   PRIMARY KEY(id_categorie)
);

CREATE TABLE fournisseur(
   id_fournisseur INT AUTO_INCREMENT,
   nom VARCHAR(60) NOT NULL,
   email VARCHAR(100) NOT NULL UNIQUE,
   telephone VARCHAR(50) NOT NULL,
   adresse VARCHAR(150) NOT NULL,
   id_commercial INT NOT NULL,
   PRIMARY KEY(id_fournisseur),
   FOREIGN KEY(id_commercial) REFERENCES commercial(id_commercial)
);

CREATE TABLE sous_categorie(
   id_sous_categorie INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   image VARCHAR(100) NOT NULL,
   active BOOLEAN NOT NULL DEFAULT TRUE,
   id_categorie INT NOT NULL,
   PRIMARY KEY(id_sous_categorie),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie)
);

CREATE TABLE produit(
   id_produit INT AUTO_INCREMENT NOT NULL,
   libelle_court VARCHAR(50) NOT NULL,
   libelle_long VARCHAR(500) NOT NULL,
   image VARCHAR(100) NOT NULL,
   prix_ht DECIMAL(15,2) NOT NULL,
   prix_fournisseur DECIMAL(15,2) NOT NULL,
   stock INT NOT NULL,
   active BOOLEAN NOT NULL DEFAULT TRUE,
   id_fournisseur INT NOT NULL,
   id_sous_categorie INT NOT NULL,
   PRIMARY KEY(id_produit),
   FOREIGN KEY(id_fournisseur) REFERENCES fournisseur(id_fournisseur),
   FOREIGN KEY(id_sous_categorie) REFERENCES sous_categorie(id_sous_categorie)
);

CREATE TABLE client(
   id_client INT AUTO_INCREMENT NOT NULL,
   ref_client VARCHAR(50) NOT NULL UNIQUE,
   nom VARCHAR(60) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   telephone VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL UNIQUE,
   pass VARCHAR(255) NOT NULL,
   type_client BOOLEAN NOT NULL DEFAULT TRUE,
   coefficient DECIMAL(15,2) NOT NULL,
   adresse_livraison VARCHAR(150) NOT NULL,
   adresse_facturation VARCHAR(150) NOT NULL,
   id_commercial INT NOT NULL,
   PRIMARY KEY(id_client), 
   FOREIGN KEY(id_commercial) REFERENCES commercial(id_commercial)
);

CREATE TABLE commande(
   id_commande INT AUTO_INCREMENT NOT NULL, 
   ref_commande VARCHAR(50) NOT NULL UNIQUE,  
   date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   mode_paiement VARCHAR(50) NOT NULL,
   statut VARCHAR(50) NOT NULL,
   tva INT NOT NULL,
   reduction DECIMAL(15,2) NOT NULL,
   total DECIMAL(15,2) NOT NULL,
   total_ht DECIMAL(15,2) NOT NULL,
   ref_facture VARCHAR(50) NOT NULL,
   date_facture DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   ref_client VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_commande), 
   UNIQUE(ref_facture),
   FOREIGN KEY(ref_client) REFERENCES client(ref_client)
);


CREATE TABLE detail_commande(
   id_details INT AUTO_INCREMENT,
   quantite INT NOT NULL,
   prix DECIMAL(15,2) NOT NULL,
   id_produit INT NOT NULL,
   ref_commande VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_details),
   FOREIGN KEY(id_produit) REFERENCES produit(id_produit),
   FOREIGN KEY(ref_commande) REFERENCES commande(ref_commande)
);

CREATE TABLE livraison(
   id_livraison INT AUTO_INCREMENT,
   etat VARCHAR(50) NOT NULL,
   date_livraison DATETIME NOT NULL,
   ref_commande VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_livraison),
   FOREIGN KEY(ref_commande) REFERENCES commande(ref_commande)
);

CREATE TABLE achemine(
   id_produit INT,
   id_livraison INT,
   quantite_livree INT,
   PRIMARY KEY(id_produit, id_livraison),
   FOREIGN KEY(id_produit) REFERENCES produit(id_produit),
   FOREIGN KEY(id_livraison) REFERENCES livraison(id_livraison)
);
