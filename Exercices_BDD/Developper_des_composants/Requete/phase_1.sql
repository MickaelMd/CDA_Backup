-- Active: 1745306493697@@127.0.0.1@3306@base_exemple


-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
-- Déjà fait dans un précédent module ! 
-- (Full stack - 
-- https://github.com/MickaelMd/Parcours-Afpa/blob/main/AFPA_MS_Full_Stack/Exercices/sql/phase1.php
-- https://github.com/MickaelMd/Parcours-Afpa/blob/main/AFPA_MS_Full_Stack/Exercices/sql/phase2.php
-- )
-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

-- Exercice réalisé sur la base "Exemple"

USE base_exemple;

-- 1. Afficher toutes les informations concernant les employés. 

SELECT * FROM `employe`;

-- 2. Afficher toutes les informations concernant les départements.

SELECT * FROM `dept`;

-- 3. Afficher le nom, la date d\'embauche, le numéro du supérieur, le numéro de département et le salaire de tous les employés.

SELECT nom, dateemb, nosup, nodep, salaire 
FROM `employe`;

-- 4. Afficher le titre de tous les employés.

SELECT DISTINCT titre FROM `employe`;

-- 6. Afficher le nom, le numéro d'employé et le numéro du département des employés dont le titre est « Secrétaire ».

SELECT nom, prenom FROM `employe` WHERE titre = 'secrétaire';

-- 7. Afficher le nom et le numéro de département dont le numéro de département est supérieur à 40.

SELECT nom, nodept FROM `dept` WHERE nodept > 40;

-- 8. Afficher le nom et le prénom des employés dont le nom est alphabétiquement antérieur au prénom.

SELECT nom, prenom FROM `employe` WHERE nom < prenom;

-- 9. Afficher le nom, le salaire et le numéro du département des employés dont le titre est « Représentant », le numéro de département est 35 et le salaire est supérieur à 20000.


SELECT nom, salaire, nodep 
FROM `employe` 
WHERE salaire > 20000 AND titre = 'Représentant' AND nodep = 35;

-- 10.Afficher le nom, le titre et le salaire des employés dont le titre est « Représentant » ou dont le titre est « Président ».

SELECT nom, titre, salaire 
FROM `employe` 
WHERE titre = 'Représentant' || titre = 'Président';

-- 11.Afficher le nom, le titre, le numéro de département, le salaire des employés du département 34, dont le titre est « Représentant » ou « Secrétaire ».

SELECT nom, titre, nodep, salaire 
FROM `employe` 
WHERE nodep = 34 AND titre = 'Représentant' || titre = 'Secrétaire';

-- 13.Afficher le nom, et le salaire des employés dont le salaire est compris entre 20000 et 30000.

SELECT nom, salaire 
FROM `employe` 
WHERE salaire > 20000 AND salaire < 30000;

-- 15.Afficher le nom des employés commençant par la lettre « H ».

SELECT nom FROM `employe` WHERE nom LIKE 'h%';


-- 16.Afficher le nom des employés se terminant par la lettre « n ».


SELECT nom FROM `employe` WHERE nom LIKE '%n';


-- 17.Afficher le nom des employés contenant la lettre « u » en 3ème position.


SELECT nom FROM `employe` WHERE nom LIKE '__u%';

-- 18.Afficher le salaire et le nom des employés du service 41 classés par salaire croissant.

SELECT nom, salaire 
FROM `employe` 
WHERE nodep = 41 ORDER BY 'salaire';


-- 19.Afficher le salaire et le nom des employés du service 41 classés par salaire décroissant.


SELECT nom, salaire 
FROM `employe` 
WHERE nodep = 41 ORDER BY salaire ASC;

-- 20.Afficher le titre, le salaire et le nom des employés classés par titre croissant et par salaire décroissant.

SELECT titre, salaire, nom 
FROM `employe` 
ORDER BY titre AND salaire ASC;

-- 21.Afficher le taux de commission, le salaire et le nom des employés classés par taux de commission croissante.


SELECT tauxcom, salaire, nom 
FROM `employe` 
ORDER BY "tauxcom";


-- 22.Afficher le nom, le salaire, le taux de commission et le titre des employés dont le taux de commission n'est pas renseigné.

