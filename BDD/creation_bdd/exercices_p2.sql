-- Active: 1745306493697@@127.0.0.1@3306@Exercice_2
DROP DATABASE Exercice_2;
CREATE DATABASE Exercice_2;

CREATE TABLE Station (
    num_station INT NOT NULL AUTO_INCREMENT UNIQUE,
    nom_station VARCHAR(50)
);

CREATE TABLE Hotel (
    num_hotel INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    capacite_hotel INT,
    categorie_hotel VARCHAR(50),
    nom_hotel VARCHAR(50),
    adresse_hotel VARCHAR(100),
    num_station INT NOT NULL,
    FOREIGN KEY (num_station) REFERENCES Station(num_station)
);

CREATE TABLE Chambre (
    num_chambre INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    capacite_chambre INT,
    degre_confort INT,
    exposition VARCHAR(2),
    type_chambre VARCHAR(50),
    num_hotel INT NOT NULL,
    FOREIGN KEY (num_hotel) REFERENCES Hotel(num_hotel)
);

CREATE TABLE Client(
    num_client INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    adresse_client VARCHAR(100),
    nom_client VARCHAR(61),
    prenom_client VARCHAR(61)
);

CREATE TABLE Reservation (
    num_chambre INT,
    num_client INT,
    date_debut DATETIME,
    date_fin DATETIME,
    date_reservation DATETIME,
    montant_arrhes DECIMAL,
    prix_total DECIMAL,
    FOREIGN KEY (num_chambre) REFERENCES Chambre(num_chambre),
    FOREIGN KEY (num_client) REFERENCES Client(num_client),
    PRIMARY KEY (num_chambre, num_client)
);