-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dbcst256
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbcst256
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbcst256` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs ;
USE `dbcst256` ;

-- -----------------------------------------------------
-- Table `dbcst256`.`affinity`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`affinity` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbcst256`.`job`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`job` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  `company` VARCHAR(45) NULL DEFAULT NULL,
  `salary` INT(11) NULL DEFAULT NULL,
  `field` VARCHAR(45) NULL DEFAULT NULL,
  `skills` VARCHAR(45) NULL DEFAULT NULL,
  `experience` VARCHAR(45) NULL DEFAULT NULL,
  `location` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbcst256`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `tbl_roles_id_role` INT(11) NULL DEFAULT '1',
  `bio` VARCHAR(45) NULL DEFAULT NULL,
  `website` VARCHAR(45) NULL DEFAULT NULL,
  `city` VARCHAR(45) NULL DEFAULT NULL,
  `state` VARCHAR(45) NULL DEFAULT NULL,
  `field` VARCHAR(45) NULL DEFAULT NULL,
  `picture` VARCHAR(1000) NULL DEFAULT NULL,
  `verified` INT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `dbcst256`.`application`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`application` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `job_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_who_applied_idx` (`user_id` ASC),
  INDEX `job_appllied_to_idx` (`job_id` ASC),
  CONSTRAINT `job_appllied_to`
    FOREIGN KEY (`job_id`)
    REFERENCES `dbcst256`.`job` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `user_who_applied`
    FOREIGN KEY (`user_id`)
    REFERENCES `dbcst256`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_cs;


-- -----------------------------------------------------
-- Table `dbcst256`.`portfolio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`portfolio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_fk_idx` (`user_id` ASC),
  CONSTRAINT `user_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `dbcst256`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbcst256`.`education`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`education` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` INT(11) NULL DEFAULT NULL,
  `start_date` VARCHAR(45) NULL DEFAULT ' ',
  `end_date` VARCHAR(45) NULL DEFAULT ' ',
  `institution` VARCHAR(45) NULL DEFAULT 'new_institution',
  `gpa` DECIMAL(10,2) NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  INDEX `portfolio_fk_idx` (`portfolio_id` ASC),
  CONSTRAINT `portEducation_fk`
    FOREIGN KEY (`portfolio_id`)
    REFERENCES `dbcst256`.`portfolio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbcst256`.`history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` INT(11) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT 'new_history',
  PRIMARY KEY (`id`),
  INDEX `portfolio_fk_idx` (`portfolio_id` ASC),
  CONSTRAINT `portHistory_fk`
    FOREIGN KEY (`portfolio_id`)
    REFERENCES `dbcst256`.`portfolio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbcst256`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`migrations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `dbcst256`.`password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `password_resets_email_index` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `dbcst256`.`skills`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`skills` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` INT(11) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT 'new_skill',
  PRIMARY KEY (`id`),
  INDEX `portfolio_fk_idx` (`portfolio_id` ASC),
  CONSTRAINT `portSkills_fk`
    FOREIGN KEY (`portfolio_id`)
    REFERENCES `dbcst256`.`portfolio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
                                       
-- -----------------------------------------------------
-- Table `dbcst256`.`usergroups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`usergroups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `affinity_id` INT(11) NULL DEFAULT NULL,
  `users_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `affinity_fk_idx` (`affinity_id` ASC),
  INDEX `users_fk_idx` (`users_id` ASC),
  CONSTRAINT `affinity_fk`
    FOREIGN KEY (`affinity_id`)
    REFERENCES `dbcst256`.`affinity` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `users_fk`
    FOREIGN KEY (`users_id`)
    REFERENCES `dbcst256`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
