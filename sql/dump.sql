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
-- Table structure for table `bs_blocks`
--

DROP TABLE IF EXISTS `bs_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_blocks` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Design` varchar(255) NOT NULL DEFAULT '',
  `Module` varchar(255) DEFAULT '',
  `ModuleSpec` varchar(255) DEFAULT NULL,
  `Module_default` enum('yes','no') NOT NULL DEFAULT 'no',
  `Lang` char(4) NOT NULL DEFAULT 'ru',
  `GetAdd` varchar(255) DEFAULT '',
  `MenuID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_blocks`
--

LOCK TABLES `bs_blocks` WRITE;
/*!40000 ALTER TABLE `bs_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_blocks_vars`
--

DROP TABLE IF EXISTS `bs_blocks_vars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_blocks_vars` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `BlocksID` bigint(21) unsigned NOT NULL DEFAULT '0',
  `Module` varchar(255) NOT NULL DEFAULT '',
  `Params` varchar(255) DEFAULT NULL,
  `BlockName` varchar(255) NOT NULL DEFAULT '',
  `BlockOrder` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `fk_bs_blocks_vars_bs_blocks1` (`BlocksID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_blocks_vars`
--

LOCK TABLES `bs_blocks_vars` WRITE;
/*!40000 ALTER TABLE `bs_blocks_vars` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_blocks_vars` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_data`
--

LOCK TABLES `bs_data` WRITE;
/*!40000 ALTER TABLE `bs_data` DISABLE KEYS */;
INSERT INTO `bs_data` VALUES (1,'article',16,6,'ru','test','123',NULL,'1','2010-05-27 11:38:09','test alt','test keywords','test title','test description',0,0,0,'test'),(2,'article',16,21237,'ru','хрень','123',NULL,'1','2010-09-16 15:17:04',NULL,NULL,NULL,NULL,0,0,0,'hren__'),(3,'article',16,21237,'ru','хрень какая-то :)','123 :)',NULL,'1','2010-09-16 15:18:53',':)',':)',':)',':)',0,0,0,'hren___kakayato_');
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
) ENGINE=MyISAM AUTO_INCREMENT=21240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_data_categories`
--

LOCK TABLES `bs_data_categories` WRITE;
/*!40000 ALTER TABLE `bs_data_categories` DISABLE KEYS */;
INSERT INTO `bs_data_categories` VALUES (6,16,'article',0,'ru','zxcv',NULL,0,'2010-04-09 15:10:51',0,''),(7,16,'article',0,'ru','aasdfsa',NULL,0,'2010-04-09 15:13:02',0,''),(21235,16,'article',0,'ru','новости','23',0,'2010-04-22 07:52:47',0,'/novosti2'),(21232,16,'article',0,'ru','новости','123',0,'2010-04-22 07:46:17',0,'/novosti'),(21233,16,'article',21232,'ru','мировые',NULL,0,'2010-04-22 07:46:45',0,'/novosti/miroviie'),(21236,16,'article',0,'ru','xxxxx','test',0,'2010-09-16 15:16:18',0,'/xxxxx'),(21237,16,'article',0,'ru','проверка','ыавафы',0,'2010-09-16 15:16:30',0,'/proverka'),(21238,16,'article',0,'ru','change locale vars','change locale vars desc',1,'2010-09-18 12:29:53',0,'/change locale vars'),(21239,16,'article',0,'ru','ss_ss 444 + :)','ssss',0,'2010-09-18 12:57:29',0,'/ss_ss_444__');
/*!40000 ALTER TABLE `bs_data_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_groups`
--

DROP TABLE IF EXISTS `bs_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_groups` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uniq` (`Name`),
  KEY `fk_bs_groups_bs_users1` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_groups`
--

LOCK TABLES `bs_groups` WRITE;
/*!40000 ALTER TABLE `bs_groups` DISABLE KEYS */;
INSERT INTO `bs_groups` VALUES (1,'administarators'),(2,'users');
/*!40000 ALTER TABLE `bs_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_images`
--

DROP TABLE IF EXISTS `bs_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_images` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `GroupID` bigint(21) unsigned DEFAULT NULL,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Image` varchar(255) NOT NULL DEFAULT '',
  `ImageResize` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=322 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_images`
--

LOCK TABLES `bs_images` WRITE;
/*!40000 ALTER TABLE `bs_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bs_images_group`
--

DROP TABLE IF EXISTS `bs_images_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_images_group` (
  `ID` bigint(21) unsigned NOT NULL AUTO_INCREMENT,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `fk_bs_images_group_bs_images1` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=322 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_images_group`
--

LOCK TABLES `bs_images_group` WRITE;
/*!40000 ALTER TABLE `bs_images_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `bs_images_group` ENABLE KEYS */;
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
INSERT INTO `bs_modules` VALUES (24,'article','base',1),(25,'users','base',1),(26,'base','base',1),(27,'pages','base',1);
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
-- Table structure for table `bs_pages`
--

