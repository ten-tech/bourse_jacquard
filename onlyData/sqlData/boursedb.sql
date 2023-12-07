
-- -----------------------------------------------------
-- Table conseiller
-- -----------------------------------------------------
CREATE TABLE conseiller (
 idCnll INT NOT NULL AUTO_INCREMENT,
 non VARCHAR(55) NULL,
 prenom VARCHAR(55) NULL,
 PRIMARY KEY (idCnll))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table client
-- -----------------------------------------------------
CREATE TABLE client (
 idClient INT(45) NOT NULL AUTO_INCREMENT,
 civilite VARCHAR(45) NOT NULL,
 nom VARCHAR(55) NULL,
 prenom VARCHAR(55) NULL,
 dateNaissance DATE NULL,
 email VARCHAR(100) NULL,
 motDePasse VARCHAR(55) NULL,
 telephone INT(10) NULL,
 adresse VARCHAR(100) NULL,
 ville VARCHAR(55) NULL,
 pays VARCHAR(55) NULL,
 dateOuverture TIMESTAMP NULL,
 dateExp DATE NULL,
 conseiller_idCnll INT NOT NULL,
 PRIMARY KEY (idClient),
 INDEX fk_client_conseiller1_idx (conseiller_idCnll ASC) ,
 CONSTRAINT fk_client_conseiller1
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
CREATE TABLE portefeuille (
 idPortefeuille INT(45) NOT NULL AUTO_INCREMENT,
 solde DOUBLE NULL,
 valeurPortefeuille DOUBLE NULL,
 client_idClient INT(45) NOT NULL,
 PRIMARY KEY (idPortefeuille),
 INDEX fk_portefeuille_client1_idx (client_idClient ASC) ,
 CONSTRAINT fk_portefeuille_client1
  FOREIGN KEY (client_idClient)
  REFERENCES client (idClient)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table bourse_data
-- -----------------------------------------------------
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
CREATE TABLE action (
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
 INDEX fk_action_portefeuille1_idx (portefeuille_idPortefeuille ASC) ,
 INDEX fk_action_bourse_data1_idx (bourse_data_idBourseData ASC) ,
 CONSTRAINT fk_action_portefeuille1
  FOREIGN KEY (portefeuille_idPortefeuille)
  REFERENCES portefeuille (idPortefeuille)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
 CONSTRAINT fk_action_bourse_data1
  FOREIGN KEY (bourse_data_idBourseData)
  REFERENCES bourse_data (idBourseData)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

