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
CREATE SCHEMA IF NOT EXISTS `dbcst256` DEFAULT CHARACTER SET utf8 ;
USE `dbcst256` ;

-- -----------------------------------------------------
-- Table `dbcst256`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbcst256`.`user` (
    `id` INT(20) NOT NULL AUTO_INCREMENT,
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
    PRIMARY KEY (`id`),
    UNIQUE INDEX `users_email_unique` (`email` ASC) )
    ENGINE = InnoDB
    AUTO_INCREMENT = 12
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;
    
    
    -- -----------------------------------------------------
    -- Table `dbcst256`.`portfolio`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `dbcst256`.`portfolio` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        INDEX `user_fk_idx` (`user_id` ASC) ,
        CONSTRAINT `user_fk`
        FOREIGN KEY (`user_id`)
        REFERENCES `dbcst256`.`user` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE)
        ENGINE = InnoDB
        AUTO_INCREMENT = 5
        DEFAULT CHARACTER SET = utf8;
        
        
        -- -----------------------------------------------------
        -- Table `dbcst256`.`education`
        -- -----------------------------------------------------
        CREATE TABLE IF NOT EXISTS `dbcst256`.`education` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `portfolio_id` INT(11) NULL DEFAULT NULL,
            `start_date` VARCHAR(45) NULL DEFAULT '',
            `end_date` VARCHAR(45) NULL DEFAULT '',
            `institution` VARCHAR(45) NULL DEFAULT 'New_Education',
            `gpa` DECIMAL(10,2) NULL DEFAULT '0.00',
            PRIMARY KEY (`id`),
            INDEX `portfolio_fk_idx` (`portfolio_id` ASC) ,
            CONSTRAINT `portEducation_fk`
            FOREIGN KEY (`portfolio_id`)
            REFERENCES `dbcst256`.`portfolio` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
            ENGINE = InnoDB
            AUTO_INCREMENT = 9
            DEFAULT CHARACTER SET = utf8;
            
            
            -- -----------------------------------------------------
            -- Table `dbcst256`.`history`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `dbcst256`.`history` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `portfolio_id` INT(11) NULL DEFAULT NULL,
                `description` VARCHAR(45) NULL DEFAULT 'New_History',
                PRIMARY KEY (`id`),
                INDEX `portfolio_fk_idx` (`portfolio_id` ASC) ,
                CONSTRAINT `portHistory_fk`
                FOREIGN KEY (`portfolio_id`)
                REFERENCES `dbcst256`.`portfolio` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
                ENGINE = InnoDB
                AUTO_INCREMENT = 7
                DEFAULT CHARACTER SET = utf8;
                
                
                -- -----------------------------------------------------
                -- Table `dbcst256`.`job`
                -- -----------------------------------------------------
                CREATE TABLE IF NOT EXISTS `dbcst256`.`job` (
                    `idjobs` INT(11) NOT NULL AUTO_INCREMENT,
                    `title` VARCHAR(45) NULL DEFAULT NULL,
                    `company` VARCHAR(45) NULL DEFAULT NULL,
                    `salary` INT(11) NULL DEFAULT NULL,
                    `field` VARCHAR(45) NULL DEFAULT NULL,
                    `location` VARCHAR(45) NULL DEFAULT NULL,
                    `description` VARCHAR(200) NULL DEFAULT NULL,
                    `experience` VARCHAR(45) NULL DEFAULT NULL,
                    `skills` VARCHAR(45) NULL DEFAULT NULL,
                    PRIMARY KEY (`id`))
                    ENGINE = InnoDB
                    AUTO_INCREMENT = 4
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
                        AUTO_INCREMENT = 4
                    DEFAULT CHARACTER SET = utf8mb4
                    COLLATE = utf8mb4_unicode_ci;
                    
                    
                    -- -----------------------------------------------------
                    -- Table `dbcst256`.`password_resets`
                    -- -----------------------------------------------------
                    CREATE TABLE IF NOT EXISTS `dbcst256`.`password_resets` (
                        `email` VARCHAR(255) NOT NULL,
                        `token` VARCHAR(255) NOT NULL,
                        `created_at` TIMESTAMP NULL DEFAULT NULL,
                        INDEX `password_resets_email_index` (`email` ASC) )
                        ENGINE = InnoDB
                        DEFAULT CHARACTER SET = utf8mb4
                        COLLATE = utf8mb4_unicode_ci;
                        
                        
                        -- -----------------------------------------------------
                        -- Table `dbcst256`.`skills`
                        -- -----------------------------------------------------
                        CREATE TABLE IF NOT EXISTS `dbcst256`.`skills` (
                            `id` INT(11) NOT NULL AUTO_INCREMENT,
                            `portfolio_id` INT(11) NULL DEFAULT NULL,
                            `description` VARCHAR(45) NULL DEFAULT 'New_Skills',
                            PRIMARY KEY (`id`),
                            INDEX `portfolio_fk_idx` (`portfolio_id` ASC) ,
                            CONSTRAINT `portSkills_fk`
                            FOREIGN KEY (`portfolio_id`)
                            REFERENCES `dbcst256`.`portfolio` (`id`)
                            ON DELETE NO ACTION
                            ON UPDATE NO ACTION)
                            ENGINE = InnoDB
                            AUTO_INCREMENT = 14
                            DEFAULT CHARACTER SET = utf8;
                            
                            
                            SET SQL_MODE=@OLD_SQL_MODE;
                            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
                            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
                    
