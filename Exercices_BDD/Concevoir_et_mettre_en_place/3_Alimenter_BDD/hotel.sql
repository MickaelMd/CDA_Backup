-- Active: 1745306493697@@127.0.0.1@3306@Exercice_2

-- Réalisez le jeu de test pour la base hotel (exercice 2 de la séance précédente). 
-- Vous devez vous-même trouver les données à insérer dans les tables.
-- En mettant des valeurs simples, ajouter au moins 3 stations, 3 hôtels par station et 3 chambres par hôtel.

INSERT INTO Station(nom_station)
VALUES ('Stati'), ('Stata'), ('Stato');

INSERT INTO Hotel(capacite_hotel, categorie_hotel, nom_hotel, adresse_hotel, num_station)
VALUES 
    (154, 'Bien-être', 'Grand Alpe', '50 Rue de la station', 1),
    (48, 'Luxe', 'L\'autre station', '149 Rue de L\'autre station', 1),
    (78, 'Pas fou', 'Berga', '48 Rue à côté de l\'autre', 1),
    (95, 'Confort', 'Mont Soleil', '12 Rue du Soleil', 2),
    (120, 'Standard', 'Refuge Nord', '88 Route de la Lune', 2),
    (60, 'Familial', 'Neige & Co', '25 Rue Blanche', 2),
    (140, 'Éco', 'Les Flocons', '17 Chemin des Flocons', 3),
    (100, 'Prestige', 'Alpen Lodge', '3 Avenue des Sommets', 3),
    (75, 'Nature', 'Roche Claire', '62 Route Forestière', 3);

INSERT INTO Chambre(capacite_chambre, degre_confort, exposition, type_chambre, num_hotel)
VALUES 
    (2, 50, 'n', 'Couple', 1),
    (4, 30, 'e', 'Famille', 1),
    (1, 60, 's', 'Solo', 1),
    (2, 45, 'o', 'Vue sur le parking', 2),
    (3, 20, 'n', 'Chambre "cozy"', 2),
    (1, 70, 'e', 'Suite présidentielle... pour une personne', 2),
    (4, 35, 's', 'Chambre sans fenêtre', 3),
    (2, 55, 'n', 'Double lit superposé deluxe', 3),
    (1, 40, 'e', 'Chambre mystère (vous verrez bien)', 3),
    (2, 60, 'o', 'Romantique (selon la météo)', 4),
    (5, 25, 'n', 'Dortoir familial', 4),
    (1, 80, 'e', 'Premium isolée (du reste de l’hôtel)', 4),
    (3, 35, 's', 'Budget +', 5),
    (2, 65, 'n', 'Mini-suite pour maxi-budget', 5),
    (1, 30, 'o', 'Capsule zen', 5),
    (4, 50, 'e', 'Classique panoramique... sur le mur voisin', 6),
    (2, 45, 's', 'Chambre à vivre, mais pas trop', 6),
    (1, 70, 'n', 'Suite en théorie', 6),
    (3, 55, 'n', 'Nature & Bricolage', 7),
    (2, 35, 'e', 'Rustique améliorée', 7),
    (1, 60, 's', 'Zen box', 7),
    (4, 40, 'o', 'Vue Montagne (à l’horizon)', 8),
    (2, 50, 'n', 'Confort Express', 8),
    (1, 75, 'e', 'Luxe discret', 8),
    (3, 60, 's', 'Chambre éco chic', 9),
    (2, 30, 'o', 'Standard sans surprise', 9),
    (1, 90, 'n', 'Suite auto-proclamée', 9);
