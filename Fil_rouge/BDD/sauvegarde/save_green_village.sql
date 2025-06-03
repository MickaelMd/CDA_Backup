/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.21-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: green_village
-- ------------------------------------------------------
-- Server version	10.6.21-MariaDB-0ubuntu0.22.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achemine`
--

DROP TABLE IF EXISTS `achemine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `achemine` (
  `id_produit` int(11) NOT NULL,
  `id_livraison` int(11) NOT NULL,
  `quantite_livree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit`,`id_livraison`),
  KEY `id_livraison` (`id_livraison`),
  CONSTRAINT `achemine_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`),
  CONSTRAINT `achemine_ibfk_2` FOREIGN KEY (`id_livraison`) REFERENCES `livraison` (`id_livraison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achemine`
--

LOCK TABLES `achemine` WRITE;
/*!40000 ALTER TABLE `achemine` DISABLE KEYS */;
INSERT INTO `achemine` VALUES (1,1,1),(1,9,2),(2,2,1),(2,5,1),(2,7,1),(2,8,1),(2,9,2),(3,3,1),(4,4,1),(5,12,1),(6,4,2),(6,5,2),(6,9,1),(6,11,2),(6,13,1),(7,5,2),(7,10,2),(7,11,1),(9,4,2),(10,6,2),(10,7,2);
/*!40000 ALTER TABLE `achemine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `image_cat` varchar(200) NOT NULL,
  `active_cat` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,'Guitare','/image/categorie/',1),(2,'Bass','/image/categorie/',0),(3,'Batteries','/image/categorie/',1),(4,'Clavier','/image/categorie/',1),(5,'Studio','/image/categorie/',1);
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `ref_client` varchar(50) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `pass_client` varchar(255) NOT NULL,
  `type_client` tinyint(1) NOT NULL DEFAULT 1,
  `coefficient` decimal(4,2) NOT NULL,
  `adresse_livraison` varchar(150) NOT NULL,
  `adresse_facturation` varchar(150) NOT NULL,
  `id_commercial` int(11) NOT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `ref_client` (`ref_client`),
  UNIQUE KEY `email` (`email`),
  KEY `id_commercial` (`id_commercial`),
  CONSTRAINT `client_ibfk_1` FOREIGN KEY (`id_commercial`) REFERENCES `commercial` (`id_commercial`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'X1E 1W5','Max','Dumont','05 31 54 36 92','non.vestibulum@aol.couk','VEQ49HFF1LW',1,36.00,'574-7795 Feugiat. Ave','142-6725 Purus Ave',4),(2,'L4W 7Z1','Louise','Lachapelle','03 56 03 37 23','in.hendrerit@aol.edu','IUG33HBG6ZX',1,4.00,'977-2015 Aenean Street','8423 Porttitor Ave',2),(3,'F2E 3C9','Pauline','Brisbois','02 25 77 18 26','volutpat.ornare@protonmail.org','VVN81YLP2EX',0,39.00,'Ap #677-495 Dis Rd.','7109 Parturient Av.',5),(4,'K1J 9B5','Mégane','Victor','08 43 21 87 71','tincidunt.vehicula@yahoo.net','YSR38JWS2XH',1,33.00,'P.O. Box 968, 3684 Pede Ave','416-6028 Tempor Ave',2),(5,'X6Y 6N4','Glenn','Plamondon','02 67 13 46 68','dapibus@icloud.edu','DLN43WYT9YR',1,11.00,'P.O. Box 696, 7739 Tempus, Rd.','508-8238 Tortor Av.',2),(6,'T3V 8F3','Clémentine','Borde','07 61 31 42 82','morbi@outlook.couk','QIN36STO3AM',0,16.00,'942-1792 Adipiscing St.','Ap #624-4752 Tortor. Avenue',3),(7,'O3G 6N7','Alison','Vincent','04 63 85 76 54','facilisis.vitae@icloud.net','WCJ67TGV5BX',0,49.00,'Ap #232-733 Proin Road','1498 Vivamus Avenue',2),(8,'C6N 8V2','Adrien','Vincent','06 38 65 39 56','elit.dictum@outlook.org','YCR59GPJ1NL',1,40.00,'831-5034 Ipsum Ave','586-3968 Ipsum. Rd.',1),(9,'J5U 8G7','Ben','Peerenboom','02 36 59 71 88','orci.lobortis@icloud.org','LVO54XDC1EW',1,36.00,'329-6249 Metus. Avenue','286-1970 Egestas Rd.',4),(10,'M5R 1T2','Mélanie','Van Alphen','05 35 63 76 24','sed.eu.eros@hotmail.edu','BDC24WWO2SU',0,36.00,'504-1946 Magna. Ave','248-9843 Consectetuer Avenue',2),(11,'U1L 8X7','Stéphane','Haak','03 76 60 54 45','pellentesque.massa@protonmail.edu','BIW85WSR5LM',0,49.00,'148 Nam Rd.','495-8844 Diam St.',5),(12,'E8L 6D7','Ali','Jonker','04 43 36 41 82','magnis.dis@outlook.edu','PHF59EAQ6IN',0,10.00,'Ap #901-3058 Nunc, Rd.','691-3892 Nisl St.',2),(13,'J5Q 5Q4','Emile','Baardwijk','05 84 60 71 21','erat.in@icloud.ca','UUY38CGG4HV',0,33.00,'P.O. Box 936, 4826 Est Ave','P.O. Box 124, 652 Aliquam, Road',2),(14,'J4L 8L6','Jean','Peeters','06 75 28 65 01','ornare.in@hotmail.org','TWN66JYV5AS',1,9.00,'678-3549 Vivamus Rd.','969-8424 Mauris St.',3),(15,'E6U 8Q3','Mélanie','Cloutier','05 48 28 41 87','sodales@aol.net','KBB23YSC6LD',0,19.00,'Ap #661-3173 Facilisis Rd.','8728 Dolor St.',4);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `ref_commande` varchar(50) NOT NULL,
  `date_commande` datetime NOT NULL DEFAULT current_timestamp(),
  `mode_paiement` varchar(50) NOT NULL,
  `statut` varchar(50) NOT NULL,
  `tva` int(11) NOT NULL,
  `reduction` decimal(10,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `total_ht` decimal(15,2) NOT NULL,
  `ref_facture` varchar(50) NOT NULL,
  `date_facture` datetime NOT NULL DEFAULT current_timestamp(),
  `ref_client` varchar(50) NOT NULL,
  PRIMARY KEY (`id_commande`),
  UNIQUE KEY `ref_commande` (`ref_commande`),
  UNIQUE KEY `ref_facture` (`ref_facture`),
  KEY `ref_client` (`ref_client`),
  CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`ref_client`) REFERENCES `client` (`ref_client`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

LOCK TABLES `commande` WRITE;
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` VALUES (1,'CMD001','2025-04-30 13:49:34','Carte bancaire','Payée',20,0.00,839.99,699.99,'FACT001','2025-04-30 13:49:34','X1E 1W5'),(2,'CMD002','2025-04-30 13:49:34','PayPal','En attente',20,10.00,839.90,699.90,'FACT002','2025-04-30 13:49:34','L4W 7Z1'),(3,'CMD003','2025-04-30 13:49:34','Virement','Payée',20,0.00,898.80,749.00,'FACT003','2025-04-30 13:49:34','F2E 3C9'),(4,'CMD004','2025-04-30 13:49:34','Virement','En attente',20,10.00,6932.00,5785.00,'FACT004','2025-04-30 13:49:34','O3G 6N7'),(5,'CMD005','2025-04-30 13:49:34','Carte bancaire','En attente',20,5.00,290.20,246.00,'FACT005','2025-04-30 13:49:34','M5R 1T2'),(6,'CMD006','2025-04-30 13:49:34','PayPal','En attente',20,0.00,2426.40,2022.00,'FACT006','2025-04-30 13:49:34','T3V 8F3'),(7,'CMD007','2025-04-30 13:49:34','PayPal','En attente',20,5.00,2536.60,2118.00,'FACT007','2025-04-30 13:49:34','X6Y 6N4'),(8,'CMD008','2025-04-30 13:49:34','Virement','En attente',20,10.00,5703.20,4761.00,'FACT008','2025-04-30 13:49:34','K1J 9B5'),(9,'CMD009','2025-04-30 13:49:34','PayPal','En attente',20,10.00,2902.40,2427.00,'FACT009','2025-04-30 13:49:34','X1E 1W5'),(10,'CMD010','2025-04-30 13:49:34','Virement','Préparée',20,10.00,2780.00,2325.00,'FACT010','2025-04-30 13:49:34','K1J 9B5'),(11,'CMD011','2025-04-30 13:49:34','Virement','En attente',20,0.00,3963.60,3303.00,'FACT011','2025-04-30 13:49:34','C6N 8V2'),(12,'CMD012','2025-04-30 13:49:34','PayPal','Payée',20,10.00,114.80,104.00,'FACT012','2025-04-30 13:49:34','M5R 1T2'),(13,'CMD013','2025-04-30 13:49:34','PayPal','Payée',20,0.00,3151.20,2626.00,'FACT013','2025-04-30 13:49:34','X1E 1W5');
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commercial`
--

DROP TABLE IF EXISTS `commercial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `commercial` (
  `id_commercial` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `email` varchar(320) NOT NULL,
  `pass_commercial` varchar(255) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  PRIMARY KEY (`id_commercial`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commercial`
--

LOCK TABLES `commercial` WRITE;
/*!40000 ALTER TABLE `commercial` DISABLE KEYS */;
INSERT INTO `commercial` VALUES (1,'Slade','Gallegos','lacus@google.net','YDS82WNO3JH','03 21 97 78 28'),(2,'May','Humphrey','libero.et@yahoo.net','PWT33ZHB5BS','02 92 57 33 27'),(3,'Uriah','Cross','sed@icloud.ca','KLJ75XDR1FV','06 67 68 12 54'),(4,'Idola','Mcmillan','hendrerit.consectetuer@aol.ca','DHK01UQM0XT','08 06 36 41 64'),(5,'Rogan','Matthews','quis.urna@outlook.net','YVT22JHE4IW','07 08 33 68 25');
/*!40000 ALTER TABLE `commercial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_commande`
--

DROP TABLE IF EXISTS `detail_commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_commande` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `ref_commande` varchar(50) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_produit` (`id_produit`),
  KEY `ref_commande` (`ref_commande`),
  CONSTRAINT `detail_commande_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`),
  CONSTRAINT `detail_commande_ibfk_2` FOREIGN KEY (`ref_commande`) REFERENCES `commande` (`ref_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_commande`
--

LOCK TABLES `detail_commande` WRITE;
/*!40000 ALTER TABLE `detail_commande` DISABLE KEYS */;
INSERT INTO `detail_commande` VALUES (1,1,699.99,1,'CMD001'),(2,1,299.90,2,'CMD002'),(3,1,749.00,3,'CMD003'),(4,3,839.00,2,'CMD004'),(5,2,959.00,10,'CMD004'),(6,3,450.00,6,'CMD004'),(7,2,123.00,7,'CMD005'),(8,3,674.00,3,'CMD006'),(9,1,538.00,10,'CMD007'),(10,1,827.00,8,'CMD007'),(11,1,753.00,6,'CMD007'),(12,3,846.00,6,'CMD008'),(13,3,741.00,7,'CMD008'),(14,3,159.00,2,'CMD009'),(15,2,975.00,8,'CMD009'),(16,3,775.00,6,'CMD010'),(17,3,499.00,10,'CMD011'),(18,3,602.00,9,'CMD011'),(19,1,104.00,2,'CMD012'),(20,1,526.00,9,'CMD013'),(21,2,601.00,4,'CMD013'),(22,1,898.00,10,'CMD013');
/*!40000 ALTER TABLE `detail_commande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `fournisseur` (
  `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  `email` varchar(320) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `id_commercial` int(11) NOT NULL,
  PRIMARY KEY (`id_fournisseur`),
  UNIQUE KEY `email` (`email`),
  KEY `id_commercial` (`id_commercial`),
  CONSTRAINT `fournisseur_ibfk_1` FOREIGN KEY (`id_commercial`) REFERENCES `commercial` (`id_commercial`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fournisseur`
--

LOCK TABLES `fournisseur` WRITE;
/*!40000 ALTER TABLE `fournisseur` DISABLE KEYS */;
INSERT INTO `fournisseur` VALUES (1,'Duis LLP','rhoncus.donec@outlook.edu','03 42 12 53 88','P.O. Box 238, 3921 Sed St.',5),(2,'Quam Curabitur Vel PC','faucibus.leo@protonmail.net','06 72 05 22 58','984-5251 Arcu. Rd.',2),(3,'Magnis Dis Corp.','eget.lacus@hotmail.org','07 64 32 82 18','Ap #470-9080 Et Road',5),(4,'Erat Neque Foundation','nulla@google.net','07 22 56 47 62','8486 Fringilla. Street',3),(5,'Aliquam Fringilla Inc.','vulputate@protonmail.net','03 17 54 56 25','P.O. Box 185, 1734 Cras Ave',4);
/*!40000 ALTER TABLE `fournisseur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livraison`
--

DROP TABLE IF EXISTS `livraison`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `livraison` (
  `id_livraison` int(11) NOT NULL AUTO_INCREMENT,
  `etat` varchar(50) NOT NULL,
  `date_livraison` datetime NOT NULL,
  `ref_commande` varchar(50) NOT NULL,
  PRIMARY KEY (`id_livraison`),
  KEY `ref_commande` (`ref_commande`),
  CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`ref_commande`) REFERENCES `commande` (`ref_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livraison`
--

LOCK TABLES `livraison` WRITE;
/*!40000 ALTER TABLE `livraison` DISABLE KEYS */;
INSERT INTO `livraison` VALUES (1,'Livrée','2025-01-15 00:00:00','CMD001'),(2,'En cours','2025-04-25 00:00:00','CMD002'),(3,'Préparée','2025-04-28 00:00:00','CMD003'),(4,'Préparée','2025-04-28 00:00:00','CMD004'),(5,'En cours','2025-04-26 00:00:00','CMD005'),(6,'Préparée','2025-04-29 00:00:00','CMD006'),(7,'Livrée','2025-02-20 00:00:00','CMD007'),(8,'Préparée','2025-04-29 00:00:00','CMD008'),(9,'Livrée','2025-03-10 00:00:00','CMD009'),(10,'Préparée','2025-04-27 00:00:00','CMD010'),(11,'Livrée','2025-03-28 00:00:00','CMD011'),(12,'Payée','2025-04-15 00:00:00','CMD012'),(13,'Payée','2025-04-16 00:00:00','CMD013');
/*!40000 ALTER TABLE `livraison` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_court` varchar(50) NOT NULL,
  `libelle_long` varchar(500) NOT NULL,
  `image_produit` varchar(200) NOT NULL,
  `prix_ht` decimal(10,2) NOT NULL,
  `prix_fournisseur` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `active_produit` tinyint(1) NOT NULL DEFAULT 1,
  `id_fournisseur` int(11) NOT NULL,
  `id_sous_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_fournisseur` (`id_fournisseur`),
  KEY `id_sous_categorie` (`id_sous_categorie`),
  CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`),
  CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`id_sous_categorie`) REFERENCES `sous_categorie` (`id_sous_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES (1,'Stratocaster','Guitare électrique type Stratocaster avec micros simple bobinage','/image/produit/stratocaster.jpg',699.99,450.00,15,1,1,1),(2,'Folk Yamaha','Guitare acoustique Yamaha idéale pour débutants et intermédiaires','/image/produit/folk.jpg',299.90,180.00,25,1,2,2),(3,'Jazz Bass','Basse électrique avec micros passifs et manche érable','/image/produit/jazzbass.jpg',749.00,500.00,10,1,3,3),(4,'Basse Acoustique Ibanez','Basse acoustique Ibanez à caisse jumbo','/image/produit/basse_acoustique.jpg',349.99,220.00,8,1,4,4),(5,'Yamaha Stage Custom','Batterie acoustique complète 5 fûts + cymbales','/image/produit/stage_custom.jpg',899.00,600.00,5,1,5,5),(6,'Alesis Nitro Mesh','Batterie électronique compacte avec pads maillés','/image/produit/nitro_mesh.jpg',399.00,250.00,12,1,1,6),(7,'Yamaha P-125','Piano numérique 88 touches lestées avec sons réalistes','/image/produit/p125.jpg',599.00,400.00,9,1,2,7),(8,'Upright Kawai','Piano droit Kawai avec mécanique précise','/image/produit/upright.jpg',2999.00,2000.00,2,1,3,8),(9,'Focusrite Scarlett 2i2','Interface audio USB 2 entrées/2 sorties très populaire','/image/produit/scarlett_2i2.jpg',159.00,100.00,20,1,4,9),(10,'Shure SM58','Microphone dynamique cardioïde idéal pour la voix','/image/produit/sm58.jpg',109.00,70.00,30,1,5,10);
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sous_categorie`
--

DROP TABLE IF EXISTS `sous_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sous_categorie` (
  `id_sous_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `image_sous_cat` varchar(200) NOT NULL,
  `active_sous_cat` tinyint(1) NOT NULL DEFAULT 1,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id_sous_categorie`),
  KEY `id_categorie` (`id_categorie`),
  CONSTRAINT `sous_categorie_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sous_categorie`
--

LOCK TABLES `sous_categorie` WRITE;
/*!40000 ALTER TABLE `sous_categorie` DISABLE KEYS */;
INSERT INTO `sous_categorie` VALUES (1,'Guitare Electriques','/image/sous_categorie/',1,1),(2,'Guitare Acoustiques','/image/sous_categorie/',0,1),(3,'Basses Electriques','/image/sous_categorie/',1,2),(4,'Basses Acoustiques','/image/sous_categorie/',1,2),(5,'Batteries Acoustiques','/image/sous_categorie/',1,3),(6,'Batteries Electriques','/image/sous_categorie/',1,3),(7,'Pianos Numériques','/image/sous_categorie/',0,4),(8,'Pianos Droits','/image/sous_categorie/',0,4),(9,'Interfaces AUdio','/image/sous_categorie/',1,5),(10,'Microphones','/image/sous_categorie/',0,5);
/*!40000 ALTER TABLE `sous_categorie` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-30 13:49:52
