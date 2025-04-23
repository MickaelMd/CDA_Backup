-- Active: 1745306493697@@127.0.0.1@3306@green_village

USE green_village;

INSERT INTO commercial (nom, prenom, email, telephone) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', '0123456789'),
('Martin', 'Paul', 'paul.martin@email.com', '0987654321');

INSERT INTO categorie (nom, image) VALUES
('Instruments de musique', 'instruments.jpg'),
('Accessoires', 'accessoires.jpg');

INSERT INTO fournisseur (nom, email, telephone, adresse, id_commercial) VALUES
('Fournisseur A', 'contact@fournisseurA.com', '0145789234', '123 rue de Paris', 1),
('Fournisseur B', 'contact@fournisseurB.com', '0156789345', '456 rue de Lyon', 2);

INSERT INTO sous_categorie (nom, image, id_categorie) VALUES
('Guitares', 'guitares.jpg', 1),
('Batteries', 'batteries.jpg', 1),
('Câbles', 'cables.jpg', 2);

INSERT INTO produit (libelle_court, libelle_long, image, prix_ht, prix_fournisseur, stock, id_fournisseur, id_sous_categorie) VALUES
('Guitare électrique', 'Guitare électrique Fender Stratocaster', 'guitare_electrique.jpg', 500.00, 300.00, 10, 1, 1),
('Batterie acoustique', 'Batterie acoustique Pearl Export', 'batterie_acoustique.jpg', 400.00, 250.00, 5, 2, 2),
('Câble jack', 'Câble jack 3m', 'cable_jack.jpg', 15.00, 5.00, 50, 2, 3);

INSERT INTO client (ref_client, nom, prenom, telephone, email, pass, type_client, coefficient, adresse_livraison, adresse_facturation, id_commercial) VALUES
('C123', 'Lemoine', 'Julie', '0612345678', 'julie.lemoine@email.com', 'password1', TRUE, 1.10, '12 rue du Soleil', '12 rue du Soleil', 1),
('C124', 'Dubois', 'Marc', '0623456789', 'marc.dubois@email.com', 'password2', FALSE, 1.05, '25 avenue des Champs', '25 avenue des Champs', 2);

INSERT INTO commande (ref_commande, date_commande, mode_paiement, statut, tva, reduction, total, total_ht, ref_facture, date_facture, ref_client) VALUES
('CMD001', '2025-04-22 14:30:00', 'Carte bancaire', 'En cours', 20, 10.00, 510.00, 425.00, 'FAC001', '2025-04-22 15:00:00', 'C123'),
('CMD002', '2025-04-23 10:00:00', 'Virement bancaire', 'Expédiée', 20, 0.00, 415.00, 345.00, 'FAC002', '2025-04-23 11:00:00', 'C124');

INSERT INTO detail_commande (quantite, prix, id_produit, ref_commande) VALUES
(1, 500.00, 1, 'CMD001'),
(1, 400.00, 2, 'CMD002');

INSERT INTO livraison (etat, date_livraison, ref_commande) VALUES
('Livré', '2025-04-23 12:00:00', 'CMD001'),
('En préparation', '2025-04-24 09:00:00', 'CMD002');

INSERT INTO achemine (id_produit, id_livraison, quantite_livree) VALUES
(1, 1, 1),
(2, 2, 1);