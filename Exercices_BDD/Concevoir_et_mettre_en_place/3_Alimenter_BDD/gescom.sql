-- Active: 1745306493697@@127.0.0.1@3306@gescom
-- Votre script permettra d'ajouter:

-- 1 catégorie
-- 2 sous-catégories
-- 3 produits dans chacune des sous-catégories

INSERT INTO parent_categorie(par_cat_name)
VALUES ('Informatique');

INSERT INTO categories(cat_name, cat_parent_id)
VALUES 
    ('Souris', 1),
    ('Ecran', 1);

INSERT INTO suppliers(sup_name, sup_city, sup_adresse)
VALUES ('LDLC', 'Lyon', '21 Rue Gentil');

INSERT INTO products(pro_ref, pro_name, pro_desc, pro_price, pro_publish, cat_id, sup_id)
VALUES
    (4865125876, 'Razer Viper', 'Une souris Razer', 80.99, 1, 1, 1),
    (8276284173, 'Logitech G Pro', 'Une souris Logitech', 110.99, 1, 1, 1),
    (4631974625, 'Razer Deathadder Elite', 'Une autre souris Razer', 60.00, 1, 1, 1),
    (9674258545, 'Lenovo ThinkVision', 'Un écran bureautique', 40.00, 1, 2, 1),
    (9786362514, 'AOC G486', 'Un écran pour le gaming', 160.99, 1, 2, 1),
    (9645726348, 'Samsung G6', 'Un écran avec beaucoup de Hz', 260.99, 1, 2, 1);


-- Phase 3 - Utiliser un outil d’import/export


-- Méthode 1 : via l'outil d'importation
-- Importez les données de la table customers à l'aide du fichier CSV customers.csv

-- Vous pouvez utiliser HeidiSQL, phpmyadmin, Dbeaver ou d'autres outils pour réaliser cette opération.

-- Avec l'outil d'importation d'HeidiSQL : menu Outils > importer un fichier csv puis suivre les instructions proposées.

-- Les données sont encodées en utilisant UTF-8

-- Méthode 2 : en ligne de commandes SQL
-- Refaites la même opération en utilisant la ligne de commande.

-- Pour importer ce fichier CSV, utilisez la commande SQL suivante (modifiez bien entendu dans la commande d'import le chemin/nom des fichiers CSV) :

use gescom;

LOAD DATA LOCAL INFILE '/home/mickael/Bureau/Dev/CDA_Backup/BDD/alimenter_bdd/customers.csv'
INTO TABLE customers
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
-- LINES TERMINATED BY '\r\n' (seulement sous windows)
IGNORE 1 LINES
(cus_id, cus_lastname, cus_firstname, cus_address, cus_zipcode, cus_city, cus_mail, cus_phone);

