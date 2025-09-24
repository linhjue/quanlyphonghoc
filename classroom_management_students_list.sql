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
-- Table structure for table `students_list`
--

DROP TABLE IF EXISTS `students_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students_list` (
  `student_code` varchar(20) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`student_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_list`
--

LOCK TABLES `students_list` WRITE;
/*!40000 ALTER TABLE `students_list` DISABLE KEYS */;
INSERT INTO `students_list` VALUES ('S001','Nguyen Van A','Computer Science'),('S002','Tran Thi B','Physics'),('S003','Le Van C','Mathematics'),('S005','Trần Thị D','Physics'),('S006','Lê Văn E','Chemistry'),('S007','Phạm Thị F','Biology'),('S008','Nguyễn Văn G','History'),('S009','Hoàng Thị H','Computer Science'),('S010','Vũ Văn I','Mathematics'),('S011','Đỗ Thị K','Physics'),('S012','Trần Văn L','Chemistry'),('S013','Lê Thị M','Biology'),('S014','Phạm Văn N','History'),('S015','Nguyễn Thị O','Computer Science'),('S016','Hoàng Văn P','Mathematics'),('S017','Vũ Thị Q','Physics'),('S018','Đỗ Văn R','Chemistry'),('S019','Trần Thị S','Biology'),('S020','Lê Văn T','History'),('S021','Phạm Thị U','Computer Science'),('S022','Nguyễn Văn V','Mathematics'),('S023','Hoàng Thị X','Physics'),('S024','Vũ Văn Y','Chemistry');
/*!40000 ALTER TABLE `students_list` ENABLE KEYS */;
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