DROP TABLE IF EXISTS `bs_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bs_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SEOName` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Lang` char(4) NOT NULL DEFAULT 'ru',
  `Module` varchar(255) DEFAULT 'content',
  `ModuleAttr` varchar(255) DEFAULT '',
  `InMenu` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `SEOName` (`SEOName`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_pages`
--

LOCK TABLES `bs_pages` WRITE;
/*!40000 ALTER TABLE `bs_pages` DISABLE KEYS */;
INSERT INTO `bs_pages` VALUES (1,'test','test','ru','content',NULL,1),(3,'tezt','tezt','ru','content',NULL,1),(4,'testovaya-stranitca','Тестовая страница','ru','content',NULL,1),(5,'proverka-svyazi','Проверка связи','ru','content',NULL,1);
/*!40000 ALTER TABLE `bs_pages` ENABLE KEYS */;
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
INSERT INTO `bs_sessions2` VALUES ('pedjc5f66hbt3dtcm8ltfk6d35','2010-11-28 14:13:03','','2010-11-28 12:21:12','2010-11-28 13:49:03','my_id%7Cs%3A2%3A%2216%22%3B'),('uggcr9njo41h0ecvpv0il95ig3','2010-11-29 15:18:27','','2010-11-29 14:54:19','2010-11-29 14:54:27','my_id%7Cs%3A2%3A%2216%22%3B'),('e6sedcvhi4vuace2ap7st82mn0','2010-11-19 19:14:56','','2010-11-19 17:49:27','2010-11-19 18:50:56','');
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
INSERT INTO `bs_settings` VALUES ('smarty_templates_dir','/design','templates: design dir'),('smarty_compiled_dir','/source/templates_c','templates: compile dir'),('smarty_plugins_dir','/source/plugins','templates: user plugins dir'),('smarty_caching','0','templates: use caching'),('default_lang','ru','default language'),('session_prefix','BS_','session prefix'),('upload_directory','/files','directory for uploading files'),('upload_tmp_directory','/files/tmp','temporary directory'),('navigation_perPage','2','show items per page'),('modules_varname','mod','_GET variable that define module name'),('theme','','current theme'),('meta_title','Test site','Default page title'),('meta_description','Test description','Default page description'),('meta_keywords','test, site, keywords','Default page keywords'),('meta_alt','test alt','Default page alt'),('rewrite_urls','true','Use user friendly links (mod_rewrite)');
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
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bs_vocabulary`
--

LOCK TABLES `bs_vocabulary` WRITE;
/*!40000 ALTER TABLE `bs_vocabulary` DISABLE KEYS */;
INSERT INTO `bs_vocabulary` VALUES (1,'Autorization','LOGIN','Autorization',''),(2,'Login','LOGIN','Login',''),(3,'Password','LOGIN','Password',''),(4,'Log in','LOGIN','Log in',''),(5,'Administration area','','Administration area',''),(6,'content','ADMIN_MENU','content','ru'),(7,'users','ADMIN_MENU','users','ru'),(8,'base','ADMIN_MENU','base','ru'),(9,'Logout','','Logout','ru'),(10,'ID','basecategories','ID','ru'),(11,'UserID','basecategories','UserID','ru'),(12,'Type','basecategories','Type','ru'),(13,'ParentID','basecategories','ParentID','ru'),(14,'Lang','basecategories','Lang','ru'),(15,'Name','basecategories','Name','ru'),(16,'Description','basecategories','Description','ru'),(17,'Published','basecategories','Published','ru'),(18,'LoginRequired','basecategories','LoginRequired','ru'),(19,'Url','basecategories','Url','ru'),(20,'ID','baseitems','ID','ru'),(21,'Type','baseitems','Type','ru'),(22,'UserID','baseitems','UserID','ru'),(23,'CategoryID','baseitems','CategoryID','ru'),(24,'Lang','baseitems','Lang','ru'),(25,'Title','baseitems','Title','ru'),(26,'Published','baseitems','Published','ru'),(27,'LoginRequired','baseitems','LoginRequired','ru'),(28,'ViewCount','baseitems','ViewCount','ru'),(29,'Url','baseitems','Url','ru'),(30,'basecategories','base','basecategories','ru'),(31,'baseitems','base','baseitems','ru'),(32,'basecategories','ADMIN_MENU','basecategories','ru'),(33,'baseitems','ADMIN_MENU','baseitems','ru'),(34,'Add','base','Add','ru'),(35,'Change','base','Change','ru'),(36,'Please check item first','','Please check item first','ru'),(37,'Apply','','Apply','ru'),(38,'Save','','Save','ru'),(39,'Content','baseitems','Content','ru'),(40,'Show Teaser','baseitems','Show Teaser','ru'),(41,'baseitemsTeaser','baseitems','baseitemsTeaser','ru'),(42,'General','baseitems','General','ru'),(43,'-- Select --','','-- Select --','ru'),(44,'Meta','baseitems','Meta','ru'),(45,'MetaTitle','baseitems','MetaTitle','ru'),(46,'MetaKeywords','baseitems','MetaKeywords','ru'),(47,'MetaDescription','baseitems','MetaDescription','ru'),(48,'MetaAlt','baseitems','MetaAlt','ru'),(49,'Content','basecategories','Content','ru'),(50,'General','basecategories','General','ru'),(51,'Changed successfully','baseitems','Changed successfully','ru'),(52,'Requered data absent','DEFAULT','Requered data absent','ru'),(53,'Added successfully','basecategories','Added successfully','ru'),(54,'Changed successfully','basecategories','Changed successfully','ru'),(55,'pages','pages','pages','ru'),(56,'pages','ADMIN_MENU','pages','ru'),(57,'Add','pages','Add','ru'),(58,'Change','pages','Change','ru'),(59,'ID','pages','ID','ru'),(60,'SEOName','pages','SEOName','ru'),(61,'Name','pages','Name','ru'),(62,'Lang','pages','Lang','ru'),(63,'Module','pages','Module','ru'),(64,'InMenu','pages','InMenu','ru'),(65,'Content','pages','Content','ru'),(66,'Url','pages','Url','ru'),(67,'Title','pages','Title','ru'),(68,'Show Teaser','pages','Show Teaser','ru'),(69,'pagesTeaser','pages','pagesTeaser','ru'),(70,'General','pages','General','ru'),(71,'CategoryID','pages','CategoryID','ru'),(72,'Published','pages','Published','ru'),(73,'LoginRequired','pages','LoginRequired','ru'),(74,'Meta','pages','Meta','ru'),(75,'MetaTitle','pages','MetaTitle','ru'),(76,'MetaKeywords','pages','MetaKeywords','ru'),(77,'MetaDescription','pages','MetaDescription','ru'),(78,'MetaAlt','pages','MetaAlt','ru'),(79,'Added successfully','pages','Added successfully','ru'),(80,'Error adding','pages','Error adding','ru'),(81,'Changed successfully','pages','Changed successfully','ru'),(82,'ModuleAttr','pages','ModuleAttr','ru'),(83,'Attributes','pages','Attributes','ru'),(84,'article','ADMIN_MENU','article','ru');
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

-- Dump completed on 2010-11-29 15:26:03