SELECT tauxcom, salaire, nom 
FROM `employe` 
WHERE tauxcom IS NULL;


-- 23.Afficher le nom, le salaire, le taux de commission et le titre des employés dont le taux de commission est renseigné.

SELECT tauxcom, salaire, nom 
FROM `employe` 
WHERE tauxcom IS NOT NULL;

-- 24.Afficher le nom, le salaire, le taux de commission, le titre des employés dont le taux de commission est inférieur à 15.

SELECT nom, salaire, tauxcom, titre 
FROM `employe` 
WHERE tauxcom > 15;

-- 25. Afficher le nom, le salaire, le taux de commission, le titre des employés dont le taux de commission est supérieur à 15.

SELECT nom, salaire, tauxcom, titre 
FROM `employe` 
WHERE tauxcom < 15;


-- 26.Afficher le nom, le salaire, le taux de commission et la commission des employés dont le taux de commission n'est pas nul. (la commission est calculée en multipliant le salaire par le taux de commission)

SELECT nom, salaire, tauxcom, salaire * tauxcom AS ex26com 
FROM employe W
HERE tauxcom IS NOT NULL;

-- 27. Afficher le nom, le salaire, le taux de commission, la commission des employés dont le taux de commission n'est pas nul, classé par taux de commission croissant.

SELECT nom, salaire, tauxcom, salaire * tauxcom AS ex27com 
FROM employe 
WHERE tauxcom IS NOT NULL ORDER BY tauxcom;

-- 28. Afficher le nom et le prénom (concaténés) des employés. Renommer les colonnes.

SELECT CONCAT(nom, ' ', prenom) AS newcol 
FROM employe;

-- 29. Afficher les 5 premières lettres du nom des employés.

SELECT SUBSTRING(nom, 1, 5) AS newcol 
FROM employe;

-- 30. Afficher le nom et le rang de la lettre « r » dans le nom des employés.

SELECT nom, INSTR(nom, 'r') AS rang 
FROM employe 
WHERE INSTR(nom, 'r') > 0;

-- 31. Afficher le nom, le nom en majuscule et le nom en minuscule de l'employé dont le nom est Vrante.

SELECT nom, UPPER(nom) AS nommaj, LOWER(nom) AS nommin 
FROM employe 
WHERE nom = 'Vrante';

-- 32. Afficher le nom et le nombre de caractères du nom des employés.

SELECT nom, LENGTH(nom) AS nomnum 
FROM employe;


------------- LA PARTIE 2 -------------


-- Rechercher le prénom des employés et le numéro de la région de leur département.

SELECT employe.nodep, employe.nom AS nom_employe, dept.nom AS nom_dept 
FROM `employe` 
JOIN dept ON employe.nodep = dept.nodept;

-- Rechercher le numéro du département, le nom du département, le nom des employés classés par numéro de département (renommer les tables utilisées).

SELECT employe.nom AS nom_employe, employe.nodep AS numdep, dept.nom AS nom_dept 
FROM employe 
JOIN dept ON employe.nodep = dept.nodept 
ORDER BY nodep;

-- Rechercher le nom des employés du département Distribution.

SELECT employe.nom AS nom_employe 
FROM employe JOIN dept ON employe.nodep = dept.nodept 
WHERE dept.nom = 'distribution' ORDER BY nom_employe;


-- Rechercher le nom et le salaire des employés qui gagnent plus que leur patron, et le nom et le salaire de leur patron.

SELECT employe.nom AS employe_nom, patron.nom AS patron_nom, employe.salaire AS employe_salaire, patron.salaire AS patron_salaire 
FROM employe 
LEFT JOIN employe patron 
ON employe.nosup = patron.noemp 
WHERE employe.salaire > patron.salaire;


-- Rechercher le nom et le titre des employés qui ont le même titre que Amartakaldire.

SELECT nom, titre 
FROM employe 
WHERE titre = (SELECT titre FROM employe WHERE nom = 'Amartakaldire');

-- Rechercher le nom, le salaire et le numéro de département des employés qui gagnent plus qu'un seul employé du département 31, classés par numéro de département et salaire.

SELECT nom, salaire, nodep 
FROM employe 
WHERE salaire > ANY (SELECT salaire FROM employe WHERE nodep = 31) O
RDER BY nodep, salaire;

