-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: 91.173.60.180    Database: projet_web
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.22.04.1

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
-- Table structure for table `Acheter`
--

DROP TABLE IF EXISTS `Acheter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Acheter` (
  `ID_compte` int NOT NULL,
  `Id_articles` int NOT NULL,
  `Id_transaction` int NOT NULL,
  PRIMARY KEY (`ID_compte`,`Id_articles`),
  UNIQUE KEY `Id_transaction` (`Id_transaction`),
  KEY `Id_articles` (`Id_articles`),
  CONSTRAINT `Acheter_ibfk_1` FOREIGN KEY (`ID_compte`) REFERENCES `Utilisateur` (`ID_compte`),
  CONSTRAINT `Acheter_ibfk_2` FOREIGN KEY (`Id_articles`) REFERENCES `Articles` (`Id_articles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Acheter`
--

LOCK TABLES `Acheter` WRITE;
/*!40000 ALTER TABLE `Acheter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Acheter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Articles`
--

DROP TABLE IF EXISTS `Articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Articles` (
  `Id_articles` int NOT NULL AUTO_INCREMENT,
  `nom_article` varchar(50) NOT NULL,
  `Description` text,
  `Prix` double NOT NULL,
  `Catégorie` varchar(50) DEFAULT NULL,
  `Date` varchar(45) NOT NULL,
  `ID_compte` varchar(255) DEFAULT NULL,
  `envente` enum('oui','non') DEFAULT 'oui',
  PRIMARY KEY (`Id_articles`),
  UNIQUE KEY `nom_article` (`nom_article`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Articles`
--

LOCK TABLES `Articles` WRITE;
/*!40000 ALTER TABLE `Articles` DISABLE KEYS */;
INSERT INTO `Articles` VALUES (31,'Peugot 309','voiture de fou malade',50000,'vetement','22-05-2023','toufik','oui'),(32,'Gourde dorée','Qualité excellente et parfaite',510,'vetement','22-05-2023','toto','oui'),(33,'Paire de crampons','Haute qualité',80,'vetement','22-05-2023','dadson_prod','oui'),(34,'Maillot du réal','Porté par Vinicius',200,'vetement','22-05-2023','dadson_prod','oui'),(35,'Canon ','vidéo 4k et photo de qualité',7000,'informatique','22-05-2023','dadson_prod','oui'),(43,'coque iphone','Qualité supérieur',99,'informatique','22-05-2023','matondo2','oui'),(44,'Ballon CR7','Touché par le goat',99999999,'vetement','22-05-2023','matondo2','oui'),(46,'ps5 + manette','Console du future',700,'console','22-05-2023','toto','oui'),(47,'Cr7 maillot','Avec la sueur du goat',80000,'vetement','22-05-2023','toto','oui'),(48,'WHEY PROTEIN','Poudre de whey a la vanille, tu deviens comme tibo inshape en 2h.',20,'fitness','23-05-2023','toto','oui'),(59,'testPringles','t',4,'vetement','23-05-2023','toufik','oui'),(62,'Durag','Pour Petit Thug ! ',15,'vetement','25-05-2023','Greg','oui'),(64,'Répéteur WIFI','permet de répéter le signal efficacement ',45,'informatique','25-05-2023','Greg','oui'),(66,'Sac','Sac',450,'vetement','28-05-2023','sasha','oui'),(67,'clavier','clavier',45,'informatique','28-05-2023','momo','oui');
/*!40000 ALTER TABLE `Articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commandes`
--

DROP TABLE IF EXISTS `Commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Commandes` (
  `id_article` int NOT NULL,
  `nom_article` varchar(100) NOT NULL,
  `prix_article` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_transaction` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_transaction`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commandes`
--

LOCK TABLES `Commandes` WRITE;
/*!40000 ALTER TABLE `Commandes` DISABLE KEYS */;
INSERT INTO `Commandes` VALUES (34,'Maillot du réal',200,'toto',2),(34,'Maillot du réal',200,'toto',10),(44,'Ballon CR7',99999999,'thomas_peugnet',12),(43,'coque iphone',99,'thomas_peugnet',13),(43,'coque iphone',99,'thomas_peugnet',14),(43,'coque iphone',99,'thomas_peugnet',15),(45,'kbze',12,'thomas_peugnet',16),(44,'Ballon CR7',99999999,'thomas_peugnet',17),(25,'Lambo',25000,'thomas_peugnet',18),(45,'kbze',12,'thomas_peugnet',19),(45,'kbze',12,'thomas_peugnet',20),(45,'kbze',12,'thomas_peugnet',21),(45,'kbze',12,'thomas_peugnet',22),(45,'kbze',12,'thomas_peugnet',23),(45,'kbze',12,'thomas_peugnet',24),(43,'coque iphone',99,'thomas_peugnet',25),(43,'coque iphone',99,'thomas_peugnet',26),(43,'coque iphone',99,'thomas_peugnet',27),(43,'coque iphone',99,'thomas_peugnet',28),(43,'coque iphone',99,'thomas_peugnet',29),(43,'coque iphone',99,'thomas_peugnet',30),(43,'coque iphone',99,'thomas_peugnet',31),(43,'coque iphone',99,'thomas_peugnet',32),(43,'coque iphone',99,'thomas_peugnet',33),(43,'coque iphone',99,'thomas_peugnet',34),(47,'Cr7 maillot',80000,'prof',35),(47,'Cr7 maillot',80000,'toto',36),(47,'Cr7 maillot',80000,'prof',37),(48,'WHEY PROTEIN',20,'prof',38),(48,'WHEY PROTEIN',20,'prof',39),(48,'WHEY PROTEIN',20,'toto',40),(48,'WHEY PROTEIN',20,'prof',41),(48,'WHEY PROTEIN',20,'prof',42),(47,'Cr7 maillot',80000,'toto',43),(56,'csh ',1,'toufik',44),(56,'csh ',1,'toufik',45),(56,'csh ',1,'toufik',46),(47,'Cr7 maillot',80000,'toto',47),(31,'Peugot 309',50000,'toto',48),(60,'Maillot win',300,'toufik',49),(64,'Répéteur WIFI',45,'baba',51),(62,'Durag',15,'baba',52),(31,'Peugot 309',50000,'toufik',53),(63,'Casquette stylée',30,'toto',54),(64,'Répéteur WIFI',45,'toto',55),(62,'Durag',15,'toto',56),(63,'Casquette stylée',30,'toto',57),(63,'Casquette stylée',30,'toto',58),(64,'Répéteur WIFI',45,'toto',59),(63,'Casquette stylée',30,'baba',60),(64,'Répéteur WIFI',45,'baba',61),(63,'Casquette stylée',30,'baba',62),(63,'Casquette stylée',30,'baba',63),(62,'Durag',15,'baba',64),(62,'Durag',15,'sasha',65),(64,'Répéteur WIFI',45,'sasha',66),(25,'Lambo',25000,'baba',67),(34,'Maillot du réal',200,'toto',68),(43,'coque iphone',99,'toto',69);
/*!40000 ALTER TABLE `Commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Panier`
--

DROP TABLE IF EXISTS `Panier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Panier` (
  `id_article` int NOT NULL,
  `nom_article` varchar(100) NOT NULL,
  `prix_article` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_transaction` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_transaction`),
  KEY `id_compte_acheteur` (`nom_article`),
  KEY `id_article` (`prix_article`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Panier`
--

LOCK TABLES `Panier` WRITE;
/*!40000 ALTER TABLE `Panier` DISABLE KEYS */;
INSERT INTO `Panier` VALUES (23,'ps5 + manette',2000,'jokerSell',153),(14,'rien',1,'jokerBuy',156),(15,'Iphone 90',200000000,'jokerBuy',157),(23,'ps5 + manette',2000,'jokerBuy',158),(12,'Jordan',1000000,'jokerBuy',159),(12,'Jordan',1000000,'jokerBuy',160),(34,'Maillot du réal',200,'joker',176),(33,'Paire de crampons',80,'joker',177),(45,'kbze',12,'thomas_peugnet',211),(45,'kbze',12,'thomas_peugnet',212),(45,'kbze',12,'thomas_peugnet',213),(45,'kbze',12,'thomas_peugnet',214),(45,'kbze',12,'thomas_peugnet',215),(45,'kbze',12,'thomas_peugnet',216),(43,'coque iphone',99,'thomas_peugnet',217),(43,'coque iphone',99,'thomas_peugnet',218),(43,'coque iphone',99,'thomas_peugnet',219),(43,'coque iphone',99,'thomas_peugnet',220),(43,'coque iphone',99,'thomas_peugnet',221),(43,'coque iphone',99,'thomas_peugnet',222),(43,'coque iphone',99,'thomas_peugnet',223),(43,'coque iphone',99,'thomas_peugnet',224),(43,'coque iphone',99,'thomas_peugnet',225),(43,'coque iphone',99,'thomas_peugnet',226),(47,'Cr7 maillot',80000,'prof',229),(48,'WHEY PROTEIN',20,'prof',230),(48,'WHEY PROTEIN',20,'prof',231),(48,'WHEY PROTEIN',20,'prof',233),(48,'WHEY PROTEIN',20,'prof',234),(31,'Peugot 309',50000,'toufik',245),(62,'Durag',15,'sasha',257),(64,'Répéteur WIFI',45,'sasha',258);
/*!40000 ALTER TABLE `Panier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Signalement`
--

DROP TABLE IF EXISTS `Signalement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Signalement` (
  `id_signalement` int NOT NULL AUTO_INCREMENT,
  `id_article` int DEFAULT NULL,
  `signaleur` varchar(255) DEFAULT NULL,
  `vendeur` varchar(255) DEFAULT NULL,
  `raison` varchar(500) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id_signalement`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Signalement`
--

LOCK TABLES `Signalement` WRITE;
/*!40000 ALTER TABLE `Signalement` DISABLE KEYS */;
INSERT INTO `Signalement` VALUES (21,48,'matondo2','toto','Spam, Contenu trompeur','2023-05-23'),(22,49,'matondo2','matondo2','Contenu inapproprié, Contenu illégal, Spam, Contenu trompeur','2023-05-23'),(23,50,'matondo2','matondo2','Contenu illégal, Contenu trompeur','2023-05-23'),(24,51,'matondo2','matondo2','Spam','2023-05-23'),(25,52,'toto','toto','Spam, Contenu trompeur','2023-05-23'),(26,53,'toto','toto','Contenu trompeur','2023-05-23'),(27,54,'toto','toto','Contenu trompeur','2023-05-23'),(28,55,'toto','toto','Spam','2023-05-23'),(29,56,'toto','toto','Contenu inapproprié, Contenu illégal','2023-05-23'),(30,57,'toto','toufik','Contenu trompeur','2023-05-23'),(31,58,'toufik','toufik','Contenu inapproprié','2023-05-23'),(32,60,'toto','toto','Contenu inapproprié, Contenu illégal, Spam, Contenu trompeur','2023-05-24'),(33,1,'toto','toto','Contenu illégal','2023-05-25'),(34,2,'toufik','toufik','Spam','2023-05-26'),(35,63,'jokerBuy','Greg','Contenu inapproprié','2023-05-26'),(36,67,'toto','momo','Contenu inapproprié, Contenu illégal','2023-05-28'),(37,25,'toto','Greg','Contenu inapproprié, Spam','2023-09-04');
/*!40000 ALTER TABLE `Signalement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utilisateur`
--

DROP TABLE IF EXISTS `Utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utilisateur` (
  `ID_compte` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `statut` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_compte`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilisateur`
--

LOCK TABLES `Utilisateur` WRITE;
/*!40000 ALTER TABLE `Utilisateur` DISABLE KEYS */;
INSERT INTO `Utilisateur` VALUES (1,'matondo','$2y$10$uqZqiOwyvgtfWh3ZtM2Vi.dtwO2w7tUcQpa.HWjY5Ro7iAbYSiGo6','acheteur'),(4,'toto','$2y$10$AnM06uEdNH.sM4kZEbUMc.ypvpZhxiWklsn.Lus5GrCjQEDYl5dVG','vendeur'),(7,'tata','$2y$10$YkADz7BUc/NByzwmqNS2EOkM9ABZ1FTpa83aKJt2nt3gqB4/4.0ZW','vendeur'),(8,'test','$2y$10$UNevOEmYJoO9ScLVNius.uKHSBWtwBZux.PgdEDY1BKtbk.ATb.ly','acheteur'),(9,'joker','$2y$10$muxf88g7SHEU3ULxTedL2O99txEzR.TYF8DAMZcuHcWzvmdNVMSDq','admin'),(10,'gogo','$2y$10$iw86AGklntf.QfuhNuVVQ.v22og1rmOz2I4V/q7b4LmlsumnUvXXK','acheteur'),(11,'gogoz','$2y$10$apFplFD7VGbAK2XiFM2MR.qlEFVl.KvZabaMcjlTfzj3/UPmCDEBO','acheteur'),(12,'baba','$2y$10$rdR3GZuFy5xhs43ismHmuulZqJSgeEB2XLhyce6C7wZGW9uiBegs6','vendeur'),(13,'admin','$2y$10$ToLIbjZ/Ro6.FyWKG9AAWe5S.NF7sACGEHBZ0Jovm9AuyQMDUgr0e','admin'),(14,'bob','$2y$10$9k1mq.9nAvbn85kwnH/BP.vpwElBeBOjnh2t9n5rV8BuK/EGs1Hj.','vendeur'),(15,'clash','$2y$10$MP8.SS7Ji1ievKlMAItrqOMWpNwpnC5Hf5Axujgp7SCw1MFOcuPce','vendeur'),(16,'test99','$2y$10$gJZ03WcJC.R56E7yM4Wt7.6NZq4ije9swjfsa5ut3Q7noZDw03pvG','vendeur'),(17,'essai','$2y$10$/sFlWLcu.QEfMRYYVC3kqecIfTV0YELneky99t.25bVPeUo8jockW','vendeur'),(18,'boss','$2y$10$c4FomKa2e3oDzHllv1Yb1OHIBJ43ZWa36rvd8Dgz0q6LerfqKEXq6','vendeur'),(19,'toufik','$2y$10$J/GyTFN6Odwc2nudv.8CAuiT.qQIHk5ShdPKyF2p9XxN1MmKlJRhm','vendeur'),(21,'qsdfs','$2y$10$xoG3BorLXFPdTMb/Yx1POeGlVM15kq/LayJwOs1//6NIXeqlNerpe','acheteur'),(22,'mohamed','$2y$10$9wsEpnRLYuYEsEQcjHtXJOAs9oynYL/v78VKgusN5/wt91RfpWukW','vendeur'),(23,'bandit','$2y$10$htHFYthxFMQ2Oqwm1RXlA.XLGVLkFL03HfJSFYCXS5OlCg8LOPq4C','acheteur'),(24,'jokerSell','$2y$10$YGMc9kJm81EZAKrFXRtujeVeHSYjXmDn1Q5vBSJrJwGSnSda8LNyi','vendeur'),(26,'gogoa','$2y$10$k3Wslf8HjrMgO5IFKEN1OO29/UdKw562yR/aLe2dl2shVR8/3jPNm','acheteur'),(27,'testn47','$2y$10$YFg1Eb1X0jQ/bOdvbsCEZukUQ157UXPkdXRRzfwKtHQnrDYf0z3.m','acheteur'),(28,'roro','$2y$10$HMGeMIqlv9OOn5HHVbXJnuxf5I/DdsYh13eKF.Y53ugneWUEN8HMm','vendeur'),(30,'lola','$2y$10$b2d5V2XkrDtKnlx54QdrPO8EHShshQZ19MsCbCwnRW804DwiiofyK','vendeur'),(31,'zozo','$2y$10$3kBdlLPvDZdkmaK5.qfyI.iZgNzakNukaLewXRIQ53us1VGVr7UQ.','vendeur'),(32,'jokerBuy','$2y$10$e6uM9/EJ.v.2hJ6p.T.dHOe2spt.08nw93J5d59s6.3oVXlfHBMPW','vendeur'),(33,'bobo','$2y$10$kWW4d3KrEkuYThZ69SS2t.RqUC.AzSu5AbEpYZronTxucOfYxVXFG','vendeur'),(34,'polo','$2y$10$T7E9AfisngP/uuHg4dZVFORxHhJ8pEMS6LQXIp50jtmVpSC3Eajbe','vendeur'),(35,'testoo','$2y$10$C634Its/5v6WK5EqZdDDj.ERyYYD6UkcyewH3n1Z4hxSTsFT7PAjy','acheteur'),(36,'Greg','$2y$10$DZn7fqGvkcu.K2puuAm3DeQG9F5svnkIgt0LUmJOQZQk7ZpmQmXka','vendeur'),(37,'voleur_vendeur','$2y$10$PJ031Y2KBZK9wpVgmRknX.GKRlEe05H.xOfCRLwD5PsUsVWg6.5su','vendeur'),(38,'matondo2','$2y$10$oGonFL2f.WDfN.2I95CzbudWP7bHX8XW3B5A01zO9DAvlt6ykFvg2','vendeur'),(39,'dadson_prod','$2y$10$tyITj36Np/QNxCfKVE1NbO8noowpWCWeMnR2WiF0rN/ill5mLUzKe','vendeur'),(43,'thomas_peugnet','$2y$10$kF7VAQ7/bNiS3cKmsRkKt.qE.rSqmiJoKX/Sp8CT8SQ/jqjkSbJ7.','acheteur'),(44,'prof','$2y$10$vxuS99CLNSb/P0DIZ2DS4.Y46cwQ3EmhepWOUADEP2pHPG.mpUUwK','vendeur'),(50,'momo','$2y$10$goZzy94h13bDwmMg6YPckexROBmVvV3djnV85o4hMx0JsqfowoYl.','vendeur');
/*!40000 ALTER TABLE `Utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devenirvendeur`
--

DROP TABLE IF EXISTS `devenirvendeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devenirvendeur` (
  `Nom` varchar(60) NOT NULL,
  PRIMARY KEY (`Nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devenirvendeur`
--

LOCK TABLES `devenirvendeur` WRITE;
/*!40000 ALTER TABLE `devenirvendeur` DISABLE KEYS */;
INSERT INTO `devenirvendeur` VALUES ('thomas_peugnet');
/*!40000 ALTER TABLE `devenirvendeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enchere`
--

DROP TABLE IF EXISTS `enchere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enchere` (
  `id_enchere` int NOT NULL AUTO_INCREMENT,
  `id_vendeur` int NOT NULL,
  `nom_article` varchar(255) NOT NULL,
  `description` text,
  `prix_depart` decimal(10,2) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `nom_vendeur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_enchere`),
  KEY `id_vendeur` (`id_vendeur`),
  CONSTRAINT `enchere_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `Utilisateur` (`ID_compte`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enchere`
--

LOCK TABLES `enchere` WRITE;
/*!40000 ALTER TABLE `enchere` DISABLE KEYS */;
INSERT INTO `enchere` VALUES (17,4,'essau','debja',800.00,'2023-05-27 00:00:00','2023-05-27 19:08:00','vetement','toto'),(18,4,'voiture','voiture des beaux',20000.00,'2023-05-28 00:00:00','2023-05-30 19:08:00','vetement','toto'),(19,4,'gourde','zdjhk',23.00,'2023-05-28 00:00:00','2023-05-28 19:57:00','vetement','toto'),(20,4,'testo','goih',30.00,'2023-05-28 00:00:00','2023-05-28 20:05:00','vetement','toto');
/*!40000 ALTER TABLE `enchere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `idmessage` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `expediteur` varchar(255) NOT NULL,
  `message` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmessage`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (30,'toto ','tata','reponse au message saluut : fofof','2023-05-18 14:17:30'),(31,'toto ','tata','reponse au message saluut : ouii\r\n','2023-05-18 14:19:44'),(32,'toto ','tata','reponse au message saluut : ok','2023-05-18 14:20:31'),(33,'toto ','tata','reponse au message saluut : jojo','2023-05-18 14:34:27'),(34,'toto ','tata','reponse au message saluut : lo\r\n','2023-05-18 14:35:27'),(35,'toto ','tata','koko','2023-05-18 14:36:19'),(36,'toto ','tata','reponse au message saluut : lolo\r\n','2023-05-18 14:38:07'),(37,'toto ','tata','reponse au message saluut : n','2023-05-18 14:38:47'),(38,'toto','tata','salut','2023-05-18 14:17:21'),(39,'toto ','tata','reponse au message saluut : k,lk,nkl,lk','2023-05-18 14:49:11'),(41,'toto ','tata','reponse au message trop nul : quoi ?','2023-05-18 14:50:29'),(42,'toto ','tata','reponse au message saluut : nknk','2023-05-18 14:59:02'),(43,'toto','tata','reponse au message trop nul : dcscs','2023-05-18 15:00:09'),(44,'toto','tata','reponse au message saluut : saliut','2023-05-18 15:00:27'),(45,'toto ','tata','reponse au message saluut : ye','2023-05-18 15:01:40'),(46,'toto ','tata','reponse au message trop nul : quoi? ','2023-05-18 15:03:55'),(47,'toto ','tata','reponse au message trop nul : ddd','2023-05-18 15:04:55'),(48,'toto ','tata','reponse au message saluut : dz','2023-05-18 15:07:23'),(49,'toto','tata','reponse au message saluut : ,zkl,kz','2023-05-18 15:07:57'),(50,'toto ','tata','reponse au message saluut : ;lk','2023-05-18 15:13:21'),(53,'toto ','tata','reponse au message trop nul : koko','2023-05-18 15:14:47'),(56,'toto ','tata','reponse au message trop beau : merci','2023-05-18 15:15:37'),(57,'toto ','tata','reponse au message trop beau : merci','2023-05-18 15:17:51'),(58,'toto ','tata','reponse au message reponse au message reponse au message trop nul : dcscs : ha bon ? : ce','2023-05-18 15:18:07'),(59,'toto ','tata','reponse au message trop beau : dzdzz','2023-05-18 15:18:56'),(64,'toto','tata','reponse au message reponse au message salut : jbnjn : dzdzzdzd','2023-05-18 16:17:41'),(70,'toto','toto ','bonjour','2023-05-18 17:53:35'),(71,'toto','tata ','salam','2023-05-18 17:55:36'),(73,'toufik','jokerSell ','test','2023-05-18 18:14:37'),(74,'0','jokerBuy ','Matondo est guez','2023-05-19 17:22:37'),(75,'toufik','jokerBuy ','Matondo est guez','2023-05-19 17:22:53'),(77,'Greg','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-20 13:14:01'),(78,'voleur_vendeur','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-20 13:16:46'),(79,'toto','toto ','Salut','2023-05-20 17:37:39'),(80,'jokerBuy','baba ','le goat est inestimable !','2023-05-20 23:04:11'),(81,'Greg','toto ','','2023-05-21 19:33:48'),(82,'jokerBuy','admin ','met plus cher batard','2023-05-21 20:05:04'),(83,'dadson_prod','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-21 21:31:17'),(87,'dadson_prod','toufik ','','2023-05-22 10:34:26'),(88,'predateur93','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-22 13:16:47'),(89,'toutou','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-22 13:29:37'),(90,'matondo2','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-22 20:36:21'),(91,'matondo2','thomas_peugnet ','Salut ma petite','2023-05-22 21:32:00'),(92,'thomas_peugnet ','matondo2','reponse au message Salut ma petite : hello','2023-05-22 21:32:32'),(93,'matondo2','thomas_peugnet','reponse au message reponse au message Salut ma petite : hello : haha','2023-05-22 21:33:11'),(94,'thomas_peugnet','matondo2','reponse au message reponse au message reponse au message Salut ma petite : hello : haha : toto','2023-05-22 21:33:39'),(95,'toto','toufik ','','2023-05-23 06:05:25'),(96,'prof','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-23 07:16:39'),(97,'souley','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-23 07:27:28'),(98,'','jokerSell ','','2023-05-24 18:25:10'),(99,'matondo2','toufik ','bopjnuo','2023-05-27 13:31:38'),(100,'$jokerBuy','toto ','Félicitations, vous avez remporté la vente aux enchères sur le produit testdfg avec un montant de !','2023-05-27 16:57:22'),(101,'$toufik','toto ','Félicitations, vous avez remporté la vente aux enchères sur le produit bobo avec un montant de !','2023-05-27 16:57:23'),(102,'$toufik','toto ','Félicitations, vous avez remporté la vente aux enchères sur le produit tester avec un montant de !','2023-05-27 16:57:23'),(103,'$toufik','toto ','Félicitations, vous avez remporté la vente aux enchères sur le produit HZB avec un montant de !','2023-05-27 16:57:23'),(104,'$toufik','toto ','Félicitations, vous avez remporté la vente aux enchères sur le produit test avec un montant de !','2023-05-27 16:57:23'),(105,'65641','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-28 06:47:54'),(106,'baba','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-28 08:45:09'),(107,'sasha','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-28 08:55:11'),(108,'macron','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-28 09:02:18'),(109,'momo','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-05-28 09:07:46'),(110,'momo','toto ','test','2023-06-19 12:02:55'),(111,'sasha','admin ','fkjbkjsdbkjldsnjdnlj','2023-09-04 09:02:41'),(112,'toufik','admin ','ncqnc;,c;,wn,;w','2023-09-04 09:02:55'),(113,'testJ','Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée','2023-09-04 09:03:17');
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participations`
--

DROP TABLE IF EXISTS `participations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participations` (
  `id_enchere` int NOT NULL,
  `id_acheteur` int NOT NULL,
  `prix_propose` decimal(10,2) NOT NULL,
  KEY `id_enchere` (`id_enchere`),
  KEY `id_acheteur` (`id_acheteur`),
  CONSTRAINT `participations_ibfk_1` FOREIGN KEY (`id_enchere`) REFERENCES `enchere` (`id_enchere`),
  CONSTRAINT `participations_ibfk_2` FOREIGN KEY (`id_acheteur`) REFERENCES `Utilisateur` (`ID_compte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participations`
--

LOCK TABLES `participations` WRITE;
/*!40000 ALTER TABLE `participations` DISABLE KEYS */;
INSERT INTO `participations` VALUES (17,32,890.00),(18,4,4000000.00),(17,4,300000.00),(19,4,50.00),(20,4,50.00);
/*!40000 ALTER TABLE `participations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reponse` (
  `idmessage` int NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `expediteur` varchar(255) NOT NULL,
  `message` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reponse`
--

LOCK TABLES `reponse` WRITE;
/*!40000 ALTER TABLE `reponse` DISABLE KEYS */;
INSERT INTO `reponse` VALUES (0,'toufik ','tata','reponse au message saluut : dddd','2023-05-18 15:52:13'),(0,'toufik ','tata','reponse au message trop beau : czzzz','2023-05-18 15:55:22'),(0,'toufik ','tata','reponse au message trop beau : dzdzdz','2023-05-18 15:56:13');
/*!40000 ALTER TABLE `reponse` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-21 14:13:42