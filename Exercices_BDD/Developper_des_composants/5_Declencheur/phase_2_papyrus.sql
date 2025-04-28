-- Active: 1745824742066@@127.0.0.1@3306@papyrus

-- MySql : les déclencheurs, Papyrus
-- A partir de la base Papyrus. Le jeu d'essai a été constitué lors d'une séance précédente.

USE papyrus;

-- La base de données relationnelle PAPYRUS est constituée des relations suivantes :

-- PRODUIT (CODART, LIBART, STKLE, STKPHY, QTEANN, UNIMES)
-- ENTCOM (NUMCOM, OBSCOM, DATCOM, NUMFOU)
-- LIGCOM (NUMCOM, NUMLIG, CODART, QTECDE, PRIUNI, QTELIV, DERLIV)
-- FOURNIS (NUMFOU, NOMFOU, RUEFOU, POSFOU, VILFOU, CONFOU, SATISF)
-- VENTE (CODART, NUMFOU, DELLIV, QTE1, PRIX1, QTE2, PRIX2, QTE3, PRIX3)

-- Création d'un déclencheur AFTER UPDATE

-- Créer une table ARTICLES_A_COMMANDER avec les colonnes :

-- 1 . CODART : Code de l'article, voir la table produit
-- 2 . DATE : date du jour (par défaut)
-- 3 . QTE : à calculer

DROP TABLE `ARTICLE_A_COMMANDER`;

CREATE TABLE ARTICLE_A_COMMANDER (
    codart CHAR(4) NOT NULL,
    date_aac DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    qte INT,
    FOREIGN KEY (codart) REFERENCES produit(codart)
);

-- Créer un déclencheur UPDATE sur la table produit : lorsque le stock physique devient inférieur ou égal au stock d'alerte, une nouvelle ligne est insérée dans la table ARTICLES_A_COMMANDER.
-- (Attention, il faut prendre en compte les quantités déjà commandées dans la table ARTICLES_A_COMMANDER.)
-- (STKALE = Stock d’alerte, STKPHY = Stock physique)

-- Pour comprendre le problème :

-- Soit l'article I120, le stock d'alerte = 5, le stock physique = 20 

DELETE FROM ligcom WHERE numcom = 71000;
DELETE FROM entcom WHERE numcom = 71000;
DELETE FROM produit WHERE codart = "I120";

INSERT INTO `produit` (`codart`, `libart`, `stkale`, `stkphy`, `qteann`, `unimes`) VALUES
	('I120', 'Super produit de test', 5, 20, 240, 'unite');

INSERT INTO `entcom` (`numcom`, `obscom`, `datcom`, `numfou`) VALUES
	(71000, '', '2025-04-28 10:35:00', 120);

INSERT INTO `ligcom` (`numcom`, `numlig`, `codart`, `qtecde`, `priuni`, `qteliv`, `derliv`) VALUES
	(71000, 1, 'I120', 5, 470, 5, '2025-04-28');


-- 1 . Nous retirons 15 produits du stock. stock d'alerte = 5, le stock physique = 5, le stock physique n'est pas inférieur au stock d'alerte, on ne fait rien.

-- 2 . Nous retirons 1 produit du stock.
--     stock d'alerte = 5, le stock physique = 4, le stock physique est inférieur au stock d'alerte, nous devons recommander des produits.
--     Nous insérons une ligne dans la table ARTICLES_A_COMMANDER avec QTE = (stock alerte - stock physique) = 1

-- 3 . Nous retirons 2 produit du stock. stock d'alerte = 5, le stock physique = 2. Le stock physique est inférieur au stock d'alerte, nous devons recommander des produits.
--     Nous insérons une ligne dans la table ARTICLES_A_COMMANDER avec QTE = (stock alerte - stock physique) – quantité déjà commandée dans ARTICLES_A_COMMANDER : QTE = (5 - 2) – 1 = 2


DELIMITER |
CREATE TRIGGER nom [MOMENT] [EVENEMENT]  
    ON [ARTICLES_A_COMMANDER] 
    FOR EACH ROW 
    BEGIN
       -- [requête] 
    END; 
|
DELIMITER;