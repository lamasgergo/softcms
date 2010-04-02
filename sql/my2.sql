SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `my2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

-- -----------------------------------------------------
-- Table `my2`.`bs_blocks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_blocks` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_blocks` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Design` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Module` VARCHAR(255) NULL DEFAULT '' ,
  `ModuleSpec` VARCHAR(255) NULL DEFAULT NULL ,
  `Module_default` ENUM('yes','no') NOT NULL DEFAULT 'no' ,
  `Lang` CHAR(4) NOT NULL DEFAULT 'ru' ,
  `GetAdd` VARCHAR(255) NULL DEFAULT '' ,
  `MenuID` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = MyISAM
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_blocks_vars`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_blocks_vars` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_blocks_vars` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `BlocksID` BIGINT(21) UNSIGNED NOT NULL DEFAULT '0' ,
  `Module` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Params` VARCHAR(255) NULL DEFAULT NULL ,
  `BlockName` VARCHAR(255) NOT NULL DEFAULT '' ,
  `BlockOrder` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_bs_blocks_vars_bs_blocks1` (`BlocksID` ASC) ,
  CONSTRAINT `fk_bs_blocks_vars_bs_blocks1`
    FOREIGN KEY (`BlocksID` )
    REFERENCES `my2`.`bs_blocks` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_users_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_users_data` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_users_data` (
  `ID` INT NOT NULL ,
  `Familyname` VARCHAR(255) NULL ,
  `Patronymic` VARCHAR(255) NULL ,
  `Country` VARCHAR(255) NULL ,
  `City` VARCHAR(255) NULL ,
  `Address` TEXT NULL ,
  `Address2` TEXT NULL ,
  `ZIP` VARCHAR(45) NULL ,
  `Phone` VARCHAR(255) NULL ,
  `Cellphone` VARCHAR(255) NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `my2`.`bs_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_users` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_users` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Login` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Password` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Lang` CHAR(4) NOT NULL DEFAULT 'ru' ,
  `Group` VARCHAR(255) NOT NULL DEFAULT 'users' ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Email` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Published` ENUM('0','1') NOT NULL DEFAULT '0' ,
  `EditLang` CHAR(4) NOT NULL DEFAULT 'ru' ,
  PRIMARY KEY (`ID`) ,
  UNIQUE INDEX `uniq` (`Login` ASC) ,
  INDEX `fk_bs_users_bs_comments1` (`ID` ASC) ,
  INDEX `fk_bs_users_bs_users_data1` (`ID` ASC) ,
  CONSTRAINT `fk_bs_users_bs_comments1`
    FOREIGN KEY (`ID` )
    REFERENCES `my2`.`bs_comments` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bs_users_bs_users_data1`
    FOREIGN KEY (`ID` )
    REFERENCES `my2`.`bs_users_data` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_data_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_data_categories` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_data_categories` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `UserID` BIGINT(21) UNSIGNED NOT NULL DEFAULT '0' ,
  `Type` VARCHAR(255) NOT NULL DEFAULT 'article' ,
  `ParentID` BIGINT(21) UNSIGNED NULL DEFAULT '0' ,
  `Lang` CHAR(4) NOT NULL DEFAULT 'ru' ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Description` TEXT NULL DEFAULT NULL ,
  `Published` INT(3) NULL DEFAULT '0' ,
  `Modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `LoginRequired` TINYINT(3) UNSIGNED NULL DEFAULT '0' ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_bs_data_categories_bs_users1` (`UserID` ASC) ,
  CONSTRAINT `fk_bs_data_categories_bs_users1`
    FOREIGN KEY (`UserID` )
    REFERENCES `my2`.`bs_users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_images` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_images` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `GroupID` BIGINT(21) UNSIGNED NULL DEFAULT NULL ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Image` VARCHAR(255) NOT NULL DEFAULT '' ,
  `ImageResize` VARCHAR(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`ID`) )
ENGINE = MyISAM
AUTO_INCREMENT = 322
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_images_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_images_group` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_images_group` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_bs_images_group_bs_images1` (`ID` ASC) ,
  CONSTRAINT `fk_bs_images_group_bs_images1`
    FOREIGN KEY (`ID` )
    REFERENCES `my2`.`bs_images` (`GroupID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 322
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_data` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_data` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Type` VARCHAR(255) NOT NULL DEFAULT 'article' ,
  `UserID` BIGINT(21) UNSIGNED NOT NULL DEFAULT '0' ,
  `CategoryID` BIGINT(21) UNSIGNED NOT NULL DEFAULT '0' ,
  `Lang` CHAR(4) NOT NULL DEFAULT 'ru' ,
  `Title` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Content` TEXT NULL DEFAULT NULL ,
  `Teaser` TEXT NULL DEFAULT NULL ,
  `Published` ENUM('0','1') NOT NULL DEFAULT '0' ,
  `Modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `MetaAlt` VARCHAR(255) NULL DEFAULT NULL ,
  `MetaKeywords` VARCHAR(255) NULL DEFAULT NULL ,
  `MetaTitle` VARCHAR(255) NULL DEFAULT NULL ,
  `MetaDescription` VARCHAR(255) NULL DEFAULT NULL ,
  `LoginRequired` TINYINT(3) UNSIGNED NULL DEFAULT '0' ,
  `ViewCount` INT UNSIGNED NULL DEFAULT '0' ,
  `ImageGroupID` INT UNSIGNED NULL DEFAULT '0' ,
  PRIMARY KEY (`ID`) ,
  FULLTEXT INDEX `search` (`Title` ASC, `Content` ASC, `Teaser` ASC) ,
  INDEX `fk_bs_data_bs_data_categories` (`CategoryID` ASC) ,
  INDEX `fk_bs_data_bs_users1` (`UserID` ASC) ,
  INDEX `fk_bs_data_bs_images_group1` (`ImageGroupID` ASC) ,
  CONSTRAINT `fk_bs_data_bs_data_categories`
    FOREIGN KEY (`CategoryID` )
    REFERENCES `my2`.`bs_data_categories` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bs_data_bs_users1`
    FOREIGN KEY (`UserID` )
    REFERENCES `my2`.`bs_users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bs_data_bs_images_group1`
    FOREIGN KEY (`ImageGroupID` )
    REFERENCES `my2`.`bs_images_group` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_comments` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_comments` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Item` VARCHAR(100) NOT NULL DEFAULT '' ,
  `ItemID` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `Comment` TEXT NOT NULL ,
  `Approved` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' ,
  `UserID` INT(10) UNSIGNED NULL DEFAULT '0' ,
  `Created` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `Item` (`Item` ASC) ,
  INDEX `fk_bs_comments_bs_data1` (`ItemID` ASC) ,
  CONSTRAINT `fk_bs_comments_bs_data1`
    FOREIGN KEY (`ItemID` )
    REFERENCES `my2`.`bs_data` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_users_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_users_groups` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_users_groups` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`ID`) ,
  UNIQUE INDEX `uniq` (`Name` ASC) ,
  INDEX `fk_bs_groups_bs_users1` (`ID` ASC) ,
  CONSTRAINT `fk_bs_groups_bs_users1`
    FOREIGN KEY (`ID` )
    REFERENCES `my2`.`bs_users` (`Group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_lang`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_lang` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_lang` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NOT NULL DEFAULT '' ,
  `Description` VARCHAR(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`ID`) ,
  UNIQUE INDEX `name_unique` (`Name` ASC) ,
  INDEX `fk_bs_lang_bs_data1` (`Name` ASC) ,
  INDEX `fk_bs_lang_bs_data_categories1` (`Name` ASC) ,
  CONSTRAINT `fk_bs_lang_bs_data1`
    FOREIGN KEY (`Name` )
    REFERENCES `my2`.`bs_data` (`Lang` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bs_lang_bs_data_categories1`
    FOREIGN KEY (`Name` )
    REFERENCES `my2`.`bs_data_categories` (`Lang` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_menutree`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_menutree` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_menutree` (
  `ID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Link` VARCHAR(255) NOT NULL DEFAULT '' ,
  `LinkAlias` VARCHAR(255) NULL DEFAULT NULL ,
  `ParentID` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `OrderNum` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `External` ENUM('0','1') NOT NULL DEFAULT '0' ,
  `Created` DATETIME NULL DEFAULT NULL ,
  `Lang` CHAR(4) NOT NULL DEFAULT 'ru' ,
  `Published` TINYINT(3) UNSIGNED NULL DEFAULT '1' ,
  `Image` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_bs_menutree_bs_lang1` (`Lang` ASC) ,
  CONSTRAINT `fk_bs_menutree_bs_lang1`
    FOREIGN KEY (`Lang` )
    REFERENCES `my2`.`bs_lang` (`Name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_modules_rights`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_modules_rights` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_modules_rights` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Module` VARCHAR(255) NOT NULL ,
  `UserID` BIGINT(21) UNSIGNED NULL DEFAULT NULL ,
  `Group` VARCHAR(255) NULL DEFAULT NULL ,
  `Action` VARCHAR(255) NOT NULL ,
  `Approved` TINYINT(3) NOT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = MyISAM
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_modules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_modules` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_modules` (
  `ID` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `ModGroup` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Active` TINYINT(3) NOT NULL DEFAULT '1' ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_bs_modules_bs_blocks1` (`Name` ASC) ,
  INDEX `fk_bs_modules_bs_modules_rights1` (`ID` ASC) ,
  CONSTRAINT `fk_bs_modules_bs_blocks1`
    FOREIGN KEY (`Name` )
    REFERENCES `my2`.`bs_blocks` (`Module` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bs_modules_bs_modules_rights1`
    FOREIGN KEY (`ID` )
    REFERENCES `my2`.`bs_modules_rights` (`Module` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `my2`.`bs_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `my2`.`bs_settings` ;

CREATE  TABLE IF NOT EXISTS `my2`.`bs_settings` (
  `Key` VARCHAR(255) NOT NULL DEFAULT '' ,
  `Value` TEXT NOT NULL ,
  PRIMARY KEY (`Key`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `my2`.`bs_users`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
insert into `my2`.`bs_users` (`ID`, `Login`, `Password`, `Lang`, `Group`, `Name`, `Email`, `Published`, `EditLang`) values (NULL, 'admin', '1$/JsQ4Mkd7N2', 'ru', 'administrators', 'admin', 'a.diesel@gmail.com', '1', 'ru');
insert into `my2`.`bs_users` (`ID`, `Login`, `Password`, `Lang`, `Group`, `Name`, `Email`, `Published`, `EditLang`) values (NULL, 'admin2', '1$8VJ9etjPUEY', 'ru', 'administrators', 'admin2', 'a.diesel@gmail.com', '1', 'ru');

COMMIT;

-- -----------------------------------------------------
-- Data for table `my2`.`bs_users_groups`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
insert into `my2`.`bs_users_groups` (`ID`, `Name`) values (1, 'administarators');
insert into `my2`.`bs_users_groups` (`ID`, `Name`) values (2, 'users');

COMMIT;

-- -----------------------------------------------------
-- Data for table `my2`.`bs_modules`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
insert into `my2`.`bs_modules` (`ID`, `Name`, `ModGroup`, `Active`) values (NULL, 'content', 'base', '1');
insert into `my2`.`bs_modules` (`ID`, `Name`, `ModGroup`, `Active`) values (NULL, 'users', 'base', '1');

COMMIT;

-- -----------------------------------------------------
-- Data for table `my2`.`bs_settings`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
insert into `my2`.`bs_settings` (`Key`, `Value`) values ('smarty_templates_dir', '/source/templates');
insert into `my2`.`bs_settings` (`Key`, `Value`) values ('smarty_compiled_dir', '/source/templates_c');
insert into `my2`.`bs_settings` (`Key`, `Value`) values ('smarty_plugins_dir', '/source/plugins');
insert into `my2`.`bs_settings` (`Key`, `Value`) values ('smarty_caching', '0');

COMMIT;
