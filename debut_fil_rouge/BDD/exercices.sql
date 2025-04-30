---------- !! Développer des composants d’accès aux données SQL et NoSQL !! ----------

-- Formaliser des requêtes à l'aide du langage SQL : 

-- Pour chacune des interrogations demandées pour la réalisation du tableau de bord (voir cahier des charges), créez un script contenant la ou les requêtes nécessaires :

-- 1. Chiffre d'affaires mois par mois pour une année sélectionnée

SELECT SUM(commande.total)
FROM commande
WHERE YEAR(date_commande) = 2025;

-- 2. Chiffre d'affaires généré pour un fournisseur

SELECT fournisseur.nom, SUM(detail_commande.prix) AS ca
FROM fournisseur
JOIN produit ON produit.id_fournisseur = fournisseur.id_fournisseur
JOIN detail_commande ON detail_commande.id_produit = produit.id_produit
GROUP BY fournisseur.nom
ORDER BY ca DESC;

-- 3. TOP 10 des produits les plus commandés pour une année sélectionnée
--     (référence et nom du produit, quantité commandée, fournisseur)

SELECT produit.id_produit, produit.libelle_court, COUNT(detail_commande.id_produit) AS quant_com, fournisseur.nom
FROM produit
JOIN fournisseur ON fournisseur.id_fournisseur = produit.id_fournisseur
JOIN detail_commande ON detail_commande.id_produit = produit.id_produit
GROUP BY produit.libelle_court
ORDER BY quant_com DESC
LIMIT 10;

-- 4. TOP 10 des produits les plus rémunérateurs pour une année sélectionnée
--     (référence et nom du produit, marge, fournisseur)

SELECT produit.id_produit, produit.libelle_court, SUM(produit.prix_ht - produit.prix_fournisseur) AS marge, fournisseur.nom
FROM produit
JOIN fournisseur ON fournisseur.id_fournisseur = produit.id_fournisseur
JOIN detail_commande ON detail_commande.id_produit = produit.id_produit
GROUP BY produit.id_produit
ORDER BY marge DESC
LIMIT 10;

-- 5. TOP 10 des clients en nombre de commandes

SELECT client.nom, COUNT(ref_commande) AS nb_commande
FROM client
JOIN commande ON commande.ref_client = client.ref_client
GROUP BY client.nom
ORDER BY nb_commande DESC
LIMIT 10;

-- 6. TOP 10 des clients en chiffre d'affaires

SELECT client.nom, client.ref_client, SUM(total_ht) AS ca
FROM client
JOIN commande ON commande.ref_client = client.ref_client
GROUP BY client.ref_client
ORDER BY ca DESC
LIMIT 10;

-- 7. Répartition du chiffre d'affaires par type de client

SELECT client.type_client, client.ref_client, SUM(total_ht) AS ca
FROM client
JOIN commande ON commande.ref_client = client.ref_client
GROUP BY client.type_client
ORDER BY ca DESC;

-- 8. Nombre de commandes en cours de livraison

SELECT COUNT(*) AS nb_liv_en_cours
FROM commande
JOIN livraison ON livraison.ref_commande = commande.ref_commande
WHERE etat = "En cours";

--------------------------------------------------------------------------------

-- Programmer des procédures stockées sur le SGBD : 

-- 1 . Créez une procédure stockée qui sélectionne les commandes non soldées (en cours de livraison)

DELIMITER |

CREATE PROCEDURE com_soldée_liv_en_cours()
BEGIN
    SELECT commande.ref_commande
    FROM commande
    JOIN livraison ON livraison.ref_commande = commande.ref_commande
    WHERE reduction = 0 AND etat = "En cours";
END

DELIMITER ;

CALL com_soldée_liv_en_cours();

-- 2 . Créer une procédure qui renvoie le délai moyen entre la date de commande et la date de facturation.

DELIMITER |

CREATE PROCEDURE avg_delai_livraison()
BEGIN 
    SELECT AVG(DATEDIFF(commande.date_commande, livraison.date_livraison)) AS delai_moyen
    FROM livraison
    JOIN commande ON commande.ref_commande = livraison.ref_commande
    WHERE livraison.etat = 'Livrée';
END 

DELIMITER ;

CALL avg_delai_livraison();

--------------------------------------------------------------------------------

-- Gérer les vues :

-- 1 . Créez une vue correspondant à la jointure Produits - Fournisseurs

CREATE VIEW v_produit_fournisseur AS
SELECT produit.libelle_court, fournisseur.nom
FROM produit
JOIN fournisseur ON fournisseur.id_fournisseur = produit.id_fournisseur;

-- 2 . Créez une vue correspondant à la jointure Produits - Catégorie/Sous catégorie

CREATE VIEW v_poduit_categorie AS
SELECT produit.libelle_court, categorie.nom AS categorie_nom, sous_categorie.nom AS sous_categorie_nom
FROM produit
JOIN sous_categorie ON sous_categorie.id_sous_categorie = produit.id_sous_categorie
JOIN categorie ON categorie.id_categorie = sous_categorie.id_categorie;

CALL avg_delai_livraison();

