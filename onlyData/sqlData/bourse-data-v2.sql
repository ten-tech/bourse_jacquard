DROP DATABASE IF EXISTS bourses_data;
CREATE DATABASE bourses_data;
USE bourses_data;
-- -----------------------------------------------------
-- Table conseiller
-- -----------------------------------------------------
CREATE TABLE  conseiller (
  idCnll INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(55) NULL,
  prenom VARCHAR(55) NULL,
  email VARCHAR(100) NOT NULL,
  passWord VARCHAR(255) NOT NULL,
  PRIMARY KEY (idCnll));


-- -----------------------------------------------------
-- Table client
-- -----------------------------------------------------
CREATE TABLE  client (
  idClient INT NOT NULL AUTO_INCREMENT,
  civilite VARCHAR(45) NOT NULL,
  nom VARCHAR(55) NULL,
  prenom VARCHAR(55) NULL,
  dateNaissance DATE NULL,
  email VARCHAR(100) NULL,
  motDePasse VARCHAR(55) NULL,
  telephone INT(10) NULL,
  dateOuverture TIMESTAMP,
  dateExp DATE NULL,
  idCnll INT NOT NULL,
  PRIMARY KEY (idClient),
  CONSTRAINT fk_client_conseiller1
    FOREIGN KEY (idCnll)
    REFERENCES conseiller (idCnll)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)s
AUTO_INCREMENT = 1;



-- -----------------------------------------------------
-- Table portefeuille
-- -----------------------------------------------------
CREATE TABLE  portefeuille (
  idPortefeuille INT NOT NULL AUTO_INCREMENT,
  solde DOUBLE NULL,
  valeurPortefeuille DOUBLE NULL,
  idClient INT NOT NULL,
  PRIMARY KEY (idPortefeuille),
  CONSTRAINT fk_portefeuille_client1
    FOREIGN KEY (idClient)
    REFERENCES client (idClient)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- -----------------------------------------------------
-- Table bourse_name
-- -----------------------------------------------------
CREATE TABLE  bourse_name (
  idBourseName INT NOT NULL AUTO_INCREMENT,
  siteName VARCHAR(65) NULL,
  PRIMARY KEY (idBourseName))
;


-- -----------------------------------------------------
-- Table bourse_data
-- -----------------------------------------------------
CREATE TABLE  bourse_data (
  idBourseData INT NOT NULL AUTO_INCREMENT,
  idBourseName INT NOT NULL,
  coursName VARCHAR(55) NULL,
  ouverture INT NULL,
  valeur_h FLOAT NULL,
  valeur_b FLOAT NULL,
  volume FLOAT NULL,
  dernier INT NULL,
  variation FLOAT NULL,
  datebd DATETIME NULL CURRENT_TIMESTAMP,
  PRIMARY KEY (idBourseData),
  CONSTRAINT fk_bourse_data_bourse_name1
    FOREIGN KEY (idBourseName)
    REFERENCES bourse_name (idBourseName)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table action
-- -----------------------------------------------------
CREATE TABLE  action (
  idAction INT NOT NULL AUTO_INCREMENT,
  dateAchat DATETIME NULL,
  dateVente DATETIME NULL,
  idPortefeuille INT NOT NULL,
  idBourseName INT NOT NULL,
  PRIMARY KEY (idAction),
  CONSTRAINT fk_action_portefeuille1
    FOREIGN KEY (idPortefeuille)
    REFERENCES portefeuille (idPortefeuille)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_action_bourse_name1
    FOREIGN KEY (idBourseName)
    REFERENCES bourse_name (idBourseName)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


CREATE TABLE IF NOT EXISTS contact (

  idContact INT NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  subject varchar(200) NOT NULL,
  message varchar(500) NOT NULL,
  PRIMARY KEY (idContact),
  CONSTRAINT fk_contact_client1
    FOREIGN KEY (idClient)
    REFERENCES client (idClient)
  CONSTRAINT fk_contact_conseiller1
    FOREIGN KEY (idCnll)
    REFERENCES conseiller (idCnll)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

	
CREATE TABLE IF NOT EXISTS contact_prive (
  id_cp int(11) NOT NULL AUTO_INCREMENT,
  objet varchar(100) NOT NULL,
  message varchar(600) NOT NULL,
  date_envoi datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  idClient int(11) NOT NULL,
  idCnll int(11) NOT NULL,
  PRIMARY KEY (id_cp),
  CONSTRAINT fk_contact_prive_client1
	FOREIGN KEY idClient (idClient),
	REFERENCES client (idClient)
  CONSTRAINT fk_contact_prive_conseiller1
	FOREIGN KEY idCnll (idCnll)
	REFERENCES conseiller (idCnll)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS articles (
	idArticles INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
	designation VARCHAR( 150 ) NOT NULL ,
	prix FLOAT( 100, 2 ) NOT NULL ,
	lienphoto VARCHAR( 150 ) NOT NULL ,
	PRIMARY KEY ( idArticles ),
	CONSTRAINT fk_articles_bourse_data
	  FOREIGN KEY (idBourseData),
	  REFERENCES bourse_data (idBourseData)
	CONSTRAINT fk_articles_porfeuille
	  FOREIGN KEY (idPortefeuille),
	  REFERENCES portefeuille (idPortefeuille)
	  ON DELETE NO ACTION
	  ON UPDATE NO ACTION 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


