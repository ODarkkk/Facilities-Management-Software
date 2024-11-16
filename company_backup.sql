-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: company
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookmark` (
  `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `people_id` int(55) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `selected_date` date NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`bookmark_id`),
  KEY `user` (`people_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `Bookmark_Offices_room_FK` FOREIGN KEY (`room_id`) REFERENCES `offices_room` (`room_id`),
  CONSTRAINT `Bookmark_People_FK` FOREIGN KEY (`people_id`) REFERENCES `people` (`people_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmark`
--

LOCK TABLES `bookmark` WRITE;
/*!40000 ALTER TABLE `bookmark` DISABLE KEYS */;
INSERT INTO `bookmark` VALUES (6,1,3,'2024-06-13 23:00:00','00:00:00','00:00:00','2024-06-14',0),(7,1,3,'2024-05-06 23:00:00','00:00:00','00:00:00','2024-05-07',0),(8,1,3,'2024-05-06 23:00:00','00:00:00','00:00:00','2024-05-07',0),(9,1,3,'2024-05-05 23:00:00','00:00:00','00:00:00','2024-05-06',1),(10,1,3,'2024-05-05 23:00:00','00:00:00','00:00:00','2024-05-06',1),(11,1,3,'2024-05-06 13:57:13','14:47:00','14:50:00','2024-05-06',1),(12,1,3,'2024-05-06 13:57:51','17:57:00','19:57:00','2024-05-06',1),(13,1,3,'2024-05-06 13:58:11','16:58:00','18:58:00','2024-05-06',1),(14,1,3,'2024-05-06 14:18:32','15:18:00','15:19:00','2024-05-06',1),(15,1,3,'2024-05-06 14:21:02','16:20:00','18:20:00','2024-05-06',1),(16,1,3,'2024-05-06 14:21:17','21:21:00','22:21:00','2024-05-06',1);
/*!40000 ALTER TABLE `bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `building_offices`
--

DROP TABLE IF EXISTS `building_offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `building_offices` (
  `building_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL,
  PRIMARY KEY (`building_id`,`office_id`),
  KEY `building_id` (`building_id`),
  KEY `office_id` (`office_id`),
  CONSTRAINT `Building_offices_Building_FK` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`),
  CONSTRAINT `Building_offices_Offices_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building_offices`
--

LOCK TABLES `building_offices` WRITE;
/*!40000 ALTER TABLE `building_offices` DISABLE KEYS */;
INSERT INTO `building_offices` VALUES (1,1),(1,2),(2,2);
/*!40000 ALTER TABLE `building_offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'Building 1','Main building'),(2,'Head Office','Principal Building');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`department_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `Department_Roles_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'IT',1),(2,'HR',2);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offices`
--

DROP TABLE IF EXISTS `offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL AUTO_INCREMENT,
  `office_image` longblob NOT NULL,
  `office_name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`office_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offices`
--

LOCK TABLES `offices` WRITE;
/*!40000 ALTER TABLE `offices` DISABLE KEYS */;
INSERT INTO `offices` VALUES (1,'','Office A','Main office'),(2,'','Office B','Secondary office'),(4,'','Office C','Third office'),(5,'','Office D','Fourth office'),(6,'','Office E','New office'),(7,'','Office F','Old office'),(8,'','Office E','New office'),(9,'','Office F','Old office'),(10,'','Office E','New office'),(11,'','Office F','Old office'),(12,'','Office E','New office'),(13,'','Office F','Old office'),(14,'','Office E','New office'),(15,'','Office F','Old office'),(16,'','Office E','New office'),(17,'','Office F','Old office'),(18,'','Office E','New office'),(19,'','Office F','Old office'),(20,'','Office E','New office'),(21,'','Office F','Old office'),(22,'','Office E','New office'),(23,'','Office F','Old office'),(24,'','Office E','New office'),(25,'','Office F','Old office');
/*!40000 ALTER TABLE `offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offices_room`
--

DROP TABLE IF EXISTS `offices_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offices_room` (
  `office_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  PRIMARY KEY (`office_id`,`room_id`),
  KEY `office_id` (`office_id`,`room_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `Offices_room_Oficces_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`),
  CONSTRAINT `Offices_room_Room_FK` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offices_room`
--

LOCK TABLES `offices_room` WRITE;
/*!40000 ALTER TABLE `offices_room` DISABLE KEYS */;
INSERT INTO `offices_room` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `offices_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date of birth` date NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `nationality` varchar(55) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `password_status` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`people_id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `user_2` (`user`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `People_Department_FK` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (3,'DAnastacio','Diogo Ferreira Anastácio','0000-00-00',1,NULL,'123456789','diogo.anastacio.30473@esgc.pt','',1,0,0);
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recover`
--

DROP TABLE IF EXISTS `recover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recover` (
  `recover_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`recover_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recover`
--

LOCK TABLES `recover` WRITE;
/*!40000 ALTER TABLE `recover` DISABLE KEYS */;
INSERT INTO `recover` VALUES (1,'john_doe','john.doe@example.com','1234567890','',0);
/*!40000 ALTER TABLE `recover` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(55) NOT NULL,
  PRIMARY KEY (`role_id`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Employee');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'Meeting Room 1','Conference room for team meetings'),(5,'Meeting Room 2','Large conference room');
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-15 23:08:15
