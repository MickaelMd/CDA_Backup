-- Active: 1744794523467@@127.0.0.1@3306@papyrus

-- Exercice réalisé sur la base "papyrus"

USE papyrus;

-- Cas PAPYRUS : Manipuler les données

-- LE TRAVAIL A FAIRE

-- Vous devez préparer le développement de l’application, et coder les
-- requêtes définies dans les besoins en langage SQL.
-- Quelques conseils pour l’écriture d’une clause SELECT :

--  Déterminer les tables à mettre en jeu, les inclure dans la clause
-- FROM.

--  Décider quels sont les attributs à visualiser, les inclure dans la
-- clause SELECT.

--  Les expressions présentes dans la liste de sélection d’une requête (clause SELECT) avec la clause GROUP BY doivent être des
-- fonctions d’agrégation ou apparaître dans la liste GROUP BY.

--  Déterminer les conditions limitant la recherche : les conditions
-- portant sur les groupes doivent figurer dans une clause HAVING,
-- celles portant sur des valeurs individuelles dans une clause
-- WHERE.

--  Pour employer une fonction sur les groupes dans une clause
-- WHERE, ou si on a besoin de la valeur d’un attribut d’une autre
-- table, il est nécessaire d’employer une requête imbriquée.

--  Préciser l’ordre d’apparition des t_uples du résultat dans une
-- clause ORDER BY. 

-----------------------------------------------------------------------

-- fournis -> fournisseur
-- produit -> article en stock
-- entcom -> en-tête commande 
-- ligcom -> détail d’une commande
-- vente -> tarifs par fournisseur

/* 
Tables et leurs attributs :

PRODUIT (CODART, LIBART, STKALE, STKPHY, QTEANN, UNIMES)
- CODART   : Code article
- LIBART   : Libellé de l’article
- STKALE    : Stock d’alerte
- STKPHY   : Stock physique
- QTEANN   : Quantité annuelle
- UNIMES   : Unité de mesure

ENTCOM (NUMCOM, OBSCOM, DATCOM, NUMFOU)
- NUMCOM   : Numéro de commande
- OBSCOM   : Observations
- DATCOM   : Date de commande
- NUMFOU   : Numéro du fournisseur

LIGCOM (NUMCOM, NUMLIG, CODART, QTECDE, PRIUNI, QTELIV, DERLIV)
- NUMCOM   : Numéro de commande
- NUMLIG   : Numéro de ligne
- CODART   : Code article
- QTECDE   : Quantité commandée
- PRIUNI   : Prix unitaire
- QTELIV   : Quantité livrée
- DERLIV   : Date de dernière livraison

FOURNIS (NUMFOU, NOMFOU, RUEFOU, POSFOU, VILFOU, CONFOU, SATISF)
- NUMFOU   : Numéro du fournisseur
- NOMFOU   : Nom du fournisseur
- RUEFOU   : Rue
- POSFOU   : Code postal
- VILFOU   : Ville
- CONFOU   : Contact
- SATISF   : Satisfaction (note)

VENTE (CODART, NUMFOU, DELLIV, QTE1, PRIX1, QTE2, PRIX2, QTE3, PRIX3)
- CODART   : Code article
- NUMFOU   : Numéro du fournisseur
- DELLIV   : Délai de livraison
- QTE1/2/3 : Seuils de quantité
- PRIX1/2/3: Prix unitaire par seuil
*/


-- LES BESOINS D’AFFICHAGE

-- 1. Quelles sont les commandes du fournisseur 09120 ?

SELECT * FROM entcom WHERE numfou = 9120;

-- 2. Afficher le code des fournisseurs pour lesquels des commandes ont été
-- passées.

SELECT DISTINCT numfou 
FROM entcom; 

-- 3. Afficher le nombre de commandes fournisseurs passées, et le nombre
-- de fournisseur concernés.

SELECT COUNT(numcom) AS nb_commande, COUNT(DISTINCT numfou) AS nb_fournisseur
FROM entcom;