-- Rechercher le nom, le salaire et le numéro de département des employés qui gagnent plus que tous les employés du département 31, classés par numéro de département et salaire.

SELECT nom, salaire, nodep 
FROM employe 
WHERE salaire > ALL (SELECT salaire FROM employe WHERE nodep = 31) 
ORDER BY nodep, salaire;

-- Rechercher le nom et le titre des employés du service 31 qui ont un titre que l'on trouve dans le département 32.


SELECT nom, titre, nodep 
FROM employe 
WHERE nodep = 31 AND titre IN (
    SELECT titre 
    FROM employe 
    WHERE nodep = 32
);

-- Rechercher le nom et le titre des employés du service 31 qui ont un titre qu'on ne trouve pas dans le département 32.


SELECT nom, titre, nodep 
FROM employe 
WHERE nodep = 31 AND titre NOT IN (
    SELECT titre 
    FROM employe 
    WHERE nodep = 32
);

-- Rechercher le nom, le titre et le salaire des employés qui ont le même titre et le même salaire que Fairant.
SELECT nom, titre, salaire 
FROM employe 
WHERE titre = (
    SELECT titre FROM employe WHERE nom = 'fairent'
) 
AND salaire = (
    SELECT salaire FROM employe WHERE nom = 'fairent'
);

-- Rechercher le numéro de département, le nom du département, le nom des employés, en affichant aussi les départements dans lesquels il n'y a personne, classés par numéro de département.


SELECT employe.nodep AS emp_nodep, employe.nom AS emp_nom, dept.nom AS dept_nom 
FROM employe 
RIGHT JOIN dept ON employe.nodep = dept.nodept 
ORDER BY employe.nodep;


-- 1. Calculer le nombre d'employés de chaque titre.


SELECT titre, COUNT(titre) AS nb_employes 
FROM employe 
GROUP BY titre;

-- 2. Calculer la moyenne des salaires et leur somme, par région.


SELECT nodep, AVG(salaire) AS moyenne_salaire, SUM(salaire) AS somme_salaire 
FROM employe 
GROUP BY nodep;

-- 3. Afficher les numéros des départements ayant au moins 3 employés.


SELECT nodep 
FROM employe 
GROUP BY nodep 
HAVING COUNT(*) >= 3;

-- 4. Afficher les lettres qui sont l'initiale d'au moins trois employés.


SELECT SUBSTRING(nom, 1, 1) AS initiale_nom, SUBSTRING(prenom, 1, 1) AS initiale_prenom, COUNT(*) AS nb_employes 
FROM employe 
GROUP BY initiale_nom, initiale_prenom 
HAVING COUNT(*) >= 3;

-- 5. Rechercher le salaire maximum et le salaire minimum parmi tous les salariés et l'écart entre les deux.


SELECT MIN(salaire) AS salaire_min, MAX(salaire) AS salaire_max, MAX(salaire) - MIN(salaire) AS ecart 
FROM employe;

-- 6. Rechercher le nombre de titres différents.


SELECT COUNT(DISTINCT titre) AS nb_titres_distincts 
FROM employe;

-- 7. Pour chaque titre, compter le nombre d'employés possédant ce titre.


SELECT titre, COUNT(*) AS nb_employes 
FROM employe 
GROUP BY titre;

-- 8. Pour chaque nom de département, afficher le nom du département et le nombre d'employés.


SELECT dept.nom AS nom_departement, COUNT(*) AS nb_employes 
FROM employe 
JOIN dept ON employe.nodep = dept.nodept 
GROUP BY dept.nom;

-- 9. Rechercher les titres et la moyenne des salaires par titre dont la moyenne est supérieure à la moyenne des salaires des Représentants.


SELECT titre, AVG(salaire) AS moyenne 
FROM employe 
GROUP BY titre 
HAVING AVG(salaire) > (
    SELECT AVG(salaire) FROM employe WHERE titre = 'représentant'
);

-- 10. Rechercher le nombre de salaires renseignés et le nombre de taux de commission renseignés.


SELECT COUNT(salaire) AS nb_salaires, COUNT(tauxcom) AS nb_tauxcom 
FROM employe;