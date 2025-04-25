-- Créez les vues demandées et interrogez-les pour vérifier qu’elles correspondent bien aux attentes.

-- Exercice 1 : vues sur la base hotel

USE hotel;

-- A partir de la base hotel, créez les vues suivantes :

-- 1 - Afficher la liste des hôtels avec leur station

CREATE VIEW v_hotel_station AS
SELECT hot_nom, sta_nom
FROM hotel
JOIN station ON station.sta_id = hotel.hot_sta_id;

-- 2 - Afficher la liste des chambres et leur hôtel

CREATE VIEW v_chambre_hotel AS
SELECT cha_numero, hot_nom
FROM chambre
JOIN hotel ON chambre.cha_hot_id = hotel.hot_id;

-- 3 - Afficher la liste des réservations avec le nom des clients
CREATE VIEW v_reservation_nom_client AS
SELECT res_id, cli_nom
FROM reservation
JOIN client ON client.cli_id = reservation.res_cli_id;


-- 4 - Afficher la liste des chambres avec le nom de l’hôtel et le nom de la station

CREATE VIEW v_cha_hot_sta AS
SELECT cha_numero, hot_nom, sta_nom
FROM chambre
JOIN hotel ON chambre.cha_hot_id = hotel.hot_id
JOIN station ON station.sta_id = hotel.hot_sta_id;

-- 5 - Afficher les réservations avec le nom du client et le nom de l’hôtel
CREATE VIEW v_client_hotel AS
SELECT cli_nom, hot_nom
FROM client
JOIN reservation ON reservation.res_cli_id = client.cli_id
JOIN chambre ON chambre.cha_id = reservation.res_cha_id
JOIN hotel ON hotel.hot_id = chambre.cha_hot_id;


------------------------------

-- Exercice 2 : vues sur la base papyrus

USE papyrus;

-- Réalisez les vues suivantes sur papyrus:

-- 1 - v_GlobalCde correspondant à la requête :
-- A partir de la table Ligcom, afficher par code produit,
-- la somme des quantités commandées et le prix total correspondant :
-- on nommera la colonne correspondant à la somme des quantités commandées,
-- QteTot et le prix total, PrixTot.

CREATE VIEW v_GlobalCde AS
SELECT codart, SUM(qtecde) AS QteTot, SUM(qtecde * priuni) AS PrixTot
FROM ligcom
GROUP BY codart;


-- 2 - v_VentesI100 correspondant à la requête : Afficher les ventes dont le code produit est le I100 (affichage de toutes les colonnes de la table Vente).
CREATE VIEW v_VentesI100 AS
SELECT * 
FROM vente
WHERE codart = "I100";


-- 3 - A partir de la vue précédente, créez v_VentesI100Grobrigan remontant toutes les ventes concernant le produit I100 et le fournisseur 00120.

CREATE VIEW v_VentesI100Grobrigan AS
SELECT * 
FROM vente
WHERE codart = "I100" AND numfou = 00120; 

------------------------------

SHOW CREATE VIEW v_VentesI100Grobrigan

DROP VIEW v_VentesI100Grobrigan

SELECT * FROM information_schema.views    



