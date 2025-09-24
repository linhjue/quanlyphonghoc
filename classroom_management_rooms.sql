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
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `room_id` int NOT NULL AUTO_INCREMENT,
  `room_code` varchar(20) NOT NULL,
  `building` varchar(50) DEFAULT NULL,
  `floor` int DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `room_type` enum('Lecture','Lab','Seminar','Other') NOT NULL,
  `status` enum('Available','Maintenance','Inactive') DEFAULT 'Available',
  `note` text,
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `room_code` (`room_code`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'A101','Building A',1,50,'Lecture','Available','Máy chiếu tốt'),(2,'A202','Building A',2,30,'Lab','Available','Phòng máy tính 30 máy'),(3,'B305','Building B',3,80,'Lecture','Maintenance','Đang sửa máy lạnh'),(4,'C201','Building C',2,25,'Seminar','Available','Phòng họp nhỏ'),(5,'D101','Building D',1,100,'Lecture','Inactive','Ít sử dụng'),(6,'D201','Building D',1,40,'Lecture','Available','Phòng mới, đầy đủ thiết bị'),(7,'D202','Building D',1,50,'Lab','Available','Phòng thí nghiệm hóa học'),(8,'E301','Building E',2,30,'Seminar','Maintenance','Đang sửa chữa hệ thống'),(9,'E302','Building E',2,45,'Lecture','Available','Phòng có máy chiếu'),(10,'F401','Building F',3,60,'Lab','Available','Phòng máy tính hiện đại'),(11,'F402','Building F',3,35,'Seminar','Available','Phòng họp nhỏ'),(12,'G201','Building G',1,50,'Lecture','Available','Phòng sáng sủa'),(13,'G202','Building G',1,40,'Lab','Maintenance','Đang nâng cấp thiết bị'),(14,'H301','Building H',2,55,'Lecture','Available','Phòng có wifi'),(15,'H302','Building H',2,30,'Seminar','Available','Phòng yên tĩnh'),(16,'I401','Building I',3,45,'Lab','Available','Phòng thí nghiệm vật lý'),(17,'I402','Building I',3,50,'Lecture','Maintenance','Đang kiểm tra điện'),(18,'J201','Building J',1,35,'Seminar','Available','Phòng có bảng tương tác'),(19,'J202','Building J',1,60,'Lecture','Available','Phòng lớn'),(20,'K301','Building K',2,40,'Lab','Available','Phòng sinh học'),(21,'K302','Building K',2,45,'Lecture','Available','Phòng mới khai trương'),(22,'L401','Building L',3,30,'Seminar','Maintenance','Đang sơn lại'),(23,'L402','Building L',3,55,'Lab','Available','Phòng hóa học nâng cao'),(24,'M201','Building M',1,50,'Lecture','Available','Phòng có điều hòa'),(25,'M202','Building M',1,40,'Seminar','Available','Phòng họp nhóm');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-23 22:20:40
