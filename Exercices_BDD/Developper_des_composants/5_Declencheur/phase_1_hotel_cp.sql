-- Active: 1745824742066@@127.0.0.1@3306@cp


-- Sur la base hotel

USE hotel; 

-- A partir de l'exemple précédent, créez les déclencheurs suivants :

-- 1 . modif_reservation : interdire la modification des réservations (on autorise l'ajout et la suppression).

DELIMITER |
CREATE TRIGGER modif_reservation
BEFORE UPDATE ON reservation
FOR EACH ROW
BEGIN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Modification des réservations interdite.';
END;
|
DELIMITER ;


-- 2 . insert_reservation : interdire l'ajout de réservation pour les hôtels possédant déjà 10 réservations.

DELIMITER |
CREATE TRIGGER insert_reservation
BEFORE INSERT ON reservation
FOR EACH ROW
BEGIN
    DECLARE nb_res INT;

    SELECT COUNT(*)
    INTO nb_res
    FROM reservation r
    JOIN chambre c ON r.res_cha_id = c.cha_id
    WHERE c.cha_hot_id = (SELECT cha_hot_id FROM chambre WHERE cha_id = NEW.res_cha_id);

    IF nb_res >= 10 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ajout interdit.';
    END IF;
END;
|
DELIMITER ;



-- 3 . insert_reservation2 : interdire les réservations si le client possède déjà 3 réservations.


DELIMITER |
CREATE TRIGGER insert_reservation2
BEFORE INSERT ON reservation
FOR EACH ROW
BEGIN
    DECLARE nb_res INT;

    SELECT COUNT(*)
    INTO nb_res
    FROM reservation
    WHERE res_cli_id = NEW.res_cli_id;


    IF nb_res >= 3 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Réservation interdite : le client a déjà 3 réservations.';
    END IF;
END;
|
DELIMITER ;



-- SELECT cli_nom, COUNT(cli_nom) AS nb_res
-- FROM reservation
-- JOIN client ON reservation.res_cli_id = client.cli_id
-- JOIN chambre ON reservation.res_cha_id = chambre.cha_id
-- GROUP BY cli_nom;

-- 4 . insert_chambre : lors d'une insertion, on calcule le total des capacités des chambres pour l'hôtel, si ce total est supérieur à 50, on interdit l'insertion de la chambre.

DELIMITER |
CREATE TRIGGER insert_chambre
BEFORE INSERT ON chambre
FOR EACH ROW
BEGIN
    DECLARE total_capa INT;

    SELECT IFNULL(SUM(cha_capacite), 0)
    INTO total_capa
    FROM chambre
    WHERE cha_hot_id = NEW.cha_hot_id;

    SET total_capa = total_capa + NEW.cha_capacite;

    IF total_capa > 50 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Insertion interdite : capacité totale dépassée (max 50).';
    END IF;
END;
|
DELIMITER ;

-- SELECT IFNULL(SUM(cha_capacite), 0)
-- FROM chambre
-- WHERE cha_hot_id = 6; 


                                --  Part 2 --


-- Travail à réaliser : 
-- Sur la base de commande_produit (cp).
USE cp;

DELIMITER |
CREATE TRIGGER maj_total AFTER INSERT ON lignedecommande
    FOR EACH ROW
    BEGIN
    DECLARE id_c INT;
    DECLARE tot DOUBLE;
    SET id_c = NEW.id_commande; -- nous captons le numéro de commande concerné
    SET tot = (SELECT sum(prix*quantite) FROM lignedecommande WHERE id_commande=id_c); -- on recalcule le total
        -- SET tot = ??? (prévoir le calcul de la remise) 
    UPDATE commande SET total=tot WHERE id=id_c; -- on stocke le total dans la table commande
    END;
|
DELIMITER ;

-- 1 . Mettez en place ce trigger, puis ajoutez un produit dans une commande, vérifiez que le champ total est bien mis à jour.

INSERT INTO lignedecommande(id_commande, id_produit, quantite, prix)
VALUES (1, 4, 1, 6700);

-- 2 . Ce trigger ne fonctionne que lorsque l'on ajoute des produits dans la commande, les modifications ou suppressions ne permettent pas de recalculer le total. Modifiez le code ci-dessus pour faire en sorte que la modification ou la suppression de produit recalcule le total de la commande.
-- 3 . Un champ remise était prévu dans la table commande, il contient le coefficient de remise à appliquer à la commande. Prenez en compte ce champ dans le code de votre trigger.


DELIMITER |

CREATE TRIGGER update_ajout_produit
BEFORE UPDATE ON lignedecommande
FOR EACH ROW
BEGIN

 DECLARE id_c INT;
    DECLARE tot DOUBLE;
    SET id_c = NEW.id_commande; -- nous captons le numéro de commande concerné
    SET tot = (SELECT sum(prix*quantite) FROM lignedecommande WHERE id_commande=id_c); -- on recalcule le total
    SET tot = tot * (1 - (SELECT remise FROM commande WHERE id = NEW.id_commande) / 100);
    UPDATE commande SET total=tot WHERE id=id_c; -- on stocke le total dans la table commande

END ;
DELIMITER ;

----------------------------

DELIMITER |

CREATE TRIGGER delete_ajout_produit
AFTER DELETE ON lignedecommande
FOR EACH ROW
BEGIN

 DECLARE id_c INT;
    DECLARE tot DOUBLE;
    SET id_c = OLD.id_commande; -- nous captons le numéro de commande concerné
    SET tot = (SELECT sum(prix*quantite) FROM lignedecommande WHERE id_commande=id_c); -- on recalcule le total
    SET tot = tot * (1 - (SELECT remise FROM commande WHERE id = OLD.id_commande) / 100);
    UPDATE commande SET total=tot WHERE id=id_c; -- on stocke le total dans la table commande

END ;
DELIMITER ;