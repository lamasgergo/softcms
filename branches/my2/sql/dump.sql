-- MySQL dump 10.13  Distrib 5.1.50, for Win32 (ia32)
--
-- Host: localhost    Database: my2
-- ------------------------------------------------------
-- Server version	5.1.50-community

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
-- Table structure for table `bs_comments`
--

DROP TABLE IF EXISTS `bs_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_comments` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Item` varchar(100) NOT NULL DEFAULT '',
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  `Comment` text NOT NULL,
  `Approved` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `UserID` int(10) unsigned DEFAULT '0',
  `Created` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Item` (`Item`),
  KEY `fk_bs_comments_bs_data1` (`ItemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_comments`
--

LOCK TABLES `bs_comments` WRITE;
/*!40000 ALTER TABLE `bs_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_data`
--

DROP TABLE IF EXISTS `bs_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_data` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) NOT NULL DEFAULT 'article',
  `UserID` bigint(21) unsigned NOT NULL DEFAULT '0',
  `CategoryID` bigint(21) unsigned NOT NULL DEFAULT '0',
  `Lang` char(4) NOT NULL DEFAULT 'ru',
  `Title` varchar(255) NOT NULL DEFAULT '',
  `Content` text,
  `Teaser` text,
  `Published` enum('0','1') NOT NULL DEFAULT '0',
  `Modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MetaAlt` varchar(255) DEFAULT NULL,
  `MetaKeywords` varchar(255) DEFAULT NULL,
  `MetaTitle` varchar(255) DEFAULT NULL,
  `MetaDescription` varchar(255) DEFAULT NULL,
  `LoginRequired` tinyint(3) unsigned DEFAULT '0',
  `ViewCount` int(10) unsigned DEFAULT '0',
  `ImageGroupID` int(10) unsigned DEFAULT '0',
  `Url` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Url_UNIQUE` (`Url`),
  KEY `fk_bs_data_bs_data_categories` (`CategoryID`),
  KEY `fk_bs_data_bs_users1` (`UserID`),
  KEY `fk_bs_data_bs_images_group1` (`ImageGroupID`),
  FULLTEXT KEY `search` (`Title`,`Content`,`Teaser`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_data`
--

LOCK TABLES `bs_data` WRITE;
/*!40000 ALTER TABLE `bs_data` DISABLE KEYS */;
INSERT INTO `bs_data` VALUES (1,'article',16,6,'ru','test','123',NULL,'1','2010-05-27 11:38:09','test alt','test keywords','test title','test description',0,0,0,'test'),(2,'article',16,21237,'ru','хрень','123',NULL,'1','2010-09-16 15:17:04',NULL,NULL,NULL,NULL,0,0,0,'hren__'),(3,'article',16,21237,'ru','хрень какая-то :)','123 :)',NULL,'1','2010-09-16 15:18:53',':)',':)',':)',':)',0,0,0,'hren___kakayato_'),(4,'images',16,21240,'ru','test images','test images content',NULL,'1','2010-11-29 16:38:08',NULL,NULL,NULL,NULL,0,0,0,'test-images'),(5,'article',16,21237,'ru','new test article','Some content there',NULL,'1','2010-11-29 16:39:41',NULL,NULL,NULL,NULL,0,0,0,'new-test-article'),(6,'images',16,21240,'ru','new test images','try upload',NULL,'1','2010-12-01 12:48:26',NULL,NULL,NULL,NULL,0,0,0,'new-test-images');
/*!40000 ALTER TABLE `bs_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_data_categories`
--

DROP TABLE IF EXISTS `bs_data_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_data_categories` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(21) unsigned NOT NULL DEFAULT '0',
  `Type` varchar(255) NOT NULL DEFAULT 'article',
  `ParentID` bigint(21) unsigned DEFAULT '0',
  `Lang` char(4) NOT NULL DEFAULT 'ru',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Description` text,
  `Published` int(3) DEFAULT '0',
  `Modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LoginRequired` tinyint(3) unsigned DEFAULT '0',
  `Url` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_bs_data_categories_bs_users1` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=21241 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_data_categories`
--

LOCK TABLES `bs_data_categories` WRITE;
/*!40000 ALTER TABLE `bs_data_categories` DISABLE KEYS */;
INSERT INTO `bs_data_categories` VALUES (6,16,'article',0,'ru','zxcv',NULL,0,'2010-04-09 15:10:51',0,''),(7,16,'article',0,'ru','aasdfsa',NULL,0,'2010-04-09 15:13:02',0,''),(21235,16,'article',0,'ru','новости','23',0,'2010-04-22 07:52:47',0,'/novosti2'),(21232,16,'article',0,'ru','новости','123',0,'2010-04-22 07:46:17',0,'/novosti'),(21233,16,'article',21232,'ru','мировые',NULL,0,'2010-04-22 07:46:45',0,'/novosti/miroviie'),(21236,16,'article',0,'ru','xxxxx','test',0,'2010-09-16 15:16:18',0,'/xxxxx'),(21237,16,'article',0,'ru','проверка','ыавафы',0,'2010-09-16 15:16:30',0,'/proverka'),(21238,16,'article',0,'ru','change locale vars','change locale vars desc',1,'2010-09-18 12:29:53',0,'/change locale vars'),(21239,16,'article',0,'ru','ss_ss 444 + :)','ssss',0,'2010-09-18 12:57:29',0,'/ss_ss_444__'),(21240,16,'images',0,'ru','test image category','test',1,'2010-12-01 13:13:58',0,'test-image-category');
/*!40000 ALTER TABLE `bs_data_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_images`
--

DROP TABLE IF EXISTS `bs_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_images` (
  `idimages` int(11) NOT NULL AUTO_INCREMENT,
  `DataID` int(11) NOT NULL,
  `Src` varchar(255) NOT NULL,
  `Uploaded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idimages`),
  UNIQUE KEY `UQ_images` (`DataID`,`Src`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_images`
--

LOCK TABLES `bs_images` WRITE;
/*!40000 ALTER TABLE `bs_images` DISABLE KEYS */;
INSERT INTO `bs_images` VALUES (7,4,'/files/images/4/1865-200.jpg','2010-12-08 12:24:40'),(2,6,'/files/images/6/291-160.jpg','2010-12-06 16:26:21'),(6,6,'/files/images/6/766-160.jpg','2010-12-08 12:19:52');
/*!40000 ALTER TABLE `bs_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_lang`
--

DROP TABLE IF EXISTS `bs_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_lang` (
  `Name` varchar(255) NOT NULL,
  `Value` text NOT NULL,
  PRIMARY KEY (`Name`),
  UNIQUE KEY `name_unique` (`Name`),
  KEY `fk_bs_lang_bs_data1` (`Name`),
  KEY `fk_bs_lang_bs_data_categories1` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_lang`
--

LOCK TABLES `bs_lang` WRITE;
/*!40000 ALTER TABLE `bs_lang` DISABLE KEYS */;
INSERT INTO `bs_lang` VALUES ('ru','Russian'),('en','English');
/*!40000 ALTER TABLE `bs_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_menutree`
--

DROP TABLE IF EXISTS `bs_menutree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_menutree` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Link` varchar(255) NOT NULL DEFAULT '',
  `LinkAlias` varchar(255) DEFAULT NULL,
  `ParentID` int(10) unsigned NOT NULL DEFAULT '0',
  `OrderNum` int(10) unsigned NOT NULL DEFAULT '0',
  `External` enum('0','1') NOT NULL DEFAULT '0',
  `Created` datetime DEFAULT NULL,
  `Lang` char(4) NOT NULL DEFAULT 'ru',
  `Published` tinyint(3) unsigned DEFAULT '1',
  `Image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_bs_menutree_bs_lang1` (`Lang`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_menutree`
--

LOCK TABLES `bs_menutree` WRITE;
/*!40000 ALTER TABLE `bs_menutree` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_menutree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_modules`
--

DROP TABLE IF EXISTS `bs_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_modules` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `ModGroup` varchar(255) NOT NULL DEFAULT '',
  `Active` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `fk_bs_modules_bs_blocks1` (`Name`),
  KEY `fk_bs_modules_bs_modules_rights1` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_modules`
--

LOCK TABLES `bs_modules` WRITE;
/*!40000 ALTER TABLE `bs_modules` DISABLE KEYS */;
INSERT INTO `bs_modules` VALUES (24,'article','base',1),(25,'users','base',1),(26,'base','base',1),(27,'images','base',1);
/*!40000 ALTER TABLE `bs_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_modules_rights`
--

DROP TABLE IF EXISTS `bs_modules_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_modules_rights` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Module` varchar(255) NOT NULL,
  `UserID` bigint(21) unsigned DEFAULT NULL,
  `Group` varchar(255) DEFAULT NULL,
  `Action` varchar(255) NOT NULL,
  `Approved` tinyint(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_modules_rights`
--

LOCK TABLES `bs_modules_rights` WRITE;
/*!40000 ALTER TABLE `bs_modules_rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_modules_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_sessions2`
--

DROP TABLE IF EXISTS `bs_sessions2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_sessions2` (
  `sesskey` varchar(64) NOT NULL DEFAULT '',
  `expiry` datetime NOT NULL,
  `expireref` varchar(250) DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sessdata` longtext,
  PRIMARY KEY (`sesskey`),
  KEY `sess2_expiry` (`expiry`),
  KEY `sess2_expireref` (`expireref`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_sessions2`
--

LOCK TABLES `bs_sessions2` WRITE;
/*!40000 ALTER TABLE `bs_sessions2` DISABLE KEYS */;
INSERT INTO `bs_sessions2` VALUES ('0usb7imgl2e8mtcisd72la96e3','2010-12-06 18:58:51','','2010-12-03 10:49:21','2010-12-06 18:34:51','my_id%7Cs%3A2%3A%2216%22%3B'),('di6ogfp9bj9ji24iemclrr8mm4','2010-12-08 16:03:55','','2010-12-08 14:19:12','2010-12-08 15:39:55','my_id%7Cs%3A2%3A%2216%22%3B');
/*!40000 ALTER TABLE `bs_sessions2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_settings`
--

DROP TABLE IF EXISTS `bs_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_settings` (
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Value` text NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_settings`
--

LOCK TABLES `bs_settings` WRITE;
/*!40000 ALTER TABLE `bs_settings` DISABLE KEYS */;
INSERT INTO `bs_settings` VALUES ('smarty_templates_dir','/design','templates: design dir'),('smarty_compiled_dir','/templates_c','templates: compile dir'),('smarty_plugins_dir','/plugins','templates: user plugins dir'),('smarty_caching','0','templates: use caching'),('default_lang','ru','default language'),('session_prefix','BS_','session prefix'),('upload_directory','/files','directory for uploading files'),('upload_tmp_directory','/files/tmp','temporary directory'),('navigation_perPage','2','show items per page'),('modules_varname','mod','_GET variable that define module name'),('theme','','current theme'),('meta_title','Test site','Default page title'),('meta_description','Test description','Default page description'),('meta_keywords','test, site, keywords','Default page keywords'),('meta_alt','test alt','Default page alt'),('rewrite_urls','true','Use user friendly links (mod_rewrite)');
/*!40000 ALTER TABLE `bs_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_users`
--

DROP TABLE IF EXISTS `bs_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_users` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Login` varchar(255) NOT NULL DEFAULT '',
  `Password` varchar(255) NOT NULL DEFAULT '',
  `Lang` char(4) NOT NULL DEFAULT 'ru',
  `Group` varchar(255) NOT NULL DEFAULT 'users',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Published` enum('0','1') NOT NULL DEFAULT '0',
  `EditLang` char(4) NOT NULL DEFAULT 'ru',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uniq` (`Login`),
  KEY `fk_bs_users_bs_comments1` (`ID`),
  KEY `fk_bs_users_bs_users_data1` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_users`
--

LOCK TABLES `bs_users` WRITE;
/*!40000 ALTER TABLE `bs_users` DISABLE KEYS */;
INSERT INTO `bs_users` VALUES (15,'admin','1$/JsQ4Mkd7N2','ru','administrators','admin','a.diesel@gmail.com','1','ru'),(16,'admin2','1$8VJ9etjPUEY','ru','administrators','admin2','a.diesel@gmail.com','1','ru');
/*!40000 ALTER TABLE `bs_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_users_data`
--

DROP TABLE IF EXISTS `bs_users_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_users_data` (
  `ID` int(11) NOT NULL,
  `Familyname` varchar(255) DEFAULT NULL,
  `Patronymic` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Address` text,
  `Address2` text,
  `ZIP` varchar(45) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Cellphone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_users_data`
--

LOCK TABLES `bs_users_data` WRITE;
/*!40000 ALTER TABLE `bs_users_data` DISABLE KEYS */;
INSERT INTO `bs_users_data` VALUES (16,'test familyname','what is this?','UA','Simf','zzzz','zzzz2','0000','000-00-000-0','0-00-0-0-0-0-0');
/*!40000 ALTER TABLE `bs_users_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_users_groups`
--

DROP TABLE IF EXISTS `bs_users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_users_groups` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uniq` (`Name`),
  KEY `fk_bs_groups_bs_users1` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_users_groups`
--

LOCK TABLES `bs_users_groups` WRITE;
/*!40000 ALTER TABLE `bs_users_groups` DISABLE KEYS */;
INSERT INTO `bs_users_groups` VALUES (1,'administarators'),(2,'users');
/*!40000 ALTER TABLE `bs_users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_vocabulary`
--

DROP TABLE IF EXISTS `bs_vocabulary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_vocabulary` (
  `idvocabulary` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Key` varchar(255) DEFAULT NULL,
  `Context` varchar(50) DEFAULT NULL,
  `Value` text,
  `Lang` char(4) DEFAULT 'en',
  PRIMARY KEY (`idvocabulary`),
  UNIQUE KEY `key` (`Key`,`Context`)
) ENGINE=MyISAM AUTO_INCREMENT=231 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_vocabulary`
--

LOCK TABLES `bs_vocabulary` WRITE;
/*!40000 ALTER TABLE `bs_vocabulary` DISABLE KEYS */;
INSERT INTO `bs_vocabulary` VALUES (1,'Autorization','LOGIN','Autorization',''),(2,'Login','LOGIN','Login',''),(3,'Password','LOGIN','Password',''),(4,'Log in','LOGIN','Log in',''),(5,'Administration area','','Administration area',''),(6,'content','ADMIN_MENU','content','ru'),(7,'users','ADMIN_MENU','users','ru'),(8,'base','ADMIN_MENU','base','ru'),(9,'Logout','','Logout','ru'),(10,'ID','basecategories','ID','ru'),(11,'UserID','basecategories','UserID','ru'),(12,'Type','basecategories','Type','ru'),(13,'ParentID','basecategories','ParentID','ru'),(14,'Lang','basecategories','Lang','ru'),(15,'Name','basecategories','Name','ru'),(16,'Description','basecategories','Description','ru'),(17,'Published','basecategories','Published','ru'),(18,'LoginRequired','basecategories','LoginRequired','ru'),(19,'Url','basecategories','Url','ru'),(20,'ID','baseitems','ID','ru'),(21,'Type','baseitems','Type','ru'),(22,'UserID','baseitems','UserID','ru'),(23,'CategoryID','baseitems','CategoryID','ru'),(24,'Lang','baseitems','Lang','ru'),(25,'Title','baseitems','Title','ru'),(26,'Published','baseitems','Published','ru'),(27,'LoginRequired','baseitems','LoginRequired','ru'),(28,'ViewCount','baseitems','ViewCount','ru'),(29,'Url','baseitems','Url','ru'),(30,'basecategories','base','basecategories','ru'),(31,'baseitems','base','baseitems','ru'),(32,'basecategories','ADMIN_MENU','basecategories','ru'),(33,'baseitems','ADMIN_MENU','baseitems','ru'),(34,'Add','base','Add','ru'),(35,'Change','base','Change','ru'),(36,'Please check item first','','Please check item first','ru'),(37,'Apply','','Apply','ru'),(38,'Save','','Save','ru'),(39,'Content','baseitems','Content','ru'),(40,'Show Teaser','baseitems','Show Teaser','ru'),(41,'baseitemsTeaser','baseitems','baseitemsTeaser','ru'),(42,'General','baseitems','General','ru'),(43,'-- Select --','','-- Select --','ru'),(44,'Meta','baseitems','Meta','ru'),(45,'MetaTitle','baseitems','MetaTitle','ru'),(46,'MetaKeywords','baseitems','MetaKeywords','ru'),(47,'MetaDescription','baseitems','MetaDescription','ru'),(48,'MetaAlt','baseitems','MetaAlt','ru'),(49,'Content','basecategories','Content','ru'),(50,'General','basecategories','General','ru'),(51,'Changed successfully','baseitems','Changed successfully','ru'),(52,'Requered data absent','DEFAULT','Requered data absent','ru'),(53,'Added successfully','basecategories','Added successfully','ru'),(54,'Changed successfully','basecategories','Changed successfully','ru'),(55,'pages','pages','pages','ru'),(56,'pages','ADMIN_MENU','pages','ru'),(57,'Add','pages','Add','ru'),(58,'Change','pages','Change','ru'),(59,'ID','pages','ID','ru'),(60,'SEOName','pages','SEOName','ru'),(61,'Name','pages','Name','ru'),(62,'Lang','pages','Lang','ru'),(63,'Module','pages','Module','ru'),(64,'InMenu','pages','InMenu','ru'),(65,'Content','pages','Content','ru'),(66,'Url','pages','Url','ru'),(67,'Title','pages','Title','ru'),(68,'Show Teaser','pages','Show Teaser','ru'),(69,'pagesTeaser','pages','pagesTeaser','ru'),(70,'General','pages','General','ru'),(71,'CategoryID','pages','CategoryID','ru'),(72,'Published','pages','Published','ru'),(73,'LoginRequired','pages','LoginRequired','ru'),(74,'Meta','pages','Meta','ru'),(75,'MetaTitle','pages','MetaTitle','ru'),(76,'MetaKeywords','pages','MetaKeywords','ru'),(77,'MetaDescription','pages','MetaDescription','ru'),(78,'MetaAlt','pages','MetaAlt','ru'),(79,'Added successfully','pages','Added successfully','ru'),(80,'Error adding','pages','Error adding','ru'),(81,'Changed successfully','pages','Changed successfully','ru'),(82,'ModuleAttr','pages','ModuleAttr','ru'),(83,'Attributes','pages','Attributes','ru'),(84,'article','ADMIN_MENU','article','ru'),(85,'ID','images','ID','ru'),(86,'DataID','images','DataID','ru'),(87,'Src','images','Src','ru'),(88,'images','images','images','ru'),(89,'images','ADMIN_MENU','images','ru'),(90,'Add','images','Add','ru'),(91,'Change','images','Change','ru'),(92,'Name','images','Name','ru'),(93,'Type','images','Type','ru'),(94,'UserID','images','UserID','ru'),(95,'CategoryID','images','CategoryID','ru'),(96,'Lang','images','Lang','ru'),(97,'Title','images','Title','ru'),(98,'Published','images','Published','ru'),(99,'LoginRequired','images','LoginRequired','ru'),(100,'ViewCount','images','ViewCount','ru'),(101,'Url','images','Url','ru'),(102,'Content','images','Content','ru'),(103,'Show Teaser','images','Show Teaser','ru'),(104,'imagesTeaser','images','imagesTeaser','ru'),(105,'General','images','General','ru'),(106,'Meta','images','Meta','ru'),(107,'MetaTitle','images','MetaTitle','ru'),(108,'MetaKeywords','images','MetaKeywords','ru'),(109,'MetaDescription','images','MetaDescription','ru'),(110,'MetaAlt','images','MetaAlt','ru'),(111,'ID','categories','ID','ru'),(112,'UserID','categories','UserID','ru'),(113,'Type','categories','Type','ru'),(114,'ParentID','categories','ParentID','ru'),(115,'Lang','categories','Lang','ru'),(116,'Name','categories','Name','ru'),(117,'Description','categories','Description','ru'),(118,'Published','categories','Published','ru'),(119,'LoginRequired','categories','LoginRequired','ru'),(120,'Url','categories','Url','ru'),(121,'ID','items','ID','ru'),(122,'Type','items','Type','ru'),(123,'UserID','items','UserID','ru'),(124,'CategoryID','items','CategoryID','ru'),(125,'Lang','items','Lang','ru'),(126,'Title','items','Title','ru'),(127,'Published','items','Published','ru'),(128,'LoginRequired','items','LoginRequired','ru'),(129,'ViewCount','items','ViewCount','ru'),(130,'Url','items','Url','ru'),(131,'categories','article','categories','ru'),(132,'items','article','items','ru'),(133,'categories','ADMIN_MENU','categories','ru'),(134,'items','ADMIN_MENU','items','ru'),(135,'Add','article','Add','ru'),(136,'Change','article','Change','ru'),(137,'ID','article','ID','ru'),(138,'Type','article','Type','ru'),(139,'UserID','article','UserID','ru'),(140,'CategoryID','article','CategoryID','ru'),(141,'Lang','article','Lang','ru'),(142,'Title','article','Title','ru'),(143,'Published','article','Published','ru'),(144,'LoginRequired','article','LoginRequired','ru'),(145,'ViewCount','article','ViewCount','ru'),(146,'Url','article','Url','ru'),(147,'article','article','article','ru'),(148,'categories','images','categories','ru'),(149,'ID','imagescategories','ID','ru'),(150,'UserID','imagescategories','UserID','ru'),(151,'Type','imagescategories','Type','ru'),(152,'ParentID','imagescategories','ParentID','ru'),(153,'Lang','imagescategories','Lang','ru'),(154,'Name','imagescategories','Name','ru'),(155,'Description','imagescategories','Description','ru'),(156,'Published','imagescategories','Published','ru'),(157,'LoginRequired','imagescategories','LoginRequired','ru'),(158,'Url','imagescategories','Url','ru'),(159,'imagescategories','images','imagescategories','ru'),(160,'imagescategories','ADMIN_MENU','imagescategories','ru'),(161,'Content','imagescategories','Content','ru'),(162,'General','imagescategories','General','ru'),(163,'Added successfully','imagescategories','Added successfully','ru'),(164,'Added successfully','images','Added successfully','ru'),(165,'Error adding','images','Error adding','ru'),(166,'Content','items','Content','ru'),(167,'Show Teaser','items','Show Teaser','ru'),(168,'itemsTeaser','items','itemsTeaser','ru'),(169,'General','items','General','ru'),(170,'Meta','items','Meta','ru'),(171,'MetaTitle','items','MetaTitle','ru'),(172,'MetaKeywords','items','MetaKeywords','ru'),(173,'MetaDescription','items','MetaDescription','ru'),(174,'MetaAlt','items','MetaAlt','ru'),(175,'Added successfully','items','Added successfully','ru'),(176,'Upload','images','Upload','ru'),(177,'Upload Images','images','Upload Images','ru'),(178,'Cancel','images','Cancel','ru'),(179,'Select file','images','Select file','ru'),(180,'Upload file','images','Upload file','ru'),(181,'Filed','images','Filed','ru'),(182,'Files','images','Files','ru'),(183,'Upload files','images','Upload files','ru'),(184,'File uploaded','images','File uploaded','ru'),(185,'Modified','imagescategories','Modified','ru'),(186,'Changed successfully','images','Changed successfully','ru'),(187,'Changed successfully','imagescategories','Changed successfully','ru'),(188,'Change','imagescategories','Change','ru'),(189,'Change','categories','Change','ru'),(190,'Change','items','Change','ru'),(191,'ID','users','ID','ru'),(192,'Login','users','Login','ru'),(193,'Password','users','Password','ru'),(194,'Lang','users','Lang','ru'),(195,'Group','users','Group','ru'),(196,'Name','users','Name','ru'),(197,'Email','users','Email','ru'),(198,'Published','users','Published','ru'),(199,'EditLang','users','EditLang','ru'),(200,'Change','users','Change','ru'),(201,'users','users','users','ru'),(202,'Add','users','Add','ru'),(203,'Content','users','Content','ru'),(204,'Url','users','Url','ru'),(205,'Title','users','Title','ru'),(206,'Show Teaser','users','Show Teaser','ru'),(207,'usersTeaser','users','usersTeaser','ru'),(208,'General','users','General','ru'),(209,'CategoryID','users','CategoryID','ru'),(210,'LoginRequired','users','LoginRequired','ru'),(211,'Meta','users','Meta','ru'),(212,'MetaTitle','users','MetaTitle','ru'),(213,'MetaKeywords','users','MetaKeywords','ru'),(214,'MetaDescription','users','MetaDescription','ru'),(215,'MetaAlt','users','MetaAlt','ru'),(216,'Familyname','users','Familyname','ru'),(217,'Additional','users','Additional','ru'),(218,'Accound data','users','Accound data','ru'),(219,'Additional data','users','Additional data','ru'),(220,'Patronymic','users','Patronymic','ru'),(221,'Country','users','Country','ru'),(222,'City','users','City','ru'),(223,'Address','users','Address','ru'),(224,'Address2','users','Address2','ru'),(225,'ZIP','users','ZIP','ru'),(226,'Phone','users','Phone','ru'),(227,'Cellphone','users','Cellphone','ru'),(228,'Content','categories','Content','ru'),(229,'General','categories','General','ru'),(230,'File deleted successfully','images','File deleted successfully','ru');
/*!40000 ALTER TABLE `bs_vocabulary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions2`
--

DROP TABLE IF EXISTS `sessions2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions2` (
  `sesskey` varchar(64) NOT NULL DEFAULT '',
  `expiry` datetime NOT NULL,
  `expireref` varchar(250) DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sessdata` longtext,
  PRIMARY KEY (`sesskey`),
  KEY `sess2_expiry` (`expiry`),
  KEY `sess2_expireref` (`expireref`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions2`
--

LOCK TABLES `sessions2` WRITE;
/*!40000 ALTER TABLE `sessions2` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions2` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-12-08 15:58:45
