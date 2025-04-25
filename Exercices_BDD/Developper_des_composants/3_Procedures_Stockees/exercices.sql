-- Active: 1744794523467@@127.0.0.1@3306@papyrus
-- Exercices

-- Réalisez les exercices suivants sur la base papyrus que vous adorez tous :

USE papyrus;

--------------------------------------------

-- Exercice 1 : création d'une procédure stockée sans paramètre
-- Créez la procédure stockée Lst_fournis correspondant à la requête n°2 afficher le code des fournisseurs pour lesquels une commande a été passée.
-- Exécutez la pour vérifier qu’elle fonctionne conformément à votre attente.
-- Exécutez la commande SQL suivante pour obtenir des informations sur cette procédure stockée :

DELIMITER //

CREATE PROCEDURE Lst_fournis()
BEGIN
    SELECT DISTINCT numfou 
    FROM entcom;
END //

DELIMITER ;

SHOW CREATE PROCEDURE Lst_fournis;
CALL Lst_fournis();


-- Exercice 2 : création d'une procédure stockée avec un paramètre en entrée
-- Créer la procédure stockée Lst_Commandes, qui liste les commandes ayant un libellé particulier dans le champ obscom (cette requête sera construite à partir de la requête n°11).

DELIMITER //

CREATE PROCEDURE Lst_Commandes()
BEGIN
    SELECT entcom.numcom, fournis.nomfou, produit.libart, ligcom.qtecde * ligcom.priuni AS sous_total
    FROM entcom
    JOIN ligcom ON ligcom.numcom = entcom.numcom
    JOIN fournis ON entcom.numfou = fournis.numfou
    JOIN produit ON produit.codart = ligcom.codart
    WHERE entcom.obscom LIKE '%urgent%';
END //

DELIMITER;

CALL Lst_Commandes;


-- Exercice 3 : création d'une procédure stockée avec plusieurs paramètres
-- Créer la procédure stockée CA_Fournisseur, qui pour un code fournisseur et une année entrée en paramètre, calcule et restitue le CA potentiel de ce fournisseur pour l'année souhaitée (cette requête sera construite à partir de la requête n°19).


DELIMITER //

CREATE PROCEDURE CA_Fournisseur()
BEGIN
    SELECT f.numfou, f.nomfou, SUM(l.qtecde * l.priuni * 1.20) AS ChiffreAffaireTTC
    FROM ligcom l
    JOIN entcom e ON e.numcom = l.numcom
    JOIN fournis f ON f.numfou = e.numfou
    WHERE YEAR(e.datcom) = 2022
    GROUP BY f.numfou, f.nomfou;
END //

DELIMITER;

CALL CA_Fournisseur();

-- On exécutera la requête que si le code fournisseur est valide, c'est-à-dire dans la table FOURNIS.

-- Testez cette procédure avec différentes valeurs des paramètres.

DELIMITER //

CREATE PROCEDURE CA_Fournisseur_2(IN p_numfou INT, IN p_annee INT)
BEGIN
    SELECT f.numfou, f.nomfou, SUM(l.qtecde * l.priuni * 1.20) AS ChiffreAffaireTTC
    FROM ligcom l
    JOIN entcom e ON e.numcom = l.numcom
    JOIN fournis f ON f.numfou = e.numfou
    WHERE YEAR(e.datcom) = p_annee
      AND f.numfou = p_numfou
    GROUP BY f.numfou, f.nomfou;
END //

DELIMITER ;

CALL CA_Fournisseur_2(120, 2022);


--------------------------------------------


-- Requêtes utiles


-- Lister les procédures stockées :

SHOW PROCEDURE STATUS;

-- Supprimer une procédure :

DROP PROCEDURE nom_procedure;

--------------------------------------------


-- Pour aller plus loin
-- http://sdz.tdct.org/sdz/rocedure-stockee.html
-- https://jcrozier.developpez.com/tutoriels/web/php/utilisation-avancee-procedures-stockees-mysql/



-- TEST

DELIMITER //

CREATE PROCEDURE test_p(IN p_test INT)
BEGIN
    SELECT * 
    FROM entcom 
    WHERE numfou = p_test;
END //

DELIMITER ;

CALL test_p(120);

