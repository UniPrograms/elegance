CREATE DATABASE  IF NOT EXISTS `tdw_progetto` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tdw_progetto`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: tdw_progetto
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caratteristica`
--

DROP TABLE IF EXISTS `caratteristica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `caratteristica` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caratteristica`
--

LOCK TABLES `caratteristica` WRITE;
/*!40000 ALTER TABLE `caratteristica` DISABLE KEYS */;
/*!40000 ALTER TABLE `caratteristica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caratteristica_prodotto`
--

DROP TABLE IF EXISTS `caratteristica_prodotto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `caratteristica_prodotto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_PRODOTTO` int NOT NULL,
  `ID_CARATTERISTICA` int NOT NULL,
  `TESTO` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  KEY `ID_CARATTERISTICA` (`ID_CARATTERISTICA`),
  CONSTRAINT `caratteristica_prodotto_ibfk_1` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `caratteristica_prodotto_ibfk_2` FOREIGN KEY (`ID_CARATTERISTICA`) REFERENCES `caratteristica` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caratteristica_prodotto`
--

LOCK TABLES `caratteristica_prodotto` WRITE;
/*!40000 ALTER TABLE `caratteristica_prodotto` DISABLE KEYS */;
/*!40000 ALTER TABLE `caratteristica_prodotto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrello`
--

DROP TABLE IF EXISTS `carrello`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrello` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_UTENTE` int NOT NULL,
  `ID_PRODOTTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_UTENTE` (`ID_UTENTE`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`ID_UTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrello`
--

LOCK TABLES `carrello` WRITE;
/*!40000 ALTER TABLE `carrello` DISABLE KEYS */;
INSERT INTO `carrello` VALUES (1,1,1),(2,1,2),(3,1,2),(4,2,1);
/*!40000 ALTER TABLE `carrello` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'COMPUTER'),(2,'SMARTPHONE');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `immagine`
--

DROP TABLE IF EXISTS `immagine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `immagine` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(128) NOT NULL,
  `PATH` varchar(512) NOT NULL,
  `ID_PRODOTTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  CONSTRAINT `immagine_ibfk_1` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `immagine`
--

LOCK TABLES `immagine` WRITE;
/*!40000 ALTER TABLE `immagine` DISABLE KEYS */;
/*!40000 ALTER TABLE `immagine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_desideri`
--

DROP TABLE IF EXISTS `lista_desideri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lista_desideri` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_UTENTE` int NOT NULL,
  `ID_PRODOTTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UTENTE` (`ID_UTENTE`,`ID_PRODOTTO`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  CONSTRAINT `lista_desideri_ibfk_1` FOREIGN KEY (`ID_UTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lista_desideri_ibfk_2` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_desideri`
--

LOCK TABLES `lista_desideri` WRITE;
/*!40000 ALTER TABLE `lista_desideri` DISABLE KEYS */;
INSERT INTO `lista_desideri` VALUES (1,1,1),(2,2,2);
/*!40000 ALTER TABLE `lista_desideri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messaggio`
--

DROP TABLE IF EXISTS `messaggio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messaggio` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `OGGETTO` varchar(256) NOT NULL,
  `TESTO` text NOT NULL,
  `STATO` enum('CHIUSA','APERTA') NOT NULL DEFAULT 'CHIUSA',
  `ID_MITTENTE` int NOT NULL,
  `ID_DESTINATARIO` int NOT NULL,
  `DATE` date DEFAULT (curdate()),
  PRIMARY KEY (`ID`),
  KEY `ID_MITTENTE` (`ID_MITTENTE`),
  KEY `ID_DESTINATARIO` (`ID_DESTINATARIO`),
  CONSTRAINT `messaggio_ibfk_1` FOREIGN KEY (`ID_MITTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messaggio_ibfk_2` FOREIGN KEY (`ID_DESTINATARIO`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messaggio`
--

LOCK TABLES `messaggio` WRITE;
/*!40000 ALTER TABLE `messaggio` DISABLE KEYS */;
/*!40000 ALTER TABLE `messaggio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivazione_reso`
--

DROP TABLE IF EXISTS `motivazione_reso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motivazione_reso` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `MOTIVAZIONE` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivazione_reso`
--

LOCK TABLES `motivazione_reso` WRITE;
/*!40000 ALTER TABLE `motivazione_reso` DISABLE KEYS */;
INSERT INTO `motivazione_reso` VALUES (1,'Prodotto difettoso'),(2,'Prodotto arrivato in ritardo');
/*!40000 ALTER TABLE `motivazione_reso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifica`
--

DROP TABLE IF EXISTS `notifica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifica` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `OGGETTO` varchar(256) NOT NULL,
  `TESTO` text NOT NULL,
  `STATO` enum('CHIUSA','APERTA') NOT NULL DEFAULT 'CHIUSA',
  `ID_UTENTE` int NOT NULL,
  `DATE` date DEFAULT (curdate()),
  PRIMARY KEY (`ID`),
  KEY `ID_UTENTE` (`ID_UTENTE`),
  CONSTRAINT `notifica_ibfk_1` FOREIGN KEY (`ID_UTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifica`
--

LOCK TABLES `notifica` WRITE;
/*!40000 ALTER TABLE `notifica` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordine`
--

DROP TABLE IF EXISTS `ordine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordine` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `DATA_ORDINE` date DEFAULT (curdate()),
  `DATA_ARRIVO` date NOT NULL,
  `PREZZO` double NOT NULL DEFAULT '0',
  `INDIRIZZO_CONSEGNA` varchar(256) NOT NULL,
  `STATO` enum('IN_LAVORAZIONE','SPEDITO') DEFAULT 'IN_LAVORAZIONE',
  `ID_UTENTE` int NOT NULL,
  `ID_PAGAMENTO` int NOT NULL,
  `ID_SPEDIZIONE` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_UTENTE` (`ID_UTENTE`),
  KEY `ID_PAGAMENTO` (`ID_PAGAMENTO`),
  KEY `ID_SPEDIZIONE` (`ID_SPEDIZIONE`),
  CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`ID_UTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`ID_PAGAMENTO`) REFERENCES `pagamento` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ordine_ibfk_3` FOREIGN KEY (`ID_SPEDIZIONE`) REFERENCES `spedizione` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordine`
--

LOCK TABLES `ordine` WRITE;
/*!40000 ALTER TABLE `ordine` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordine` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `SPOSTA_PRODOTTI_IN_ORDINE` AFTER INSERT ON `ordine` FOR EACH ROW BEGIN
    -- inserisco tutti i prodotti all'interno dell'ordine
       INSERT INTO ORDINE_PRODOTTO (ID_ORDINE, ID_PRODOTTO)
	   SELECT NEW.ID, ID_PRODOTTO FROM CARRELLO
	   WHERE ID_UTENTE = NEW.ID_UTENTE;
       
	-- Tolgo tutti i prodotti dal carrello
		DELETE FROM CARRELLO WHERE ID_UTENTE = NEW.ID_UTENTE;
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ordine_prodotto`
--

DROP TABLE IF EXISTS `ordine_prodotto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordine_prodotto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_PRODOTTO` int NOT NULL,
  `ID_ORDINE` int NOT NULL,
  `RESO` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  KEY `ID_ORDINE` (`ID_ORDINE`),
  CONSTRAINT `ordine_prodotto_ibfk_1` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ordine_prodotto_ibfk_2` FOREIGN KEY (`ID_ORDINE`) REFERENCES `ordine` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordine_prodotto`
--

LOCK TABLES `ordine_prodotto` WRITE;
/*!40000 ALTER TABLE `ordine_prodotto` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordine_prodotto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `CALCOLA_PREZZO_TOTALE_ORDINE` AFTER INSERT ON `ordine_prodotto` FOR EACH ROW BEGIN
    DECLARE TOTALE DOUBLE;

    -- Calcola il totale sommando i prezzi dei prodotti nell'ordine
    SELECT SUM(PREZZO) INTO TOTALE FROM PRODOTTO
    WHERE ID IN (SELECT ID_PRODOTTO FROM ORDINE_PRODOTTO WHERE ID_ORDINE = NEW.ID_ORDINE);

    -- Aggiorna il prezzo totale nell'ordine
    UPDATE ORDINE
    SET PREZZO = TOTALE
    WHERE ID = NEW.ID_ORDINE;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagamento` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamento`
--

LOCK TABLES `pagamento` WRITE;
/*!40000 ALTER TABLE `pagamento` DISABLE KEYS */;
INSERT INTO `pagamento` VALUES (1,'PAYPAL'),(2,'MASTERCARD');
/*!40000 ALTER TABLE `pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodotto`
--

DROP TABLE IF EXISTS `prodotto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodotto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(256) NOT NULL,
  `PREZZO` double NOT NULL,
  `DESCRIZIONE` text NOT NULL,
  `ID_PRODUTTORE` int DEFAULT NULL,
  `ID_CATEGORIA` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUTTORE` (`ID_PRODUTTORE`),
  KEY `ID_CATEGORIA` (`ID_CATEGORIA`),
  CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`ID_PRODUTTORE`) REFERENCES `produttore` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `prodotto_ibfk_2` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodotto`
--

LOCK TABLES `prodotto` WRITE;
/*!40000 ALTER TABLE `prodotto` DISABLE KEYS */;
INSERT INTO `prodotto` VALUES (1,'GALAXY S',199.99,'',1,2),(2,'IPHONE 5S Espresso macchiato',799.35,'',2,2),(3,'MAC PRO 2 mostarda',1299.5,'',2,1);
/*!40000 ALTER TABLE `prodotto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produttore`
--

DROP TABLE IF EXISTS `produttore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produttore` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produttore`
--

LOCK TABLES `produttore` WRITE;
/*!40000 ALTER TABLE `produttore` DISABLE KEYS */;
INSERT INTO `produttore` VALUES (1,'SAMSUNG'),(2,'APPLE');
/*!40000 ALTER TABLE `produttore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recensione`
--

DROP TABLE IF EXISTS `recensione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recensione` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TESTO` text NOT NULL,
  `ID_PRODOTTO` int NOT NULL,
  `ID_UTENTE` int NOT NULL,
  `DATE` date DEFAULT (curdate()),
  PRIMARY KEY (`ID`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  KEY `ID_UTENTE` (`ID_UTENTE`),
  CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`ID_UTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recensione`
--

LOCK TABLES `recensione` WRITE;
/*!40000 ALTER TABLE `recensione` DISABLE KEYS */;
/*!40000 ALTER TABLE `recensione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reso`
--

DROP TABLE IF EXISTS `reso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reso` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_MOTIVAZIONE` int NOT NULL,
  `ID_ORDINE` int NOT NULL,
  `ID_PRODOTTO` int NOT NULL,
  `TESTO` text,
  `DATE` date DEFAULT (curdate()),
  PRIMARY KEY (`ID`),
  KEY `ID_MOTIVAZIONE` (`ID_MOTIVAZIONE`),
  KEY `ID_ORDINE` (`ID_ORDINE`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  CONSTRAINT `reso_ibfk_1` FOREIGN KEY (`ID_MOTIVAZIONE`) REFERENCES `motivazione_reso` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reso_ibfk_2` FOREIGN KEY (`ID_ORDINE`) REFERENCES `ordine` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reso_ibfk_3` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reso`
--

LOCK TABLES `reso` WRITE;
/*!40000 ALTER TABLE `reso` DISABLE KEYS */;
/*!40000 ALTER TABLE `reso` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `AGGIORNA_FLAG_PRODOTTO_RESO` AFTER INSERT ON `reso` FOR EACH ROW BEGIN
    -- Aggiorna il campo 'RESO' a TRUE nella tabella ORDINE_PRODOTTO
    UPDATE ORDINE_PRODOTTO SET RESO = TRUE
    WHERE ID_ORDINE = NEW.ID_ORDINE AND ID_PRODOTTO = NEW.ID_PRODOTTO;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `spedizione`
--

DROP TABLE IF EXISTS `spedizione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spedizione` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `PREZZO` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spedizione`
--

LOCK TABLES `spedizione` WRITE;
/*!40000 ALTER TABLE `spedizione` DISABLE KEYS */;
INSERT INTO `spedizione` VALUES (1,'PAYPAL',0),(2,'PAYPAL',0.5);
/*!40000 ALTER TABLE `spedizione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utente` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `COGNOME` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `RUOLO` enum('UTENTE','AMMINISTRATORE') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES (1,'gabriele','pasqualone','gab@gmail.com','gab','UTENTE'),(2,'lorenzo','feula','lor@gmail.com','lor','UTENTE'),(3,'luigi','di sciascio','lui@gmail.com','lui','AMMINISTRATORE');
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valutazione`
--

DROP TABLE IF EXISTS `valutazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valutazione` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `STELLE` int NOT NULL,
  `ID_PRODOTTO` int NOT NULL,
  `ID_UTENTE` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODOTTO` (`ID_PRODOTTO`),
  KEY `ID_UTENTE` (`ID_UTENTE`),
  CONSTRAINT `valutazione_ibfk_1` FOREIGN KEY (`ID_PRODOTTO`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `valutazione_ibfk_2` FOREIGN KEY (`ID_UTENTE`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `valutazione_chk_1` CHECK (((0 <= `STELLE`) and (`STELLE` <= 5)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valutazione`
--

LOCK TABLES `valutazione` WRITE;
/*!40000 ALTER TABLE `valutazione` DISABLE KEYS */;
/*!40000 ALTER TABLE `valutazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_carrello`
--

DROP TABLE IF EXISTS `view_carrello`;
/*!50001 DROP VIEW IF EXISTS `view_carrello`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_carrello` AS SELECT 
 1 AS `ID_CARRELLO`,
 1 AS `ID_UTENTE`,
 1 AS `ID_PRODOTTO`,
 1 AS `NOME`,
 1 AS `PREZZO`,
 1 AS `DESCRIZIONE`,
 1 AS `ID_PRODUTTORE`,
 1 AS `ID_CATEGORIA`,
 1 AS `NOME_PRODUTTORE`,
 1 AS `NOME_CATEGORIA`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_lista_desideri`
--

DROP TABLE IF EXISTS `view_lista_desideri`;
/*!50001 DROP VIEW IF EXISTS `view_lista_desideri`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_lista_desideri` AS SELECT 
 1 AS `ID_LISTA_DESIDERI`,
 1 AS `ID_PRODOTTO`,
 1 AS `NOME`,
 1 AS `PREZZO`,
 1 AS `DESCRIZIONE`,
 1 AS `ID_PRODUTTORE`,
 1 AS `ID_CATEGORIA`,
 1 AS `NOME_PRODUTTORE`,
 1 AS `NOME_CATEGORIA`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_ordine_prodotto`
--

DROP TABLE IF EXISTS `view_ordine_prodotto`;
/*!50001 DROP VIEW IF EXISTS `view_ordine_prodotto`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_ordine_prodotto` AS SELECT 
 1 AS `ID_ORDINE`,
 1 AS `ID_PRODOTTO`,
 1 AS `NOME`,
 1 AS `PREZZO`,
 1 AS `DESCRIZIONE`,
 1 AS `ID_PRODUTTORE`,
 1 AS `ID_CATEGORIA`,
 1 AS `NOME_PRODUTTORE`,
 1 AS `NOME_CATEGORIA`,
 1 AS `RESO`,
 1 AS `ID_RESO`,
 1 AS `TESTO_MOTIVAZIONE`,
 1 AS `ID_MOTIVAZIONE_RESO`,
 1 AS `MOTIVAZIONE`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_prodotto_produttore_categoria`
--

DROP TABLE IF EXISTS `view_prodotto_produttore_categoria`;
/*!50001 DROP VIEW IF EXISTS `view_prodotto_produttore_categoria`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_prodotto_produttore_categoria` AS SELECT 
 1 AS `ID_PRODOTTO`,
 1 AS `NOME`,
 1 AS `PREZZO`,
 1 AS `DESCRIZIONE`,
 1 AS `ID_PRODUTTORE`,
 1 AS `ID_CATEGORIA`,
 1 AS `NOME_PRODUTTORE`,
 1 AS `NOME_CATEGORIA`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'tdw_progetto'
--

--
-- Dumping routines for database 'tdw_progetto'
--

--
-- Final view structure for view `view_carrello`
--

/*!50001 DROP VIEW IF EXISTS `view_carrello`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_carrello` AS select `c`.`ID` AS `ID_CARRELLO`,`c`.`ID_UTENTE` AS `ID_UTENTE`,`p`.`ID_PRODOTTO` AS `ID_PRODOTTO`,`p`.`NOME` AS `NOME`,`p`.`PREZZO` AS `PREZZO`,`p`.`DESCRIZIONE` AS `DESCRIZIONE`,`p`.`ID_PRODUTTORE` AS `ID_PRODUTTORE`,`p`.`ID_CATEGORIA` AS `ID_CATEGORIA`,`p`.`NOME_PRODUTTORE` AS `NOME_PRODUTTORE`,`p`.`NOME_CATEGORIA` AS `NOME_CATEGORIA` from (`carrello` `c` join `view_prodotto_produttore_categoria` `p` on((`p`.`ID_PRODOTTO` = `c`.`ID_PRODOTTO`))) order by `c`.`ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_lista_desideri`
--

/*!50001 DROP VIEW IF EXISTS `view_lista_desideri`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_lista_desideri` AS select `ld`.`ID` AS `ID_LISTA_DESIDERI`,`p`.`ID_PRODOTTO` AS `ID_PRODOTTO`,`p`.`NOME` AS `NOME`,`p`.`PREZZO` AS `PREZZO`,`p`.`DESCRIZIONE` AS `DESCRIZIONE`,`p`.`ID_PRODUTTORE` AS `ID_PRODUTTORE`,`p`.`ID_CATEGORIA` AS `ID_CATEGORIA`,`p`.`NOME_PRODUTTORE` AS `NOME_PRODUTTORE`,`p`.`NOME_CATEGORIA` AS `NOME_CATEGORIA` from (`lista_desideri` `ld` join `view_prodotto_produttore_categoria` `p` on((`p`.`ID_PRODOTTO` = `ld`.`ID_PRODOTTO`))) order by `ld`.`ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_ordine_prodotto`
--

/*!50001 DROP VIEW IF EXISTS `view_ordine_prodotto`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_ordine_prodotto` AS select `o`.`ID` AS `ID_ORDINE`,`p`.`ID_PRODOTTO` AS `ID_PRODOTTO`,`p`.`NOME` AS `NOME`,`p`.`PREZZO` AS `PREZZO`,`p`.`DESCRIZIONE` AS `DESCRIZIONE`,`p`.`ID_PRODUTTORE` AS `ID_PRODUTTORE`,`p`.`ID_CATEGORIA` AS `ID_CATEGORIA`,`p`.`NOME_PRODUTTORE` AS `NOME_PRODUTTORE`,`p`.`NOME_CATEGORIA` AS `NOME_CATEGORIA`,`op`.`RESO` AS `RESO`,`r`.`ID` AS `ID_RESO`,`r`.`TESTO` AS `TESTO_MOTIVAZIONE`,`mr`.`ID` AS `ID_MOTIVAZIONE_RESO`,`mr`.`MOTIVAZIONE` AS `MOTIVAZIONE` from ((((`ordine` `o` join `ordine_prodotto` `op` on((`op`.`ID_ORDINE` = `o`.`ID`))) join `view_prodotto_produttore_categoria` `p` on((`p`.`ID_PRODOTTO` = `op`.`ID_PRODOTTO`))) left join `reso` `r` on(((`r`.`ID_ORDINE` = `o`.`ID`) and (`r`.`ID_PRODOTTO` = `p`.`ID_PRODOTTO`)))) left join `motivazione_reso` `mr` on((`mr`.`ID` = `r`.`ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_prodotto_produttore_categoria`
--

/*!50001 DROP VIEW IF EXISTS `view_prodotto_produttore_categoria`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_prodotto_produttore_categoria` AS select `p`.`ID` AS `ID_PRODOTTO`,`p`.`NOME` AS `NOME`,`p`.`PREZZO` AS `PREZZO`,`p`.`DESCRIZIONE` AS `DESCRIZIONE`,`p`.`ID_PRODUTTORE` AS `ID_PRODUTTORE`,`p`.`ID_CATEGORIA` AS `ID_CATEGORIA`,`pe`.`NOME` AS `NOME_PRODUTTORE`,`c`.`NOME` AS `NOME_CATEGORIA` from ((`prodotto` `p` join `produttore` `pe` on((`pe`.`ID` = `p`.`ID_PRODUTTORE`))) join `categoria` `c` on((`c`.`ID` = `p`.`ID_CATEGORIA`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-24 21:43:40
