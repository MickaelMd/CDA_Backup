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
JOIN produit ON produit.fournisseur_id = fournisseur.id
JOIN detail_commande ON detail_commande.produit_id = produit.id
GROUP BY fournisseur.nom
ORDER BY ca DESC;


-- 3. TOP 10 des produits les plus commandés pour une année sélectionnée
--     (référence et nom du produit, quantité commandée, fournisseur)

SELECT produit.id, produit.libelle_court, COUNT(detail_commande.produit_id) AS quant_com, fournisseur.nom
FROM produit
JOIN fournisseur ON fournisseur.id = produit.fournisseur_id
JOIN detail_commande ON detail_commande.produit_id = produit.id
GROUP BY produit.id, produit.libelle_court, fournisseur.nom
ORDER BY quant_com DESC
LIMIT 10;


-- 4. TOP 10 des produits les plus rémunérateurs pour une année sélectionnée
--     (référence et nom du produit, marge, fournisseur)

SELECT produit.id, produit.libelle_court, 
       SUM((produit.prix_ht - produit.prix_fournisseur) * detail_commande.quantite) AS marge, 
       fournisseur.nom
FROM produit
JOIN fournisseur ON fournisseur.id = produit.fournisseur_id
JOIN detail_commande ON detail_commande.produit_id = produit.id
GROUP BY produit.id, produit.libelle_court, fournisseur.nom
ORDER BY marge DESC
LIMIT 10;


-- 5. TOP 10 des clients en nombre de commandes

SELECT utilisateur.nom, COUNT(commande.id) AS nb_commande
FROM utilisateur
JOIN commande ON commande.client_id = utilisateur.id
GROUP BY utilisateur.nom
ORDER BY nb_commande DESC
LIMIT 10;


-- 6. TOP 10 des clients en chiffre d'affaires

SELECT utilisateur.nom, utilisateur.id AS client_id, SUM(commande.total_ht) AS ca
FROM utilisateur
JOIN commande ON commande.client_id = utilisateur.id
GROUP BY utilisateur.id, utilisateur.nom
ORDER BY ca DESC
LIMIT 10;


-- 7. Répartition du chiffre d'affaires par type de client

SELECT 
  utilisateur.roles,
  utilisateur.id AS client_id,
  SUM(commande.total_ht) AS ca
FROM utilisateur
JOIN commande ON commande.client_id = utilisateur.id
GROUP BY utilisateur.roles, utilisateur.id
ORDER BY ca DESC;


-- 8. Nombre de commandes en cours de livraison

SELECT COUNT(*) AS nb_liv_en_cours
FROM commande
JOIN livraison ON livraison.commande_id = commande.id
WHERE livraison.etat = 'En cours';


--------------------------------------------------------------------------------

-- Programmer des procédures stockées sur le SGBD : 

-- 1 . Créez une procédure stockée qui sélectionne les commandes non soldées (en cours de livraison)

DELIMITER |

CREATE PROCEDURE com_soldee_liv_en_cours()
BEGIN
    SELECT commande.id AS ref_commande
    FROM commande
    JOIN livraison ON livraison.commande_id = commande.id
    WHERE (commande.reduction = 0 OR commande.reduction IS NULL)
      AND livraison.etat = 'En cours';
END |

DELIMITER ;

CALL com_soldee_liv_en_cours();


-- 2 . Créer une procédure qui renvoie le délai moyen entre la date de commande et la date de facturation.

DELIMITER |

CREATE PROCEDURE avg_delai_livraison()
BEGIN 
    SELECT AVG(DATEDIFF(livraison.date, commande.date_commande)) AS delai_moyen
    FROM livraison
    JOIN commande ON commande.id = livraison.commande_id
    WHERE livraison.etat = 'Livrée';
END |

DELIMITER ;

CALL avg_delai_livraison();


--------------------------------------------------------------------------------

-- Gérer les vues :

-- 1 . Créez une vue correspondant à la jointure Produits - Fournisseurs

CREATE VIEW v_produit_fournisseur AS
SELECT produit.libelle_court, fournisseur.nom
FROM produit
JOIN fournisseur ON fournisseur.id = produit.fournisseur_id;


-- 2 . Créez une vue correspondant à la jointure Produits - Catégorie/Sous catégorie

CREATE VIEW v_produit_categorie AS
SELECT 
  produit.libelle_court, 
  categorie.nom AS categorie_nom, 
  sous_categorie.nom AS sous_categorie_nom
FROM produit
JOIN sous_categorie ON sous_categorie.id = produit.sous_categorie_id
JOIN categorie ON categorie.id = sous_categorie.categorie_id;


CALL avg_delai_livraison();

