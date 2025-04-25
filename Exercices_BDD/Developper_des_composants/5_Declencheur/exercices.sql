
-- MySql : les déclencheurs, Papyrus
-- A partir de la base Papyrus. Le jeu d'essai a été constitué lors d'une séance précédente.

USE papyrus;

-- La base de données relationnelle PAPYRUS est constituée des relations suivantes :

-- PRODUIT (CODART, LIBART, STKLE, STKPHY, QTEANN, UNIMES)
-- ENTCOM (NUMCOM, OBSCOM, DATCOM, NUMFOU)
-- LIGCOM (NUMCOM, NUMLIG, CODART, QTECDE, PRIUNI, QTELIV, DERLIV)
-- FOURNIS (NUMFOU, NOMFOU, RUEFOU, POSFOU, VILFOU, CONFOU, SATISF)
-- VENTE (CODART, NUMFOU, DELLIV, QTE1, PRIX1, QTE2, PRIX2, QTE3, PRIX3)

-- Création d'un déclencheur AFTER UPDATE

-- Créer une table ARTICLES_A_COMMANDER avec les colonnes :

-- 1 . CODART : Code de l'article, voir la table produit
-- 2 . DATE : date du jour (par défaut)
-- 3 . QTE : à calculer




-- Créer un déclencheur UPDATE sur la table produit : lorsque le stock physique devient inférieur ou égal au stock d'alerte, une nouvelle ligne est insérée dans la table ARTICLES_A_COMMANDER.
-- (Attention, il faut prendre en compte les quantités déjà commandées dans la table ARTICLES_A_COMMANDER.)

-- Pour comprendre le problème :

-- Soit l'article I120, le stock d'alerte = 5, le stock physique = 20



-- 1 . Nous retirons 15 produits du stock. stock d'alerte = 5, le stock physique = 5, le stock physique n'est pas inférieur au stock d'alerte, on ne fait rien.



-- 2 . Nous retirons 1 produit du stock.
--     stock d'alerte = 5, le stock physique = 4, le stock physique est inférieur au stock d'alerte, nous devons recommander des produits.
--     Nous insérons une ligne dans la table ARTICLES_A_COMMANDER avec QTE = (stock alerte - stock physique) = 1



-- 3 . Nous retirons 2 produit du stock. stock d'alerte = 5, le stock physique = 2. Le stock physique est inférieur au stock d'alerte, nous devons recommander des produits.
--     Nous insérons une ligne dans la table ARTICLES_A_COMMANDER avec QTE = (stock alerte - stock physique) – quantité déjà commandée dans ARTICLES_A_COMMANDER : QTE = (5 - 2) – 1 = 2