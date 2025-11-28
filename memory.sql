-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: memory
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (1,'Abeille','Abeille.png'),(2,'Carpe','Carpe.png'),(3,'Chien Verrin','ChienVerrin.png'),(4,'Coq','Coq.png'),(5,'Corbeau','Corbeau.png'),(6,'Dragon','Dragon.png'),(7,'Faisan','Faisan.png'),(8,'Goéland','Goéland.png'),(9,'Grenouille','Grenouille.png'),(10,'Grue','Grue.png'),(11,'Lapin','Lapin.png'),(12,'Lucioles','Lucioles.png'),(13,'Oiseau','Oiseau.png'),(14,'Paon','Paon.png'),(15,'Pic','Pic.png'),(16,'Poulpe','Poulpe.png'),(17,'Renard','Renard.png'),(18,'Sanglier','Sanglier.png'),(19,'Serpent','Serpent.png'),(20,'Shika','Shika.png'),(21,'Souris','Souris.png'),(22,'Tigre','Tigre.png'),(23,'Tortue','Tortue.png');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_cards`
--

DROP TABLE IF EXISTS `game_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game_cards` (
  `game_id` int NOT NULL,
  `card_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`card_id`),
  KEY `idx_game_id` (`game_id`),
  KEY `idx_card_id` (`card_id`),
  CONSTRAINT `game_cards_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_cards_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_cards`
--

LOCK TABLES `game_cards` WRITE;
/*!40000 ALTER TABLE `game_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `player_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pairs` int NOT NULL,
  `moves` int NOT NULL,
  `score` float GENERATED ALWAYS AS ((`moves` / `pairs`)) STORED,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('started','finished','abandoned') COLLATE utf8mb4_unicode_ci DEFAULT 'started',
  `finished_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_player_name` (`player_name`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `games_chk_1` CHECK ((`pairs` > 0)),
  CONSTRAINT `games_chk_2` CHECK ((`moves` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` (`id`, `player_name`, `pairs`, `moves`, `created_at`, `status`, `finished_at`) VALUES (1,'Alain',3,0,'2025-11-25 14:38:44','started',NULL),(2,'solaylevent',3,3,'2025-11-25 14:42:48','started',NULL),(3,'solaylevent',3,5,'2025-11-25 14:43:09','started',NULL),(4,'solaylevent',3,5,'2025-11-25 14:44:51','started',NULL),(5,'Arthur',3,3,'2025-11-25 15:30:35','started',NULL),(6,'Sylvain',3,4,'2025-11-26 09:32:20','started',NULL),(7,'Sylvain',3,2,'2025-11-26 12:35:18','started',NULL),(8,'Essai',3,8,'2025-11-26 12:44:50','started',NULL),(9,'Sylvain',3,4,'2025-11-27 13:13:40','started',NULL),(10,'NOUVEAU',3,5,'2025-11-27 14:34:54','started',NULL),(11,'NEWNEW',3,4,'2025-11-27 14:41:31','started',NULL),(12,'Christophe',3,6,'2025-11-28 09:24:34','started',NULL),(13,'Alain',3,4,'2025-11-28 09:27:38','started',NULL),(14,'A-zix_MVC',3,4,'2025-11-28 09:28:24','started',NULL),(15,'CONF',6,2,'2025-11-28 09:35:35','started',NULL),(16,'FONK',3,7,'2025-11-28 09:35:46','started',NULL),(17,'A-zix_MVC',12,1,'2025-11-28 09:36:52','started',NULL),(18,'Arthur',3,0,'2025-11-28 09:37:01','started',NULL);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `leaderboard`
--

DROP TABLE IF EXISTS `leaderboard`;
/*!50001 DROP VIEW IF EXISTS `leaderboard`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `leaderboard` AS SELECT 
 1 AS `player_name`,
 1 AS `score`,
 1 AS `created_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `leaderboard`
--

/*!50001 DROP VIEW IF EXISTS `leaderboard`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `leaderboard` AS select `g`.`player_name` AS `player_name`,(`g`.`moves` / `g`.`pairs`) AS `score`,`g`.`created_at` AS `created_at` from `games` `g` where (`g`.`status` = 'finished') order by (`g`.`moves` / `g`.`pairs`) */;
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

-- Dump completed on 2025-11-28 10:45:59
