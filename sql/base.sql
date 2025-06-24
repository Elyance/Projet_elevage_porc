CREATE TABLE CATEGORIE (
  id int(11) NOT NULL AUTO_INCREMENT,
  libele varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE DEPARTEMENT (
  id int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE EMPLOYER (
  id int(11) NOT NULL AUTO_INCREMENT,
  idD int(11) DEFAULT NULL,
  nom varchar(100) DEFAULT NULL,
  mdp varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE NATURE (
  id int(11) NOT NULL AUTO_INCREMENT,
  idC int(11) DEFAULT NULL,
  libele varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE TYPE (
  id int(11) NOT NULL AUTO_INCREMENT,
  idC int(11) DEFAULT NULL,
  libele varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE Budget( 
  id INT PRIMARY KEY AUTO_INCREMENT,
  idDep INT,
  idT INT,
  idN INT,
  prevision DECIMAL(10,2),
  realisation DECIMAL(10,2),
  valider BOOLEAN
);

CREATE TABLE client (
  id_client INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  telephone VARCHAR(20),
  id_categorie INT
);



CREATE TABLE categorie_client (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(50) NOT NULL
);

CREATE TABLE categorie_produit (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(50) NOT NULL
);

CREATE TABLE produit (
    id_produit INT PRIMARY KEY AUTO_INCREMENT,
    nom_produit VARCHAR(100) NOT NULL,
    marque VARCHAR(50),
    prix DECIMAL(10,2),
    id_categorie INT
);

CREATE TABLE liste_action (
    id_action INT PRIMARY KEY AUTO_INCREMENT,
    nom_action VARCHAR(100) NOT NULL
);


CREATE TABLE liste_reaction (
    id_reaction INT PRIMARY KEY AUTO_INCREMENT,
    nom_reaction VARCHAR(100) NOT NULL,
    type_reaction VARCHAR(10) CHECK (type_reaction IN ('positive', 'negative', 'neutre'))
);

CREATE TABLE action_reaction (
    id_action INT,
    id_reaction INT,
    commentaire VARCHAR(255)
);

CREATE TABLE Ventes(
    id_ventes INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT,
    id_produit INT,
    quantite INT,
    Valeur DECIMAL(10,2),
    mois INT,
    annee INT
);

