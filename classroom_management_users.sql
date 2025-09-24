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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('Admin','Lecturer','Student') NOT NULL,
  `student_code` varchar(20) DEFAULT NULL,
  `lecturer_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `student_code` (`student_code`),
  UNIQUE KEY `lecturer_code` (`lecturer_code`),
  CONSTRAINT `fk_lecturer_code` FOREIGN KEY (`lecturer_code`) REFERENCES `lecturers_list` (`lecturer_code`),
  CONSTRAINT `fk_student_code` FOREIGN KEY (`student_code`) REFERENCES `students_list` (`student_code`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin1','123456','admin1@univ.edu',NULL,'Admin',NULL,NULL),(2,'lecturer1','abc123','lecturer1@univ.edu',NULL,'Lecturer',NULL,'L001'),(3,'lecturer2','abc456','lecturer2@univ.edu',NULL,'Lecturer',NULL,'L002'),(4,'lecturer3','def789','lecturer3@univ.edu','TS. Trần Thị A','Lecturer',NULL,'L003'),(6,'lecturer4','ghi456','lecturer4@univ.edu',NULL,'Lecturer',NULL,'L004'),(7,'studen123','$2y$10$cBwhyBBIhsPbzSJ/9a3Hbe5RVG.vXzcUxUcRgkd/16DW8XHiK.k0C','dl2banana6@gmail.com','Nguyễn Văn Q','Student',NULL,NULL),(10,'lecturer5','jkl012','lecturer5@univ.edu','PGS. Phạm Văn D','Lecturer',NULL,'L005'),(12,'lecturer6','mno345','lecturer6@univ.edu','TS. Hoàng Thị E','Lecturer',NULL,'L006');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