-- 4. Editer les produits ayant un stock inférieur ou égal au stock d'alerte et
-- dont la quantité annuelle est inférieur est inférieure à 1000
-- (informations à fournir : n° produit, libellé produit, stock, stock actuel
-- d'alerte, quantité annuelle)

SELECT codart, libart, stkphy, stkale, qteann
FROM produit
WHERE stkphy <= stkale
AND qteann < 1000;


-- 5. Quels sont les fournisseurs situés dans les départements 75 78 92 77 ?
-- L’affichage (département, nom fournisseur) sera effectué par
-- département décroissant, puis par ordre alphabétique

SELECT nomfou, SUBSTRING(posfou, 1, 2) AS nodep
FROM fournis
WHERE SUBSTRING(posfou, 1, 2) IN ("75", "78", "92", "77")
ORDER BY nodep DESC, nomfou ASC;

-- 6. Quelles sont les commandes passées au mois de mars et avril ?

SELECT numcom, datcom, numfou
FROM entcom
WHERE MONTH(datcom) IN (3, 4);

-- 7. Quelles sont les commandes du jour qui ont des observations
-- particulières ?
-- (Affichage numéro de commande, date de commande)

SELECT numcom, obscom
FROM entcom
WHERE obscom IS NOT NULL AND TRIM(obscom) != '';


-- 8. Lister le total de chaque commande par total décroissant
-- (Affichage numéro de commande et total)

SELECT numcom, SUM(qtecde * priuni) AS total
FROM ligcom
GROUP BY numcom
ORDER BY total DESC;


-- 9. Lister les commandes dont le total est supérieur à 10 000€ ; on exclura
-- dans le calcul du total les articles commandés en quantité supérieure
-- ou égale à 1000.
-- (Affichage numéro de commande et total)

SELECT numcom, SUM(qtecde * priuni) AS total
FROM ligcom
WHERE qtecde < 1000
GROUP BY numcom
HAVING SUM(qtecde * priuni) > 10000
ORDER BY total DESC;


-- 10. Lister les commandes par nom fournisseur
-- (Afficher le nom du fournisseur, le numéro de commande et la date)

SELECT nomfou, numcom, datcom
FROM entcom
JOIN fournis ON fournis.numfou = entcom.numfou;

-- 11. Sortir les produits des commandes ayant le mot "urgent" en
-- observation?
-- (Afficher le numéro de commande, le nom du fournisseur, le libellé du
-- produit et le sous total = quantité commandée * Prix unitaire)

SELECT entcom.numcom, fournis.nomfou, produit.libart, ligcom.qtecde * ligcom.priuni AS sous_total
FROM entcom
JOIN ligcom ON ligcom.numcom = entcom.numcom
JOIN fournis ON entcom.numfou = fournis.numfou
JOIN produit ON produit.codart = ligcom.codart
WHERE entcom.obscom LIKE '%urgent%';


-- 12. Coder de 2 manières différentes la requête suivante :
-- Lister le nom des fournisseurs susceptibles de livrer au moins un article

SELECT DISTINCT nomfou
FROM fournis
JOIN vente ON vente.numfou = fournis.numfou

---------------

SELECT nomfou
FROM fournis
JOIN vente ON vente.numfou = fournis.numfou
GROUP BY nomfou
HAVING COUNT(*) >= 1;


-- 13. Coder de 2 manières différentes la requête suivante
-- Lister les commandes (Numéro et date) dont le fournisseur est celui de
-- la commande 70210 :

SELECT numcom, datcom
FROM entcom
WHERE numfou = (SELECT numfou FROM entcom WHERE numcom = 70210);

-------------------------------

SELECT e1.numcom, e1.datcom
FROM entcom e1
JOIN entcom e2 ON e1.numfou = e2.numfou
WHERE e2.numcom = 70210;


-- 14. Dans les articles susceptibles d’être vendus, lister les articles moins
-- chers (basés sur Prix1) que le moins cher des rubans (article dont le
-- premier caractère commence par R). On affichera le libellé de l’article
-- et prix1

SELECT libart, prix1
FROM produit
JOIN vente ON vente.codart = produit.codart
WHERE libart LIKE 'R%'

------------

SELECT produit.libart, vente.prix1
FROM produit
JOIN vente ON produit.codart = vente.codart
WHERE vente.prix1 < (
    SELECT MIN(vente.prix1)
    FROM produit
    JOIN vente ON produit.codart = vente.codart
    WHERE produit.libart LIKE 'R%'
);


-- 15. Editer la liste des fournisseurs susceptibles de livrer les produits
-- dont le stock est inférieur ou égal à 150 % du stock d'alerte. La liste est
-- triée par produit puis fournisseur

SELECT produit.libart, fournis.nomfou
FROM produit
JOIN vente ON produit.codart = vente.codart
JOIN fournis ON vente.numfou = fournis.numfou
WHERE produit.stkphy <= produit.stkale * 1.5
ORDER BY produit.libart, fournis.nomfou;


-- 16. Éditer la liste des fournisseurs susceptibles de livrer les produit dont
-- le stock est inférieur ou égal à 150 % du stock d'alerte et un délai de
-- livraison d'au plus 30 jours. La liste est triée par fournisseur puis
-- produit

SELECT produit.libart, fournis.nomfou
FROM produit
JOIN vente ON produit.codart = vente.codart
JOIN fournis ON vente.numfou = fournis.numfou
WHERE produit.stkphy <= produit.stkale * 1.5
AND vente.delliv <= 30
ORDER BY fournis.nomfou, produit.libart;


-- 17. Avec le même type de sélection que ci-dessus, sortir un total des
-- stocks par fournisseur trié par total décroissant

SELECT fournis.nomfou, SUM(produit.stkphy) AS total_stk
FROM produit
JOIN vente ON produit.codart = vente.codart
JOIN fournis ON vente.numfou = fournis.numfou
WHERE produit.stkphy <= produit.stkale * 1.5
AND vente.delliv <= 30
GROUP BY fournis.nomfou
ORDER BY total_stk DESC;

-- 18. En fin d'année, sortir la liste des produits dont la quantité réellement
-- commandée dépasse 90% de la quantité annuelle prévue.

SELECT produit.libart, SUM(ligcom.qtecde) AS qte_commande, produit.qteann
FROM produit
JOIN ligcom ON produit.codart = ligcom.codart
GROUP BY produit.libart, produit.qteann
HAVING SUM(ligcom.qtecde) > produit.qteann * 0.9;


-- 19. Calculer le chiffre d'affaire par fournisseur pour l'année 93 sachant
-- que les prix indiqués sont hors taxes et que le taux de TVA est 20%.

USE papyrus;

SELECT f.numfou, f.nomfou, SUM(l.qtecde * l.priuni * 1.20) AS ChiffreAffaireTTC
FROM ligcom l
JOIN entcom e ON e.numcom = l.numcom
JOIN fournis f ON f.numfou = e.numfou
WHERE YEAR(e.datcom) = 2022
GROUP BY f.numfou, f.nomfou;


-----------------------------------------------------------------------

-- LES BESOINS DE MISE A JOUR


-- 1. Application d'une augmentation de tarif de 4% pour le prix 1 et de 2%
-- pour le prix2 pour le fournisseur 9180

UPDATE vente
SET  prix1 = prix1 * 1.04, prix2 = prix2 * 1.02  
WHERE numfou = 9180;

-- 2. Dans la table vente, mettre à jour le prix2 des articles dont le prix2 est
-- null, en affectant a prix2 la valeur de prix1.

UPDATE vente
SET prix2 = prix1
WHERE prix2 < 1;

-- 3. Mettre à jour le champ obscom en positionnant '*****' pour toutes les
-- commandes dont le fournisseur a un indice de satisfaction <5

UPDATE entcom
SET entcom.obscom = "*****"
WHERE numfou IN (
   SELECT fournis.numfou
   FROM entcom
   JOIN fournis ON fournis.numfou = entcom.numfou
   WHERE satisf < 5
);

-- 4. Suppression du produit I110

DELETE FROM vente 
WHERE codart = "I110";

DELETE FROM produit 
WHERE codart = "I110";

-- 5. Suppression des entête de commande qui n'ont aucune ligne

DELETE FROM entcom
WHERE numcom IN (
    SELECT entcom.numcom
    FROM entcom
    LEFT JOIN ligcom ON ligcom.numcom = entcom.numcom
    WHERE ligcom.numcom IS NULL
);