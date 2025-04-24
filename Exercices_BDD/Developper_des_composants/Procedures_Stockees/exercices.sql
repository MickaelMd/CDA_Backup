-- Exercices

-- Réalisez les exercices suivants sur la base papyrus que vous adorez tous :

USE papyrus;

--------------------------------------------

-- Exercice 1 : création d'une procédure stockée sans paramètre
-- Créez la procédure stockée Lst_fournis correspondant à la requête n°2 afficher le code des fournisseurs pour lesquels une commande a été passée.
-- Exécutez la pour vérifier qu’elle fonctionne conformément à votre attente.
-- Exécutez la commande SQL suivante pour obtenir des informations sur cette procédure stockée :

SHOW CREATE PROCEDURE nom_procedure;


-- Exercice 2 : création d'une procédure stockée avec un paramètre en entrée
-- Créer la procédure stockée Lst_Commandes, qui liste les commandes ayant un libellé particulier dans le champ obscom (cette requête sera construite à partir de la requête n°11).



-- Exercice 3 : création d'une procédure stockée avec plusieurs paramètres
-- Créer la procédure stockée CA_ Fournisseur, qui pour un code fournisseur et une année entrée en paramètre, calcule et restitue le CA potentiel de ce fournisseur pour l'année souhaitée (cette requête sera construite à partir de la requête n°19).

-- On exécutera la requête que si le code fournisseur est valide, c'est-à-dire dans la table FOURNIS.

-- Testez cette procédure avec différentes valeurs des paramètres.


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