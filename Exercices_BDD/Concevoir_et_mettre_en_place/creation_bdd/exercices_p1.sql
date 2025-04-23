-- Active: 1745306493697@@127.0.0.1@3306@Exercice_1
DROP DATABASE Exercice_1;

CREATE DATABASE Exercice_1;

USE Exercice_1;

CREATE TABLE Personne (
    per_num INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    per_nom VARCHAR(61),
    per_prenom VARCHAR(61),
    per_adresse VARCHAR(150),
    per_ville VARCHAR(100)
);

CREATE TABLE Groupe (
    gro_num INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    gro_libelle VARCHAR(50)
);

CREATE TABLE Appartient (
    per_num INT NOT NULL,
    gro_num INT NOT NULL,
    FOREIGN KEY (per_num) REFERENCES Personne(per_num),
    FOREIGN KEY (gro_num) REFERENCES Groupe(gro_num),
    PRIMARY KEY (per_num, gro_num)

);


