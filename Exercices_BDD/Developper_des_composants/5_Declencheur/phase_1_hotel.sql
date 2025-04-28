-- Active: 1745824742066@@127.0.0.1@3306@hotel

-- Sur la base hotel

USE hotel; 

-- A partir de l'exemple précédent, créez les déclencheurs suivants :

-- 1 . modif_reservation : interdire la modification des réservations (on autorise l'ajout et la suppression).
-- 2 . insert_reservation : interdire l'ajout de réservation pour les hôtels possédant déjà 10 réservations.
-- 3 . insert_reservation2 : interdire les réservations si le client possède déjà 3 réservations.
-- 4 . insert_chambre : lors d'une insertion, on calcule le total des capacités des chambres pour l'hôtel, si ce total est supérieur à 50, on interdit l'insertion de la chambre.


                                --  Part 2 --


-- Travail à réaliser : 


-- 1 . Mettez en place ce trigger, puis ajoutez un produit dans une commande, vérifiez que le champ total est bien mis à jour.

-- 2 .  Ce trigger ne fonctionne que lorsque l'on ajoute des produits dans la commande, les modifications ou suppressions ne permettent pas de recalculer le total. Modifiez le code ci-dessus pour faire en sorte que la modification ou la suppression de produit recalcule le total de la commande.

-- 3 . Un champ remise était prévu dans la table commande, il contient le coefficient de remise à appliquer à la commande. Prenez en compte ce champ dans le code de votre trigger.