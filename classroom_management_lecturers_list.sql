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
-- Table structure for table `lecturers_list`
--

DROP TABLE IF EXISTS `lecturers_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturers_list` (
  `lecturer_code` varchar(20) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`lecturer_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers_list`
--

LOCK TABLES `lecturers_list` WRITE;
/*!40000 ALTER TABLE `lecturers_list` DISABLE KEYS */;
INSERT INTO `lecturers_list` VALUES ('L001','Dr. Nguyen Van D','Computer Science'),('L002','Dr. Tran Thi E','Mathematics'),('L003','TS. Trần Thị A','Physics'),('L004','PGS. Phạm Văn D','Chemistry'),('L005','TS. Hoàng Thị E','Biology'),('L006','TS. Hoàng Thị E','History'),('L007','GS. Nguyễn Văn G','Mathematics'),('L008','TS. Lê Thị H','Computer Science'),('L009','PGS. Trần Văn I','Physics'),('L010','TS. Phạm Thị K','Chemistry'),('L011','GS. Hoàng Văn L','Biology'),('L012','TS. Vũ Thị M','History'),('L013','PGS. Nguyễn Văn N','Mathematics'),('L014','TS. Đỗ Thị O','Computer Science'),('L015','GS. Trần Văn P','Physics'),('L016','TS. Lê Văn Q','Chemistry'),('L017','PGS. Phạm Thị R','Biology'),('L018','TS. Nguyễn Văn S','History'),('L019','GS. Hoàng Thị T','Mathematics'),('L020','TS. Vũ Văn U','Computer Science'),('L021','PGS. Trần Thị V','Physics'),('L022','TS. Lê Văn X','Chemistry'),('L023','GS. Phạm Văn Y','Biology'),('L024','TS. Nguyễn Thị Z','History'),('L025','PGS. Đỗ Văn A','Mathematics'),('L026','TS. Hoàng Thị B','Computer Science');
/*!40000 ALTER TABLE `lecturers_list` ENABLE KEYS */;
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
