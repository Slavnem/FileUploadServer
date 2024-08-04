-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: MainMicroServiceApiAuth
-- ------------------------------------------------------
-- Server version	8.0.39

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
  `languagesId` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `languagesValue` varchar(32) NOT NULL,
  `languagesName` varchar(32) NOT NULL,
  PRIMARY KEY (`languagesId`),
  UNIQUE KEY `ulanguages_short` (`languagesValue`),
  UNIQUE KEY `languagesShort` (`languagesValue`),
  UNIQUE KEY `languagesValue` (`languagesValue`),
  KEY `xlanguages_short` (`languagesValue`(4)),
  KEY `xlanguages_name` (`languagesName`(16)),
  KEY `xlanguages_id` (`languagesId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Languages`
--

LOCK TABLES `Languages` WRITE;
/*!40000 ALTER TABLE `Languages` DISABLE KEYS */;
INSERT INTO `Languages` VALUES (1,'en','English'),(2,'tr','Türkçe'),(3,'ru','Русский'),(4,'uk','English');
/*!40000 ALTER TABLE `Languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Membership`
--

DROP TABLE IF EXISTS `Membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Membership` (
  `membershipId` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `membershipValue` varchar(32) NOT NULL,
  `membershipName` varchar(32) NOT NULL,
  PRIMARY KEY (`membershipId`),
  UNIQUE KEY `umembership_membername` (`membershipName`),
  UNIQUE KEY `membershipValue` (`membershipValue`),
  KEY `xmembership_id` (`membershipId`),
  KEY `xmembership_name` (`membershipName`(16))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Membership`
--

LOCK TABLES `Membership` WRITE;
/*!40000 ALTER TABLE `Membership` DISABLE KEYS */;
INSERT INTO `Membership` VALUES (1,'none','None'),(2,'bronze','Bronze'),(3,'silver','Silver'),(4,'gold','Gold'),(5,'admin','Admin'),(6,'moderator','Moderator');
/*!40000 ALTER TABLE `Membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Themes`
--

DROP TABLE IF EXISTS `Themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Themes` (
  `themesId` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `themesName` varchar(32) NOT NULL,
  `themesValue` varchar(32) NOT NULL,
  PRIMARY KEY (`themesId`),
  UNIQUE KEY `themeName` (`themesName`),
  UNIQUE KEY `themeValue` (`themesValue`),
  KEY `xthemes_id` (`themesId`),
  KEY `xthemes_name` (`themesName`(16)),
  KEY `xthemes_value` (`themesValue`(16))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Themes`
--

LOCK TABLES `Themes` WRITE;
/*!40000 ALTER TABLE `Themes` DISABLE KEYS */;
INSERT INTO `Themes` VALUES (1,'Auto','auto'),(2,'Dark','dark'),(3,'Light','light');
/*!40000 ALTER TABLE `Themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `usersId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usersUsername` varchar(64) NOT NULL,
  `usersFirstname` varchar(32) DEFAULT NULL,
  `usersLastname` varchar(32) DEFAULT NULL,
  `usersEmail` varchar(256) NOT NULL,
  `usersPassword` varchar(128) NOT NULL,
  `usersMemberid` tinyint unsigned NOT NULL DEFAULT '1',
  `usersLanguageid` tinyint unsigned NOT NULL DEFAULT '1',
  `usersVerifyid` tinyint unsigned NOT NULL DEFAULT '1',
  `usersThemeid` tinyint unsigned NOT NULL DEFAULT '1',
  `usersCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usersId`),
  UNIQUE KEY `uusers_username` (`usersUsername`),
  UNIQUE KEY `uusers_email` (`usersEmail`),
  KEY `xusers_username` (`usersUsername`(16)),
  KEY `xusers_lastname` (`usersLastname`(16)),
  KEY `xusers_email` (`usersEmail`(48)),
  KEY `xusers_created` (`usersCreated`),
  KEY `xusers_languageid` (`usersLanguageid`),
  KEY `xusers_verifyid` (`usersVerifyid`),
  KEY `xusers_memberid` (`usersMemberid`),
  KEY `xusers_id` (`usersId`),
  KEY `xusers_themeid` (`usersThemeid`),
  KEY `xusers_firstname` (`usersFirstname`(16)),
  CONSTRAINT `fkusers_languageid` FOREIGN KEY (`usersLanguageid`) REFERENCES `Languages` (`languagesId`),
  CONSTRAINT `fkusers_memberid` FOREIGN KEY (`usersMemberid`) REFERENCES `Membership` (`membershipId`),
  CONSTRAINT `fkusers_themeid` FOREIGN KEY (`usersThemeid`) REFERENCES `Themes` (`themesId`),
  CONSTRAINT `fkusers_verifyid` FOREIGN KEY (`usersVerifyid`) REFERENCES `Verify` (`verifyId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (2,'admin','Administrator','Api User','admin@email.main.api.user.com','C7AD44CBAD762A5DA0A452F9E854FDC1E0E7A52A38015F23F3EAB1D80B931DD472634DFAC71CD34EBC35D16AB7FB8A90C81F975113D6C7538DC69DD8DE9077EC',5,2,2,2,'2024-06-01 02:53:16'),(7,'test','test firstname',NULL,'test@email.main.api.user.com','EE26B0DD4AF7E749AA1A8EE3C10AE9923F618980772E473F8819A5D4940E0DB27AC185F8A0E1D5F84F88BC887FD67B143732C304CC5FA9AD8E6F57F50028A8FF',1,1,1,1,'2024-06-01 13:34:08'),(8,'blabla','newv2','lastvv','blabla@main.api.user.com','D1C2E12CFEABABC8B95DAF6902E210B170992E68FD1C1F19565A40CF0099C6E2CB559B85D7C14EA05B4DCA0A790656D003CCADE9286827CFFDF8E664FD271499',1,1,1,1,'2024-06-15 23:27:15'),(10,'Debugger',NULL,NULL,'debugger@email.main.api.user.com','E1C1D2B23C2F9E53DBFD27756118F8AFC16648AE9933FF4AA70DB1C18CAEA36258182F7081FC241ADED6C39DE2809DB6BB5BA3541E8C5694BFEA1785BFE262E4',1,1,1,1,'2024-06-25 00:02:10'),(11,'tester','tester name','','tester@email.main.api.user.com','58A3CE9F294F2388E9CFCAB88F3AA7E5D3AC53DCAB5C8E82A9DCC88FE08EF63048428C867A43B31ABED7AB50906ED879CF2FA0DFB725740C92D4EF5E06CE957E',1,1,1,1,'2024-06-25 00:15:04');
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_users_create` AFTER INSERT ON `Users` FOR EACH ROW BEGIN INSERT INTO UsersBackup(usersbackupUserid, usersbackupUsername, usersbackupEmail, usersbackupMemberid, usersbackupLanguageid, usersbackupVerifyid, usersbackupThemeid, usersbackupProcess) VALUES(NEW.usersId, NEW.usersUsername, NEW.usersEmail, NEW.usersMemberid, NEW.usersLanguageid, NEW.usersVerifyid, NEW.usersThemeid, 'New'); END */;;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_users_update` BEFORE UPDATE ON `Users` FOR EACH ROW BEGIN INSERT INTO UsersBackup(usersbackupUserid, usersbackupUsername, usersbackupEmail, usersbackupMemberid, usersbackupLanguageid, usersbackupVerifyid, usersbackupThemeid, usersbackupProcess)
VALUES(OLD.usersId, OLD.usersUsername, OLD.usersEmail, OLD.usersMemberid, OLD.usersLanguageid, OLD.usersVerifyid, OLD.usersThemeid, 'Update'); END */;;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_users_delete` BEFORE DELETE ON `Users` FOR EACH ROW BEGIN INSERT INTO UsersBackup(usersbackupUserid, usersbackupUsername, usersbackupEmail, usersbackupMemberid, usersbackupLanguageid, usersbackupVerifyid, usersbackupThemeid, usersbackupProcess)
VALUES(OLD.usersId, OLD.usersUsername, OLD.usersEmail, OLD.usersMemberid, OLD.usersLanguageid, OLD.usersVerifyid, OLD.usersThemeid, 'Delete'); END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `UsersBackup`
--

DROP TABLE IF EXISTS `UsersBackup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UsersBackup` (
  `usersbackupId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usersbackupUserid` bigint unsigned NOT NULL,
  `usersbackupUsername` varchar(64) DEFAULT NULL,
  `usersbackupFirstname` varchar(32) DEFAULT NULL,
  `usersbackupLastname` varchar(32) DEFAULT NULL,
  `usersbackupEmail` varchar(256) DEFAULT NULL,
  `usersbackupPassword` varchar(128) DEFAULT NULL,
  `usersbackupMemberid` tinyint unsigned DEFAULT NULL,
  `usersbackupLanguageid` tinyint unsigned DEFAULT NULL,
  `usersbackupVerifyid` tinyint unsigned DEFAULT NULL,
  `usersbackupThemeid` tinyint unsigned DEFAULT NULL,
  `usersbackupProcess` varchar(32) DEFAULT NULL,
  `usersbackupCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usersbackupId`),
  KEY `xusersbackup_userid` (`usersbackupUserid`),
  KEY `xusersbackup_username` (`usersbackupUsername`(32)),
  KEY `xusersbackup_email` (`usersbackupEmail`(64)),
  KEY `xusersbackup_memberid` (`usersbackupMemberid`),
  KEY `xusersbackup_languageid` (`usersbackupLanguageid`),
  KEY `xusersbackup_verifyid` (`usersbackupVerifyid`),
  KEY `xusersbackup_themeid` (`usersbackupThemeid`),
  KEY `xusersbackup_process` (`usersbackupProcess`(16)),
  KEY `xusersbackup_created` (`usersbackupCreated`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsersBackup`
--

LOCK TABLES `UsersBackup` WRITE;
/*!40000 ALTER TABLE `UsersBackup` DISABLE KEYS */;
INSERT INTO `UsersBackup` VALUES (1,13,'tester3',NULL,NULL,'tester3.new@email.main.api.user.com',NULL,1,1,1,1,'Update','2024-07-17 12:49:48'),(2,13,'tester3',NULL,NULL,'tester3.new@email.main.api.user.com',NULL,1,1,1,1,'Update','2024-07-17 12:50:25'),(3,13,'tester3',NULL,NULL,'tester3.new@email.main.api.user.com',NULL,1,1,1,1,'Update','2024-07-17 12:53:01'),(4,13,'tester3',NULL,NULL,'tester3.new@email.main.api.user.com',NULL,1,1,1,1,'Delete','2024-07-17 12:54:22'),(5,15,'tester4',NULL,NULL,'tester4@email.main.api.user.com',NULL,1,1,1,1,'New','2024-07-17 12:55:29'),(6,15,'tester4',NULL,NULL,'tester4@email.main.api.user.com',NULL,1,1,1,1,'Update','2024-07-17 12:59:10'),(7,15,'tester4',NULL,NULL,'tester4@email.main.api.user.com',NULL,1,1,1,1,'Update','2024-07-17 13:00:02'),(8,15,'tester4',NULL,NULL,'tester4@email.main.api.user.com',NULL,1,1,1,1,'Delete','2024-07-17 13:01:47'),(9,9,'Blow',NULL,NULL,'blow@email.main.api.user.com',NULL,1,2,1,3,'Delete','2024-07-17 13:03:51');
/*!40000 ALTER TABLE `UsersBackup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UsersLog`
--

DROP TABLE IF EXISTS `UsersLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UsersLog` (
  `userslogId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userslogUserid` bigint unsigned NOT NULL,
  `userslogCountry` varchar(32) DEFAULT NULL,
  `userslogCity` varchar(32) DEFAULT NULL,
  `userslogBrowser` varchar(256) DEFAULT NULL,
  `userslogIpv4` varchar(32) DEFAULT NULL,
  `userslogIsp` varchar(256) DEFAULT NULL,
  `userslogCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userslogId`),
  KEY `xuserslog_country` (`userslogCountry`(16)),
  KEY `xuserslog_city` (`userslogCity`(16)),
  KEY `xuserslog_browser` (`userslogBrowser`(32)),
  KEY `xuserslog_isp` (`userslogIsp`(32)),
  KEY `xuserslog_userid` (`userslogUserid`),
  KEY `xuserslog_created` (`userslogCreated`),
  KEY `xuserslog_ipv4` (`userslogIpv4`(16))
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
-- Table structure for table `Verify`
--

DROP TABLE IF EXISTS `Verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Verify` (
  `verifyId` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `verifyValue` varchar(32) NOT NULL,
  `verifyName` varchar(32) NOT NULL,
  PRIMARY KEY (`verifyId`),
  UNIQUE KEY `verifyName` (`verifyName`),
  UNIQUE KEY `verifyValue` (`verifyValue`),
  KEY `xverify_id` (`verifyId`),
  KEY `xverify_name` (`verifyName`(16))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Verify`
--

LOCK TABLES `Verify` WRITE;
/*!40000 ALTER TABLE `Verify` DISABLE KEYS */;
INSERT INTO `Verify` VALUES (1,'none','None'),(2,'email','Email'),(3,'two factor','Two Factor'),(4,'fingerprint','Fingerprint'),(5,'timeout','Timeout'),(6,'temporary ban','Temporary Ban'),(7,'permanent ban','Permanent Ban');
/*!40000 ALTER TABLE `Verify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'MainMicroServiceApiAuth'
--
/*!50003 DROP PROCEDURE IF EXISTS `ProcCreateUser_v1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcCreateUser_v1`(
    IN argUsername VARCHAR(64),
    IN argFirstname VARCHAR(32),
    IN argLastname VARCHAR(32),
    IN argEmail VARCHAR(256),
    IN argPassword VARCHAR(128),
    IN argLanguage VARCHAR(32),
    IN argTheme VARCHAR(32)
)
CreateUser: 
BEGIN
    DECLARE language_id INT DEFAULT 1;
    DECLARE theme_id INT DEFAULT 1;

    DECLARE arg_encrypted_password VARCHAR(128);
    
    IF (argUsername IS NULL OR argEmail IS NULL) OR (argPassword IS NULL) THEN
        SELECT 'Kullanıcı Adı, E-posta Adresi veya Şifre Boş Olamaz!' AS message;
        LEAVE CreateUser;
    END IF;
    
    SET arg_encrypted_password = SHA2(argPassword, 512);
    
    SELECT COUNT(*) INTO @count_username FROM Users WHERE (usersUsername = argUsername);
    IF @count_username > 0 THEN
        SELECT 'Kullanıcı Adı Zaten Kullanılıyor...' AS message;
        LEAVE CreateUser;
    END IF;
    
    SELECT COUNT(*) INTO @count_email FROM Users WHERE (usersEmail = argEmail);
    IF @count_email > 0 THEN
        SELECT 'E-posta Adresi Zaten Kullanılıyor...' AS message;
        LEAVE CreateUser;
    END IF;
    
    IF argLanguage IS NOT NULL THEN
        SELECT languagesId INTO language_id FROM Languages WHERE (languagesValue = argLanguage) LIMIT 1;
        SET language_id = IFNULL(language_id, 1);
    END IF;
    
    IF argTheme IS NOT NULL THEN
        SELECT themesId INTO theme_id FROM Themes WHERE (themesValue = argTheme) LIMIT 1;
        SET theme_id = IFNULL(theme_id, 1);
    END IF;
    
    INSERT INTO Users(
        usersUsername, usersFirstname, usersLastname,
        usersEmail, usersPassword, usersLanguageid, usersThemeid
    ) VALUES (
        argUsername, argFirstname, argLastname,
        argEmail, arg_encrypted_password, language_id, theme_id
    );
    
    IF ROW_COUNT() > 0 THEN
        SELECT 'Kullanıcı Başarıyla Oluşturuldu :)' AS result;
    ELSE
        SELECT 'Kullanıcı Oluşturulamadı :(' AS result;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ProcDeleteUser_v1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcDeleteUser_v1`(
    IN argUsername VARCHAR(64),
    IN argEmail VARCHAR(256),
    IN argPassword VARCHAR(128)
)
DeleteUser:
BEGIN
    DECLARE storedPassword VARCHAR(128);
    DECLARE arg_encrypted_password VARCHAR(128);
    
    IF (argUsername IS NULL AND argEmail IS NULL) OR (argPassword IS NULL) THEN
        SELECT 'Kullanıcı Adı ve E-posta Adresi veya Şifre Boş Olamaz!' AS message;
        LEAVE DeleteUser;
    END IF;
    
    SET arg_encrypted_password = SHA2(argPassword, 512);
    
    SELECT usersPassword INTO storedPassword FROM Users WHERE (usersUsername = argUsername OR usersEmail = argEmail) LIMIT 1;
    
    IF storedPassword IS NULL THEN
        SELECT 'Kullanıcıya Ait Bilgiler Bulunamadı...' AS message;
        LEAVE DeleteUser;
    END IF;
    
    IF (arg_encrypted_password != storedPassword AND argPassword != storedPassword) THEN
        SELECT 'Girilen Şifre İle Veritabanındaki Şifre Uyuşmuyor...' AS message;
        LEAVE DeleteUser;
    END IF;
    
    DELETE FROM Users
    WHERE (argUsername != '' OR argEmail != '')
    AND (usersUsername = argUsername OR usersEmail = argEmail)
    AND argPassword != ''
    AND (usersPassword = arg_encrypted_password OR usersPassword = argPassword)
    LIMIT 1;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 'Kullanıcı Başarıyla Silindi :)' AS result;
    ELSE
        SELECT 'Kullanıcı Silinemedi :(' AS result;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ProcFetchUser_v1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcFetchUser_v1`(
    IN argUsername VARCHAR(64),
    IN argEmail VARCHAR(256),
    IN argPassword VARCHAR(128)
)
FetchUser:
BEGIN
    DECLARE arg_encrypted_password VARCHAR(128);
    
    IF (argUsername IS NULL AND argEmail IS NULL) OR (argPassword IS NULL) THEN
        SELECT 'Kullanıcı Adı ve E-posta Adresi veya Şifre Boş Olamaz!' AS message;
        LEAVE FetchUser;
    END IF;
    
    SET arg_encrypted_password = SHA2(argPassword, 512);
    
    SELECT *
    FROM Users
    INNER JOIN Membership ON Users.usersMemberid = Membership.membershipId
    INNER JOIN Languages ON Users.usersLanguageid = Languages.languagesId
    INNER JOIN Verify ON Users.usersVerifyid = Verify.verifyId
    INNER JOIN Themes ON Users.usersThemeid = Themes.themesId
    WHERE (argUsername != '' OR argEmail != '')
    AND (usersUsername = argUsername OR usersEmail = argEmail)
    AND argPassword != ''
    AND (usersPassword = arg_encrypted_password OR usersPassword = argPassword)
    LIMIT 1 OFFSET 0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ProcUpdateUser_v1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ProcUpdateUser_v1`(
    IN argStoredUsername VARCHAR(64),
    IN argStoredEmail VARCHAR(256),
    IN argStoredPassword VARCHAR(128),
    IN argUsername VARCHAR(64),
    IN argFirstname VARCHAR(32),
    IN argLastname VARCHAR(32),
    IN argEmail VARCHAR(256),
    IN argPassword VARCHAR(128),
    IN argMembership VARCHAR(32),
    IN argLanguage VARCHAR(32),
    IN argVerify VARCHAR(32),
    IN argTheme VARCHAR(32)
)
UpdateUser: 
BEGIN
    DECLARE old_firstname VARCHAR(32);
    DECLARE old_lastname VARCHAR(32);
    
    DECLARE membership_id INT DEFAULT 1;
    DECLARE language_id INT DEFAULT 1;
    DECLARE verify_id INT DEFAULT 1;
    DECLARE theme_id INT DEFAULT 1;
    
    DECLARE arg_stored_encrypted_password VARCHAR(128);
    DECLARE arg_new_encrypted_password VARCHAR(128);
    
    IF (argStoredUsername IS NULL AND argStoredEmail IS NULL) OR (argStoredPassword IS NULL) THEN
        SELECT 'Doğrulama İçin Kullanıcı Adı ve E-posta Adresi veya Şifre Boş Olamaz!' AS message;
        LEAVE UpdateUser;
    END IF;
    
    SELECT COUNT(*) INTO @count_user FROM Users
    WHERE (argStoredUsername != '' OR argStoredEmail != '')
    AND (usersUsername = argStoredUsername OR usersEmail = argStoredEmail);
    
    IF @count_user < 1 OR @count_user IS NULL THEN
        SELECT 'Kullanıcı Bulunamadı...' AS message;
        LEAVE UpdateUser;
    END IF;
    
    SELECT usersFirstname, usersLastname, usersMemberid, usersLanguageid, usersVerifyid, usersThemeid
    INTO old_firstname, old_lastname, membership_id, language_id, verify_id, theme_id
    FROM Users
    WHERE (usersUsername = argStoredUsername OR usersEmail = argStoredEmail);
    
    SET argUsername = IFNULL(argUsername, argStoredUsername);
    SET argEmail = IFNULL(argEmail, argStoredEmail);
    SET argPassword = IFNULL(argPassword, argStoredPassword);
    SET argFirstname = IFNULL(argFirstname, old_firstname);
    SET argLastname = IFNULL(argLastname, old_lastname);
    
    SET arg_stored_encrypted_password = SHA2(argStoredPassword, 512);
    SET arg_new_encrypted_password = SHA2(argPassword, 512);
    
    IF argMembership IS NOT NULL THEN
        SELECT membershipId INTO membership_id FROM Membership WHERE membershipValue = argMembership LIMIT 1;
        SET membership_id = IFNULL(membership_id, 1);
    END IF;
    
    IF argLanguage IS NOT NULL THEN
        SELECT languagesId INTO language_id FROM Languages WHERE languagesValue = argLanguage LIMIT 1;
        SET language_id = IFNULL(language_id, 1);
    END IF;
    
    IF argVerify IS NOT NULL THEN
        SELECT verifyId INTO verify_id FROM Verify WHERE verifyValue = argVerify LIMIT 1;
        SET verify_id = IFNULL(verify_id, 1);
    END IF;
    
    IF argTheme IS NOT NULL THEN
        SELECT themesId INTO theme_id FROM Themes WHERE themesValue = argTheme LIMIT 1;
        SET theme_id = IFNULL(theme_id, 1);
    END IF;
    
    UPDATE Users SET usersUsername = argUsername,
    usersFirstname = argFirstname,
    usersLastname = argLastname,
    usersEmail = argEmail,
    usersPassword = arg_new_encrypted_password,
    usersMemberid = membership_id,
    usersLanguageid = language_id,
    usersVerifyid = verify_id,
    usersThemeid = theme_id
    WHERE (argStoredUsername != '' OR argStoredEmail != '')
    AND (usersUsername = argStoredUsername OR usersEmail = argStoredEmail)
    AND argStoredPassword != ''
    AND (usersPassword = arg_stored_encrypted_password OR usersPassword = argStoredPassword);
    
    IF ROW_COUNT() > 0 THEN
    SELECT 'Kullanıcı Bilgileri Başarıyla Güncellendi :)' AS result;
    ELSE
    SELECT 'Kullanıcı Bilgileri Güncellenemdi :(' AS result;
    END IF;
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

-- Dump completed on 2024-08-04 16:10:24
