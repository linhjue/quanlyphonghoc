-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: classroom_management
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `schedule_id` int NOT NULL AUTO_INCREMENT,
  `class_id` int DEFAULT NULL,
  `room_id` int DEFAULT NULL,
  `lecturer_id` int DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `day_of_week` enum('Mon','Tue','Wed','Thu','Fri','Sat','Sun') DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  KEY `class_id` (`class_id`),
  KEY `room_id` (`room_id`),
  KEY `lecturer_id` (`lecturer_id`),
  CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (3,3,3,2,'2025-09-24 09:00:00','2025-09-24 11:00:00','Wed'),(4,4,5,3,'2025-09-25 14:00:00','2025-09-25 16:00:00','Thu'),(5,1,1,2,'2025-09-26 10:00:00','2025-09-26 12:00:00','Fri'),(6,5,2,2,'2025-09-27 09:00:00','2025-09-27 11:00:00','Sat'),(7,6,3,3,'2025-09-28 14:00:00','2025-09-28 16:00:00','Sun'),(8,7,4,4,'2025-09-29 10:00:00','2025-09-29 12:00:00','Mon'),(9,8,5,6,'2025-09-30 08:00:00','2025-09-30 10:00:00','Tue'),(10,9,6,10,'2025-10-01 13:00:00','2025-10-01 15:00:00','Wed'),(11,10,7,12,'2025-10-02 09:30:00','2025-10-02 11:30:00','Thu'),(12,11,8,2,'2025-10-03 14:30:00','2025-10-03 16:30:00','Fri'),(13,12,9,3,'2025-10-04 10:30:00','2025-10-04 12:30:00','Sat'),(14,13,10,4,'2025-10-05 08:30:00','2025-10-05 10:30:00','Sun'),(15,14,11,6,'2025-10-06 13:30:00','2025-10-06 15:30:00','Mon'),(16,1,12,10,'2025-10-07 09:00:00','2025-10-07 11:00:00','Tue'),(17,2,13,12,'2025-10-08 14:00:00','2025-10-08 16:00:00','Wed'),(18,3,14,2,'2025-10-09 10:00:00','2025-10-09 12:00:00','Thu'),(19,4,1,3,'2025-10-10 08:00:00','2025-10-10 10:00:00','Fri'),(20,5,2,4,'2025-10-11 13:00:00','2025-10-11 15:00:00','Sat'),(21,6,3,6,'2025-10-12 09:30:00','2025-10-12 11:30:00','Sun'),(22,7,4,10,'2025-10-13 14:30:00','2025-10-13 16:30:00','Mon'),(23,8,5,12,'2025-10-14 10:30:00','2025-10-14 12:30:00','Tue'),(24,9,6,2,'2025-10-15 08:30:00','2025-10-15 10:30:00','Wed'),(25,10,7,3,'2025-10-16 13:30:00','2025-10-16 15:30:00','Thu');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-23 22:20:39
