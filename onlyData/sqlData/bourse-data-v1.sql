-- -----------------------------------------------------
-- Création et usage de la base de données bourse_data
-- -----------------------------------------------------
DROP DATABASE IF EXISTS bourses_data;
CREATE DATABASE bourses_data;
USE bourses_data;
-- -----------------------------------------------------
-- Table conseiller
-- -----------------------------------------------------
DROP TABLE IF EXISTS conseiller;
CREATE TABLE conseiller (
 idCnll INT NOT NULL AUTO_INCREMENT,
 nom VARCHAR(55) NULL,
 prenom VARCHAR(55) NULL,
 PRIMARY KEY (idCnll))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table client
-- -----------------------------------------------------
DROP TABLE IF EXISTS client;
CREATE TABLE client (
 idClient INT(45) NOT NULL AUTO_INCREMENT,
 civilite VARCHAR(45) NOT NULL,
 nom VARCHAR(55) NULL,
 prenom VARCHAR(55) NULL,
 dateNaissance DATE NULL,
 email VARCHAR(100) NULL,
 codeActive VARCHAR(55) NULL,
 motDePasse VARCHAR(55) NULL,
 telephone INT(10) NULL,
 dateOuverture TIMESTAMP NULL,
 dateExp DATE NULL,
 conseiller_idCnll INT NOT NULL,
 PRIMARY KEY (idClient),
  FOREIGN KEY (conseiller_idCnll)
  REFERENCES conseiller (idCnll)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table portefeuille
-- -----------------------------------------------------
DROP TABLE IF EXISTS portefeuille;
CREATE TABLE portefeuille (
 idPortefeuille INT(45) NOT NULL AUTO_INCREMENT,
 solde DOUBLE NULL,
 valeurPortefeuille DOUBLE NULL,
 client_idClient INT(45) NOT NULL,
 PRIMARY KEY (idPortefeuille),
  FOREIGN KEY (client_idClient)
  REFERENCES client (idClient)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table bourse_data
-- -----------------------------------------------------
DROP TABLE IF EXISTS bourse_data;
CREATE TABLE bourse_data (
 idBourseData INT(45) NOT NULL AUTO_INCREMENT,
 nom VARCHAR(65) NULL,
 dateActuelle DATETIME NULL,
 ouverture FLOAT NULL,
 hausse FLOAT NULL,
 basse FLOAT NULL,
 volume FLOAT NULL,
 veille FLOAT NULL,
 dernierEchange FLOAT NULL,
 variation FLOAT NULL,
 PRIMARY KEY (idBourseData))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table action
-- -----------------------------------------------------
DROP TABLE IF EXISTS actions;
CREATE TABLE actions (
 idAction INT(45) NOT NULL AUTO_INCREMENT,
 nomCours VARCHAR(65) NULL,
 dateActuelle DATETIME NULL,
 ouverture FLOAT NULL,
 hausse FLOAT NULL,
 basse FLOAT NULL,
 volume FLOAT NULL,
 veille FLOAT NULL,
 dernierEchange FLOAT NULL,
 variation FLOAT NULL,
 prixAchat DOUBLE NULL,
 quantiteAchat INT(45) NULL,
 dateAchat DATE NULL,
 prixVente DOUBLE NULL,
 quantiteVente INT(45) NULL,
 dateVente DATE NULL,
 portefeuille_idPortefeuille INT(45) NOT NULL,
 bourse_data_idBourseData INT(45) NOT NULL,
 PRIMARY KEY (idAction),
  FOREIGN KEY (portefeuille_idPortefeuille)
  REFERENCES portefeuille (idPortefeuille)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  FOREIGN KEY (bourse_data_idBourseData)
  REFERENCES bourse_data (idBourseData)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
