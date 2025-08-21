/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: green_village
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-0ubuntu0.22.04.1

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

LOCK TABLES `commande` WRITE;
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commercial`
--

LOCK TABLES `commercial` WRITE;
/*!40000 ALTER TABLE `commercial` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_commande`
--

LOCK TABLES `detail_commande` WRITE;
/*!40000 ALTER TABLE `detail_commande` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fournisseur`
--

LOCK TABLES `fournisseur` WRITE;
/*!40000 ALTER TABLE `fournisseur` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livraison`
--

LOCK TABLES `livraison` WRITE;
/*!40000 ALTER TABLE `livraison` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sous_categorie`
--

LOCK TABLES `sous_categorie` WRITE;
/*!40000 ALTER TABLE `sous_categorie` DISABLE KEYS */;
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

-- Dump completed on 2025-08-21  9:46:15
