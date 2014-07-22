CREATE DATABASE  IF NOT EXISTS `helpdesk` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `helpdesk`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: helpdesk
-- ------------------------------------------------------
-- Server version	5.5.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assign_engineers`
--

DROP TABLE IF EXISTS `assign_engineers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assign_engineers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engineerId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idengineers_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assign_engineers`
--

LOCK TABLES `assign_engineers` WRITE;
/*!40000 ALTER TABLE `assign_engineers` DISABLE KEYS */;
INSERT INTO `assign_engineers` VALUES (1,10);
/*!40000 ALTER TABLE `assign_engineers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calls`
--

DROP TABLE IF EXISTS `calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls` (
  `callid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `details` varchar(45) DEFAULT NULL,
  `assigned` int(11) DEFAULT NULL,
  `opened` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `closed` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `urgency` int(11) DEFAULT '2',
  PRIMARY KEY (`callid`),
  UNIQUE KEY `callid_UNIQUE` (`callid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calls`
--

LOCK TABLES `calls` WRITE;
/*!40000 ALTER TABLE `calls` DISABLE KEYS */;
INSERT INTO `calls` VALUES (1,'test','test','test','test',8,'2014-07-09 10:17:40',NULL,NULL,1,2),(2,'test2','test2','test2','tets2',10,'2014-07-09 10:17:55',NULL,NULL,1,2),(3,'new','new','new','new',8,'2014-07-09 10:20:31',NULL,NULL,2,2),(5,'opened time test','email','title','details',8,'2014-07-10 12:07:12',NULL,NULL,1,2);
/*!40000 ALTER TABLE `calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engineers`
--

DROP TABLE IF EXISTS `engineers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engineers` (
  `idengineers` int(11) NOT NULL AUTO_INCREMENT,
  `engineerName` varchar(45) NOT NULL,
  `engineerEmail` varchar(45) NOT NULL,
  `availableMon` tinyint(1) NOT NULL,
  `availableTue` tinyint(1) NOT NULL,
  `availableWed` tinyint(1) NOT NULL,
  `availableThu` tinyint(1) NOT NULL,
  `availableFri` tinyint(1) NOT NULL,
  `availableSat` tinyint(1) NOT NULL,
  `availableSun` tinyint(1) NOT NULL,
  PRIMARY KEY (`idengineers`),
  UNIQUE KEY `idengineers_UNIQUE` (`idengineers`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engineers`
--

LOCK TABLES `engineers` WRITE;
/*!40000 ALTER TABLE `engineers` DISABLE KEYS */;
INSERT INTO `engineers` VALUES (8,'honey drips','honey@drips.com',0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `engineers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idengineers_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Open'),(2,'Closed');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-22 11:07:12
