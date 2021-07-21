-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: lavanderia_solari
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `capi`
--

DROP TABLE IF EXISTS `capi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sottotipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descrizione` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prezzo` double NOT NULL,
  `giorni_lavorazione` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capi`
--

LOCK TABLES `capi` WRITE;
/*!40000 ALTER TABLE `capi` DISABLE KEYS */;
/*!40000 ALTER TABLE `capi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clienti`
--

DROP TABLE IF EXISTS `clienti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clienti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indirizzo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comune` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stato` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cap` int DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cellulare` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codice_fiscale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_iva` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codice_univoco` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clienti`
--

LOCK TABLES `clienti` WRITE;
/*!40000 ALTER TABLE `clienti` DISABLE KEYS */;
/*!40000 ALTER TABLE `clienti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impostazioni`
--

DROP TABLE IF EXISTS `impostazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `impostazioni` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valore` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descrizione` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impostazioni`
--

LOCK TABLES `impostazioni` WRITE;
/*!40000 ALTER TABLE `impostazioni` DISABLE KEYS */;
INSERT INTO `impostazioni` VALUES (1,'metodoCalcoloGiorniLavorazione','statico',NULL,NULL),(2,'numeroGiorniLavorazione','7',NULL,NULL),(3,'ragioneSociale','Puppa srlyyyy',NULL,'anagraficaAziendale'),(4,'indirizzo','via le mani dal naso ffdesfa',NULL,'anagraficaAziendale');
/*!40000 ALTER TABLE `impostazioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordini`
--

DROP TABLE IF EXISTS `ordini`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordini` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `data_ordine` date NOT NULL,
  `data_consegna` date DEFAULT NULL,
  `totale` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F720A0ADDE734E51` (`cliente_id`),
  KEY `IDX_F720A0ADA76ED395` (`user_id`),
  CONSTRAINT `FK_F720A0ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F720A0ADDE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `clienti` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordini`
--

LOCK TABLES `ordini` WRITE;
/*!40000 ALTER TABLE `ordini` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordini` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordini_row`
--

DROP TABLE IF EXISTS `ordini_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordini_row` (
  `id` int NOT NULL AUTO_INCREMENT,
  `capo_id` int NOT NULL,
  `ordine_id` int NOT NULL,
  `importo` double NOT NULL,
  `data_consegna` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_197F3084E70D4E41` (`capo_id`),
  KEY `IDX_197F3084685E286D` (`ordine_id`),
  CONSTRAINT `FK_197F3084685E286D` FOREIGN KEY (`ordine_id`) REFERENCES `ordini` (`id`),
  CONSTRAINT `FK_197F3084E70D4E41` FOREIGN KEY (`capo_id`) REFERENCES `capi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordini_row`
--

LOCK TABLES `ordini_row` WRITE;
/*!40000 ALTER TABLE `ordini_row` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordini_row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cognome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (12,'username0','[\"ROLE_ADMIN\"]','$2y$13$6nk6fkDTnFWuKR0PgmX0reNghUpQKn.VG/KyfOxO7GgMO0.PPHGKy',NULL,NULL,NULL),(13,'username1','[]','$2y$13$LJjcFe4l/6y7qIPG37zjFOx1VxrWi/6bZgpD8qHj6sT8eQEx9w9ba',NULL,NULL,NULL),(14,'username2','[]','$2y$13$XLnc13pNWNg7RNS7kKh4Ketb/9TbdsuXs9eIi2OJOYPwA/78F6URG',NULL,NULL,NULL),(15,'username3','[]','$2y$13$Cf5uqOQR85DKZtQoL9xseu09Wjc7.jzqYteJHc5taeWfmfwFsQng2',NULL,NULL,NULL),(16,'username4','[]','$2y$13$aM.1.trAUU2.7wvh6u541.lLYarlJZgwcG/MpIXrS4TOa14SrJlAW',NULL,NULL,NULL),(17,'username5','[]','$2y$13$YGK1gpZwTo5MIy/Nmjz9pOFcgKGQ90/Gb8Q00w3oktsQ5ATo9uoKa',NULL,NULL,NULL),(18,'username6','[]','$2y$13$awvdN7Iqt8Qi.BTA/lDwKe0KmNqF177QLzHVV7uWi20XLnXkc3en6',NULL,NULL,NULL),(19,'username7','[]','$2y$13$hAUUuvAycNlwrZvN52TdPuLHHeNcKL55FFFXbG4N0R5kpVDEhWBxq',NULL,NULL,NULL),(20,'username8','[]','$2y$13$Yjbnvzy6QEs5ESe5XxbtJub5.Zh/HTLteOAUOZJTJrzSMD/WvE/iW',NULL,NULL,NULL),(21,'username9','[]','$2y$13$0wHDk96PxMBimEnSkBqQmuFN2X3mCOcKRyJcyMTghNvMqMKtpoiri',NULL,NULL,NULL),(22,'username10','[]','$2y$13$Tc6/ny8.2cDiZ0kCSQDJSeR/z58oIH7PdCgM7CLCfzJGUI284riKK',NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-15  9:01:18
