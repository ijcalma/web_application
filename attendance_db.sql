-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: attendance_db
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `student_id` int NOT NULL,
  `eventid` int NOT NULL,
  `timein_am` datetime DEFAULT NULL,
  `timeout_am` datetime DEFAULT NULL,
  `timein_pm` datetime DEFAULT NULL,
  `timeout_pm` datetime DEFAULT NULL,
  PRIMARY KEY (`student_id`,`eventid`),
  KEY `studentid_idx` (`student_id`),
  KEY `eventid_idx` (`eventid`),
  CONSTRAINT `eventid` FOREIGN KEY (`eventid`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `studentid` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (202080001,20,NULL,NULL,'2023-05-31 22:10:48',NULL),(202080001,21,NULL,NULL,'2023-05-31 22:11:45',NULL),(202080002,20,NULL,NULL,'2023-05-31 22:10:53',NULL),(202080003,20,NULL,NULL,'2023-05-31 22:13:14',NULL),(202080004,20,NULL,NULL,'2023-05-31 22:13:22',NULL),(202080028,20,NULL,NULL,'2023-05-31 22:13:27',NULL),(202080028,21,NULL,NULL,'2023-05-31 22:11:33',NULL),(202080030,20,NULL,NULL,'2023-05-31 22:13:33',NULL);
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_attendance`
--

DROP TABLE IF EXISTS `event_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_attendance` (
  `studentid` int DEFAULT NULL,
  `eventid` int DEFAULT NULL,
  `timein_no` int NOT NULL,
  `timeout_no` int NOT NULL,
  `event_total_timein` int DEFAULT NULL,
  `event_total_timeout` int DEFAULT NULL,
  `event_total_absents` int DEFAULT NULL,
  KEY `event_idx` (`eventid`),
  KEY `student_idx` (`studentid`),
  CONSTRAINT `event` FOREIGN KEY (`eventid`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student` FOREIGN KEY (`studentid`) REFERENCES `student_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_attendance`
--

LOCK TABLES `event_attendance` WRITE;
/*!40000 ALTER TABLE `event_attendance` DISABLE KEYS */;
INSERT INTO `event_attendance` VALUES (202080001,20,1,0,1,1,1),(202080002,20,1,0,1,1,1),(202080028,21,1,0,1,1,1),(202080001,21,1,0,1,1,1),(202080003,20,1,0,1,1,1),(202080004,20,1,0,1,1,1),(202080028,20,1,0,1,1,1),(202080030,20,1,0,1,1,1);
/*!40000 ALTER TABLE `event_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(45) DEFAULT NULL,
  `type` enum('Whole Day','Half Day') DEFAULT NULL,
  `half_day_type` enum('Morning','Afternoon') DEFAULT NULL,
  `eventdate` date DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (20,'Bootcamp','Half Day','Afternoon','2023-05-31'),(21,'Bootcamp','Half Day','Afternoon','2023-06-01'),(22,'Graduation','Whole Day',NULL,'2023-06-03');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notif_students`
--

DROP TABLE IF EXISTS `notif_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notif_students` (
  `notif_id` int DEFAULT NULL,
  `students_id` int DEFAULT NULL,
  KEY `notifid_idx` (`notif_id`),
  KEY `studid_idx` (`students_id`),
  CONSTRAINT `notifid` FOREIGN KEY (`notif_id`) REFERENCES `notification` (`idnotification`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `studid` FOREIGN KEY (`students_id`) REFERENCES `student_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notif_students`
--

LOCK TABLES `notif_students` WRITE;
/*!40000 ALTER TABLE `notif_students` DISABLE KEYS */;
INSERT INTO `notif_students` VALUES (42,202080028),(45,202080028),(46,202080028),(47,202080028),(48,202080028),(49,202080028),(50,202080028),(51,202080028),(52,202080028),(53,202080028),(54,202080028),(55,202080028),(56,202080028),(57,202080028),(58,202080028),(59,202080028),(60,202080028),(61,202080028),(62,202080028),(63,202080028),(64,202080028),(65,202080028),(66,202080028),(67,202080028),(68,202080028),(69,202080028),(70,202080028),(71,202080028),(72,202080028),(73,202080028),(74,202080028),(75,202080028),(76,202080028),(77,202080028),(78,202080028),(79,202080028),(80,202080028),(81,202080028),(82,202080028),(83,202080028),(84,202080030),(85,202080030),(86,202080028),(89,202080028),(90,202080028),(92,202080030),(93,202080030),(94,202080028),(95,202080030),(96,202080030),(97,202080028),(98,202080028),(99,202080028),(100,202080028),(101,202080028),(102,202080030),(103,202080030),(104,202080030),(105,202080001),(106,202080002),(107,202080003),(108,202080003),(109,202080004),(110,202080001),(111,202080002),(112,202080003),(113,202080004),(114,202080001),(115,202080002),(116,202080003),(117,202080004),(119,202080028),(120,202080030),(121,202080001),(122,202080002),(123,202080003),(124,202080004),(125,202080028),(126,202080030),(127,202080001),(128,202080002),(129,202080003),(130,202080003),(131,202080004),(132,202080028),(133,202080030),(134,202080001),(135,202080001),(136,202080001),(137,202080002),(138,202080028),(139,202080001),(140,202080003),(141,202080004),(142,202080028),(143,202080030);
/*!40000 ALTER TABLE `notif_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification` (
  `idnotification` int NOT NULL AUTO_INCREMENT,
  `notification` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idnotification`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (42,'Student 202080028 logged in this morning.','2023-05-21 10:15:12'),(45,'Student 202080028 logged out this morning.','2023-05-21 10:26:04'),(46,'Student 202080028 logged in this afternoon.','2023-05-27 20:57:28'),(47,'Student 202080028 logged in this afternoon.','2023-05-27 20:59:32'),(48,'Student 202080028 logged in this afternoon.','2023-05-27 21:20:35'),(49,'Student 202080028 logged in this afternoon.','2023-05-27 21:21:50'),(50,'Student 202080028 logged in this afternoon.','2023-05-27 21:22:46'),(51,'Student 202080028 logged in this afternoon.','2023-05-27 21:23:00'),(52,'Student 202080028 logged in this afternoon.','2023-05-27 21:24:20'),(53,'Student 202080028 logged in this afternoon.','2023-05-27 21:29:25'),(54,'Student 202080028 logged in this afternoon.','2023-05-27 21:32:40'),(55,'Student 202080028 logged in this afternoon.','2023-05-27 21:36:35'),(56,'Student 202080028 logged in this afternoon.','2023-05-27 21:38:01'),(57,'Student 202080028 logged in this afternoon.','2023-05-27 21:38:26'),(58,'Student 202080028 logged in this afternoon.','2023-05-27 21:52:07'),(59,'Student 202080028 logged in this afternoon.','2023-05-27 21:53:56'),(60,'Student 202080028 logged in this afternoon.','2023-05-27 21:56:17'),(61,'Student 202080028 logged in this afternoon.','2023-05-27 21:56:24'),(62,'Student 202080028 logged in this afternoon.','2023-05-27 22:00:49'),(63,'Student 202080028 logged in this afternoon.','2023-05-27 22:01:54'),(64,'Student 202080028 logged in this afternoon.','2023-05-27 22:03:17'),(65,'Student 202080028 logged in this afternoon.','2023-05-27 22:03:24'),(66,'Student 202080028 logged in this afternoon.','2023-05-27 22:04:08'),(67,'Student 202080028 logged in this afternoon.','2023-05-27 22:04:16'),(68,'Student 202080028 logged in this afternoon.','2023-05-27 22:08:05'),(69,'Student 202080028 logged in this afternoon.','2023-05-27 22:10:14'),(70,'Student 202080028 logged in this afternoon.','2023-05-27 22:12:28'),(71,'Student 202080028 logged in this afternoon.','2023-05-27 22:17:00'),(72,'Student 202080028 logged in this afternoon.','2023-05-27 22:17:56'),(73,'Student 202080028 logged in this afternoon.','2023-05-27 22:19:19'),(74,'Student 202080028 logged in this afternoon.','2023-05-27 22:19:51'),(75,'Student 202080028 logged in this afternoon.','2023-05-27 22:21:35'),(76,'Student 202080028 logged in this afternoon.','2023-05-27 22:21:48'),(77,'Student 202080028 logged in this afternoon.','2023-05-27 22:22:55'),(78,'Student 202080028 logged in this afternoon.','2023-05-27 22:25:12'),(79,'Student 202080028 logged in this afternoon.','2023-05-27 22:26:16'),(80,'Student 202080028 logged in this afternoon.','2023-05-27 22:30:44'),(81,'Student 202080028 logged in this afternoon.','2023-05-27 22:32:55'),(82,'Student 202080028 logged in this afternoon.','2023-05-27 22:33:11'),(83,'Student 202080028 logged in this afternoon.','2023-05-27 22:34:19'),(84,'Student 202080030 logged in this afternoon.','2023-05-27 22:36:45'),(85,'Student 202080030 logged in this afternoon.','2023-05-27 22:36:52'),(86,'Student 202080028 logged in this afternoon.','2023-05-27 22:38:04'),(87,'Student 202080001 logged in this afternoon.','2023-05-27 22:39:36'),(88,'Student 202080001 logged in this afternoon.','2023-05-27 22:41:39'),(89,'Student 202080028 logged in this afternoon.','2023-05-27 22:43:30'),(90,'Student 202080028 logged in this afternoon.','2023-05-27 22:43:42'),(91,'Student 202080001 logged in this afternoon.','2023-05-27 22:45:26'),(92,'Student 202080030 logged in this afternoon.','2023-05-27 22:47:58'),(93,'Student 202080030 logged in this afternoon.','2023-05-27 22:49:40'),(94,'Student 202080028 logged in this afternoon.','2023-05-27 22:50:44'),(95,'Student 202080030 logged in this afternoon.','2023-05-27 22:50:56'),(96,'Student 202080030 logged in this afternoon.','2023-05-27 22:54:00'),(97,'Student 202080028 logged in this afternoon.','2023-05-30 18:28:18'),(98,'Student 202080028 logged in this afternoon.','2023-05-30 18:29:10'),(99,'Student 202080028 logged in this afternoon.','2023-05-30 18:31:16'),(100,'Student 202080028 logged in this afternoon.','2023-05-30 18:46:07'),(101,'Student 202080028 logged in this afternoon.','2023-05-30 18:46:20'),(102,'Student 202080030 logged in this afternoon.','2023-05-30 19:06:12'),(103,'Student 202080030 logged in this afternoon.','2023-05-30 19:06:20'),(104,'Student 202080030 logged in this afternoon.','2023-05-30 19:06:27'),(105,'Student 202080001 logged in this afternoon.','2023-05-31 21:32:54'),(106,'Student 202080002 logged in this afternoon.','2023-05-31 21:33:03'),(107,'Student 202080003 logged in this afternoon.','2023-05-31 21:33:07'),(108,'Student 202080003 logged in this afternoon.','2023-05-31 21:33:12'),(109,'Student 202080004 logged in this afternoon.','2023-05-31 21:33:17'),(110,'Student 202080001 logged in this afternoon.','2023-05-31 21:33:23'),(111,'Student 202080002 logged in this afternoon.','2023-05-31 21:33:27'),(112,'Student 202080003 logged in this afternoon.','2023-05-31 21:33:32'),(113,'Student 202080004 logged in this afternoon.','2023-05-31 21:33:37'),(114,'Student 202080001 logged in this afternoon.','2023-05-31 21:51:17'),(115,'Student 202080002 logged in this afternoon.','2023-05-31 21:51:21'),(116,'Student 202080003 logged in this afternoon.','2023-05-31 21:51:25'),(117,'Student 202080004 logged in this afternoon.','2023-05-31 21:51:29'),(118,'Student 202080005 logged in this afternoon.','2023-05-31 21:51:32'),(119,'Student 202080028 logged in this afternoon.','2023-05-31 21:51:44'),(120,'Student 202080030 logged in this afternoon.','2023-05-31 21:51:49'),(121,'Student 202080001 logged in this afternoon.','2023-05-31 22:04:42'),(122,'Student 202080002 logged in this afternoon.','2023-05-31 22:04:47'),(123,'Student 202080003 logged in this afternoon.','2023-05-31 22:04:51'),(124,'Student 202080004 logged in this afternoon.','2023-05-31 22:04:56'),(125,'Student 202080028 logged in this afternoon.','2023-05-31 22:05:02'),(126,'Student 202080030 logged in this afternoon.','2023-05-31 22:05:07'),(127,'Student 202080001 logged in this afternoon.','2023-05-31 22:06:27'),(128,'Student 202080002 logged in this afternoon.','2023-05-31 22:06:31'),(129,'Student 202080003 logged in this afternoon.','2023-05-31 22:06:37'),(130,'Student 202080003 logged in this afternoon.','2023-05-31 22:06:41'),(131,'Student 202080004 logged in this afternoon.','2023-05-31 22:06:45'),(132,'Student 202080028 logged in this afternoon.','2023-05-31 22:06:50'),(133,'Student 202080030 logged in this afternoon.','2023-05-31 22:06:54'),(134,'Student 202080001 logged in this afternoon.','2023-05-31 22:08:45'),(135,'Student 202080001 logged in this afternoon.','2023-05-31 22:09:46'),(136,'Student 202080001 logged in this afternoon.','2023-05-31 22:10:48'),(137,'Student 202080002 logged in this afternoon.','2023-05-31 22:10:53'),(138,'Student 202080028 logged in this afternoon.','2023-05-31 22:11:33'),(139,'Student 202080001 logged in this afternoon.','2023-05-31 22:11:45'),(140,'Student 202080003 logged in this afternoon.','2023-05-31 22:13:14'),(141,'Student 202080004 logged in this afternoon.','2023-05-31 22:13:22'),(142,'Student 202080028 logged in this afternoon.','2023-05-31 22:13:27'),(143,'Student 202080030 logged in this afternoon.','2023-05-31 22:13:33');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_info`
--

DROP TABLE IF EXISTS `student_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_info` (
  `id` int NOT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `extname` varchar(45) DEFAULT NULL,
  `course` varchar(45) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `block` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_info`
--

LOCK TABLES `student_info` WRITE;
/*!40000 ALTER TABLE `student_info` DISABLE KEYS */;
INSERT INTO `student_info` VALUES (202080001,'Llado','Maurene','Cayao','','BSIT','Third Year','Block 1'),(202080002,'Orga','Sean','Dalope','','BSIT','Third Year','Block 1'),(202080003,'Gabayan','Angel','Mae','','BSIT','Third Year','Block 1'),(202080004,'Dorero','Charles','Jazon','','BSIT','Third Year','Block 1'),(202080028,'Calma','Ingrid','Santiaguel','III','BSIT','Third Year','Block 1'),(202080030,'Casayas','Jiezca','Padios','','BSIT','Third Year','Block 1');
/*!40000 ALTER TABLE `student_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `total_events_attendance`
--

DROP TABLE IF EXISTS `total_events_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `total_events_attendance` (
  `total_events_timein_no` int DEFAULT NULL,
  `total_events_timeout_no` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `total_events_attendance`
--

LOCK TABLES `total_events_attendance` WRITE;
/*!40000 ALTER TABLE `total_events_attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `total_events_attendance` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-31 23:53:57
