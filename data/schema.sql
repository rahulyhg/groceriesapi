-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema groceries
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema groceries
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `groceries` DEFAULT CHARACTER SET utf8 ;
USE `groceries` ;

-- -----------------------------------------------------
-- Table `groceries`.`lists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `groceries`.`lists` (
  `id` BINARY(16) NOT NULL,
  `date` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `groceries`.`items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `groceries`.`items` (
  `id` BINARY(16) NOT NULL,
  `description` VARCHAR(100) NULL DEFAULT NULL,
  `price` DECIMAL(10,2) NULL DEFAULT NULL,
  `list` BINARY(16) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_items_lists_idx` (`list` ASC),
  CONSTRAINT `fk_items_lists`
    FOREIGN KEY (`list`)
    REFERENCES `groceries`.`lists` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `groceries`.`credentials`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `groceries`.`credentials` (
  `id` BINARY(16) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
