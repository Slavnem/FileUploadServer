-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: MainDB
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Languages`
--

DROP TABLE IF EXISTS `Languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Languages` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `short` varchar(6) NOT NULL,
  `subshort` varchar(6) NOT NULL,
  `name` varchar(24) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `xlanguages_short` (`short`(4)),
  KEY `xlanguages_name` (`name`(16))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Languages`
--

LOCK TABLES `Languages` WRITE;
/*!40000 ALTER TABLE `Languages` DISABLE KEYS */;
INSERT INTO `Languages` VALUES (1,'en','us','English [US]'),(2,'tr','tr','Türkçe'),(3,'ru','ru','Русский'),(4,'en','uk','English');
/*!40000 ALTER TABLE `Languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Membership`
--

DROP TABLE IF EXISTS `Membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Membership` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `membered` tinyint NOT NULL,
  `definition` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membered` (`membered`),
  KEY `xmembership_membered` (`membered`),
  KEY `xmembership_definition` (`definition`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Membership`
--

LOCK TABLES `Membership` WRITE;
/*!40000 ALTER TABLE `Membership` DISABLE KEYS */;
INSERT INTO `Membership` VALUES (1,0,'None'),(2,1,'Bronze'),(3,2,'Silver'),(4,3,'Gold'),(5,99,'Admin'),(6,98,'Moderator');
/*!40000 ALTER TABLE `Membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `memberedid` tinyint NOT NULL DEFAULT '0',
  `languageid` tinyint unsigned NOT NULL DEFAULT '1',
  `verifiedid` tinyint NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `xusers_username` (`username`(16)),
  KEY `xusers_name` (`name`(16)),
  KEY `xusers_lastname` (`lastname`(16)),
  KEY `xusers_email` (`email`(48)),
  KEY `xusers_created` (`created`),
  KEY `xusers_languageid` (`languageid`),
  KEY `xusers_verifiedid` (`verifiedid`),
  KEY `xusers_memberedid` (`memberedid`),
  CONSTRAINT `fkusers_languageid` FOREIGN KEY (`languageid`) REFERENCES `Languages` (`id`),
  CONSTRAINT `fkusers_memberedid` FOREIGN KEY (`memberedid`) REFERENCES `Membership` (`membered`),
  CONSTRAINT `fkusers_verifiedid` FOREIGN KEY (`verifiedid`) REFERENCES `Verify` (`verified`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (8,'main','test firstname','test lastname','email@main.server.com','test password non hashed',1,2,3,'2024-03-13 15:49:21'),(9,'test',NULL,NULL,'test@main.server.com','$2y$10$NLMoB1dmcTiyJInpHSVaeOYD21R7.NANhAY97d.AI0JRyomid1IvC',0,1,0,'2024-03-25 14:59:32');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_new_users` AFTER INSERT ON `Users` FOR EACH ROW BEGIN
INSERT INTO UsersStored(uid, username, email, password, memberedid, languageid, verifiedid, processtype)
VALUES(NEW.id, NEW.username, NEW.email, NEW.password, NEW.memberedid, NEW.languageid, NEW.verifiedid, 'New');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_update_users` BEFORE UPDATE ON `Users` FOR EACH ROW BEGIN
IF OLD.id != NEW.id OR OLD.username != NEW.username OR OLD.email != NEW.email OR OLD.password != NEW.password OR OLD.memberedid != NEW.memberedid OR OLD.languageid != NEW.languageid OR OLD.verifiedid != NEW.verifiedid THEN
INSERT INTO UsersStored(uid, username, email, password, memberedid, languageid, verifiedid, processtype)
VALUES(OLD.id, OLD.username, OLD.email, OLD.password, OLD.memberedid, OLD.languageid, OLD.verifiedid, 'Update');
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_delete_users` AFTER DELETE ON `Users` FOR EACH ROW BEGIN
INSERT INTO UsersStored(uid, username, email, password, memberedid, languageid, verifiedid, processtype)
VALUES(OLD.id, OLD.username, OLD.email, OLD.password, OLD.memberedid, OLD.languageid, OLD.verifiedid, 'Delete');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `UsersLog`
--

DROP TABLE IF EXISTS `UsersLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UsersLog` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `country` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `isp` varchar(255) DEFAULT NULL,
  `login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `xuserslog_uid` (`uid`),
  KEY `xuserslog_country` (`country`(16)),
  KEY `xuserslog_city` (`city`(16)),
  KEY `xuserslog_browser` (`browser`(32)),
  KEY `xuserslog_ip` (`ip`(15)),
  KEY `xuserslog_isp` (`isp`(32)),
  KEY `xuserslog_login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsersLog`
--

LOCK TABLES `UsersLog` WRITE;
/*!40000 ALTER TABLE `UsersLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `UsersLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UsersStored`
--

DROP TABLE IF EXISTS `UsersStored`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UsersStored` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `memberedid` tinyint NOT NULL,
  `languageid` tinyint unsigned NOT NULL,
  `verifiedid` tinyint NOT NULL,
  `storedtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processtype` enum('New','Update','Delete') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `xusersstored_uid` (`uid`),
  KEY `xusersstored_username` (`username`(16)),
  KEY `xusersstored_email` (`email`(48)),
  KEY `xusersstored_languageid` (`languageid`),
  KEY `xusersstored_storedtime` (`storedtime`),
  KEY `xusersstored_memberedid` (`memberedid`),
  KEY `xusersstored_verifiedid` (`verifiedid`),
  KEY `xusersstored_processtype` (`processtype`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsersStored`
--

LOCK TABLES `UsersStored` WRITE;
/*!40000 ALTER TABLE `UsersStored` DISABLE KEYS */;
INSERT INTO `UsersStored` VALUES (1,7,'test','test@email.com','password',0,1,0,'2024-03-13 15:22:26','New'),(2,8,'main','email@main.server.com','test password non hashed',1,2,1,'2024-03-13 15:49:21','New'),(3,7,'test','test@email.com','password',0,1,0,'2024-03-13 15:53:33','Delete'),(6,8,'main','email@main.server.com','test password non hashed',1,2,2,'2024-03-13 16:05:26','Update'),(7,9,'test','test@main.server.com','$2y$10$NLMoB1dmcTiyJInpHSVaeOYD21R7.NANhAY97d.AI0JRyomid1IvC',0,1,0,'2024-03-25 14:59:32','New'),(8,9,'test','test@main.server.com','$2y$10$NLMoB1dmcTiyJInpHSVaeOYD21R7.NANhAY97d.AI0JRyomid1IvC',0,1,0,'2024-03-27 19:52:28','Update'),(9,9,'test1','test@main.server.com','$2y$10$NLMoB1dmcTiyJInpHSVaeOYD21R7.NANhAY97d.AI0JRyomid1IvC',0,1,0,'2024-03-27 19:55:11','Update'),(10,9,'test','test@main.server.com','$2y$10$NLMoB1dmcTiyJInpHSVaeOYD21R7.NANhAY97d.AI0JRyomid1IvC',0,1,0,'2024-03-27 20:21:24','Update'),(11,9,'test2','test@main.server.com','$2y$10$NLMoB1dmcTiyJInpHSVaeOYD21R7.NANhAY97d.AI0JRyomid1IvC',0,1,0,'2024-03-27 20:22:09','Update');
/*!40000 ALTER TABLE `UsersStored` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Verify`
--

DROP TABLE IF EXISTS `Verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Verify` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `verified` tinyint NOT NULL,
  `definition` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `verified` (`verified`),
  KEY `xverify_verified` (`verified`),
  KEY `xverify_definition` (`definition`(16))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Verify`
--

LOCK TABLES `Verify` WRITE;
/*!40000 ALTER TABLE `Verify` DISABLE KEYS */;
INSERT INTO `Verify` VALUES (1,0,'None'),(2,1,'Email'),(3,2,'Two Factor'),(4,3,'Fingerprint'),(5,-1,'Timeout'),(6,-2,'Temporary Ban'),(7,-3,'Permanent Ban');
/*!40000 ALTER TABLE `Verify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'MainDB'
--
/*!50003 DROP PROCEDURE IF EXISTS `ProcGetByUsername_v1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcGetByUsername_v1`(IN username varchar(32), IN password varchar(255))
BEGIN SET @param_username = username; SET @param_password = password; SET @sql = CONCAT("SELECT *, Languages.short, Membership.definition, Verify.definiton FROM Users INNER JOIN Languages ON Users.languageid = Languages.id INNER JOIN Membership ON Users.memberedid = Membership.membered INNER JOIN Verify ON Users.verifiedid = Verify.verified WHERE username = \"", @param_username, "\" ORDER BY username ASC LIMIT 1 OFFSET 0"); IF username IS NULL OR password != "verify" THEN SET @sql = CONCAT("SELECT * FROM Users WHERE 0"); END IF; PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt; END ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ProcGetUser_v1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcGetUser_v1`(IN id INT UNSIGNED, IN username VARCHAR(32), IN email VARCHAR(255), IN password VARCHAR(255), IN membership ENUM('0','1','2','3'), IN language TINYINT UNSIGNED, IN verified ENUM('-3','-2','-1','0','1','2','3'))
BEGIN

SET @param_id = id;
SET @param_username = username;
SET @param_email = email;
SET @param_password = password;
SET @param_membership = membership;
SET @param_language = language;
SET @param_verified = verified;
SET @sql = CONCAT("SELECT * FROM Users WHERE 1 ");

IF id > 0 AND username IS NOT NULL THEN SET @sql = CONCAT(@sql, " AND id = \"", @param_id, "\" AND username = \"", @param_username, "\"");
ELSEIF id > 0 THEN SET @sql = CONCAT(@sql, " AND id = \"", @param_id, "\"");
ELSEIF username IS NOT NULL THEN SET @sql = CONCAT(@sql, " AND username = \"", @param_username, "\"");
END IF;

IF email IS NOT NULL THEN SET @sql = CONCAT(@sql, " AND email = \"", @param_email, "\"");
END IF;

IF password IS NOT NULL THEN SET @sql = CONCAT(@sql, " AND password = \"", @param_password, "\"");
END IF;

IF membership IS NOT NULL THEN SET @sql = CONCAT(@sql, " AND membership = \"", @param_membership, "\"");
END IF;

IF language > 0 THEN SET @sql = CONCAT(@sql, " AND language = \"", @param_language, "\"");
END IF;

IF verified IS NOT NULL THEN SET @sql = CONCAT(@sql, " AND verified = \"", @param_verified, "\"");
END IF;

IF (((id < 1 OR id IS NULL) AND username IS NULL) OR (email IS NULL)) THEN SET @sql = CONCAT("SELECT * FROM Users WHERE 0");
ELSE SET @sql = CONCAT(@sql, " ORDER BY id ASC, username ASC, email ASC, membership DESC, verified DESC LIMIT 1 OFFSET 0");
END IF;

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-28  3:44:40
