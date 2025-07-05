-- Connexion a la base PostgreSQL (dans psql)
-- CREATE DATABASE doit etre lance en dehors de \c
\c postgres;
DROP DATABASE gestion_porc;
CREATE DATABASE gestion_porc;
\c gestion_porc;

-- 1. TABLES UTILISATEURS
CREATE TABLE bao_utilisateur_role (
    id_utilisateur_role SERIAL PRIMARY KEY,
    nom_role VARCHAR(30) NOT NULL
);

CREATE TABLE bao_utilisateur (
    id_utilisateur SERIAL PRIMARY KEY,
    id_utilisateur_role INTEGER,
    nom_utilisateur VARCHAR(50) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_utilisateur_role) REFERENCES bao_utilisateur_role(id_utilisateur_role)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

INSERT INTO bao_utilisateur_role (nom_role) VALUES ('admin'), ('emp');
INSERT INTO bao_utilisateur (nom_utilisateur, mot_de_passe, id_utilisateur_role)
VALUES ('admin', 'admin', 1), ('emp', 'emp', 2);

-- 2. TABLES ENCLOS ET TRUIES
CREATE TABLE bao_enclos_type (
    id_enclos_type SERIAL PRIMARY KEY,
    nom_enclos_type VARCHAR(50) NOT NULL
);

CREATE TABLE bao_enclos (
    id_enclos SERIAL PRIMARY KEY,
    enclos_type INTEGER,
    stockage INTEGER,
    FOREIGN KEY (enclos_type) REFERENCES bao_enclos_type(id_enclos_type)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

CREATE TABLE bao_truie (
    id_truie SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    poids NUMERIC(10,6),
    date_entree DATE,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

-- 3. TABLE INSEMINATION (obligatoire pour cycle reproduction)
CREATE TABLE bao_insemination (
    id_insemination SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_insemination DATE,
    resultat VARCHAR(20) CHECK (resultat IN ('succes', 'echec', 'en cours')),
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

-- 4. TABLES REPRODUCTION
CREATE TABLE bao_cycle_reproduction (
    id_cycle_reproduction SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_debut_cycle DATE,
    date_fin_cycle DATE,
    nombre_portee INTEGER,
    id_insemination INTEGER,
    etat VARCHAR(20) CHECK (etat IN ('en cours', 'termine')),
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_insemination) REFERENCES bao_insemination(id_insemination)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);
ALTER TABLE bao_cycle_reproduction ADD COLUMN nombre_males INTEGER;
ALTER TABLE bao_cycle_reproduction ADD COLUMN nombre_femelles INTEGER;
ALTER TABLE bao_cycle_reproduction DROP COLUMN nombre_portee;

CREATE TABLE races_porcs (
    id_race SERIAL PRIMARY KEY,
    nom_race VARCHAR(50) NOT NULL,
    description TEXT,
    besoins_nutritionnels TEXT,
    duree_engraissement_jours INT
);


CREATE TABLE bao_type_porc(
    id_type_porc SERIAL PRIMARY Key,
    nom_type VARCHAR(50),
    age_min integer,
    age_max integer,
    poids_min decimal(10,2),
    poids_max decimal(10,2),
    espace_requis decimal(10,2)
);

CREATE TABLE bao_enclos (
    id_enclos SERIAL PRIMARY KEY,
    enclos_type INTEGER,
    stockage INTEGER, -- nombre de porc max contenable dans l'enclos
    FOREIGN KEY (enclos_type) REFERENCES bao_type_porc(id_type_porc)
);

CREATE TABLE bao_truie (
    id_truie SERIAL PRIMARY KEY,
    id_enclos INTEGER, -- enclos where the truie is located
    poids DECIMAL(10,6), -- poids de la truie (Kg)
    date_entree DATE,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
);

ALTER TABLE bao_truie ADD COLUMN id_race INT REFERENCES races_porcs(id_race);

CREATE TABLE bao_portee (
    id_portee SERIAL PRIMARY KEY,
    id_truie INTEGER, -- truie qui a donne naissance a la portee
    nombre_porcs INTEGER, -- nombre de porc dans la portee
    date_naissance DATE, -- date de naissance de la portee
id_cycle_reproduction INTEGER,
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_cycle_reproduction) REFERENCES bao_cycle_reproduction(id_cycle_reproduction)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED    
);

ALTER TABLE bao_portee ADD COLUMN id_race INT REFERENCES races_porcs(id_race);
ALTER TABLE bao_portee ADD COLUMN nombre_males INTEGER;
ALTER TABLE bao_portee ADD COLUMN nombre_femelles INTEGER;
ALTER TABLE bao_portee DROP COLUMN nombre_porcs;

-- pour gerer les deplacements/ventes de portee (fusion/mix entre plusioeurs portees) (historique  de déplacement)
-- (sinon il sera dur de gerer les plusieurs portees dans diff enclos sans cette table)
CREATE TABLE bao_enclos_portee (
    id_enclos_portee SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    id_portee INTEGER,
    quantite_portee INTEGER, -- quantite de porc de la portee dans cet enclos
    poids_estimation DECIMAL(10,6), -- estimation du poids/porc dans l'enclos (Kg) (moyenne)
    nombre_jour_ecoule INTEGER,
    statut_vente VARCHAR(20) CHECK (statut_vente IN ('possible', 'non possible')),
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos),
    FOREIGN KEY (id_portee) REFERENCES bao_portee(id_portee)
);
ALTER TABLE bao_enclos_portee ADD COLUMN quantite_males INTEGER;
ALTER TABLE bao_enclos_portee ADD COLUMN quantite_femelles INTEGER;
ALTER TABLE bao_enclos_portee DROP COLUMN quantite_portee;

-- Historique de déplacement des truies dans les enclos
CREATE TABLE bao_enclos_truie (
    id_enclos_truie SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    id_truie INTEGER,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos),
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
);

CREATE TABLE aliments (
    id_aliment SERIAL PRIMARY KEY,
    nom_aliment VARCHAR(50) NOT NULL,
    prix_kg DECIMAL(10, 2) NOT NULL,
    stock_kg DECIMAL(10, 2) NOT NULL,
    apports_nutritionnels TEXT,
    contact_fournisseur VARCHAR(20),
    conso_journaliere_kg_par_porc DECIMAL(5, 2)
);


CREATE TABLE alimentation_enclos (
    id_alimentation SERIAL PRIMARY KEY,
    id_enclos INT REFERENCES bao_enclos(id_enclos),
    date_alimentation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE details_alimentation (
    id_detail SERIAL PRIMARY KEY,
    id_alimentation INT REFERENCES alimentation_enclos(id_alimentation),
    id_aliment INT REFERENCES aliments(id_aliment),
    quantite_kg DECIMAL(5, 2) NOT NULL,
    id_enclos_portee INT REFERENCES bao_enclos_portee(id_enclos_portee)
);

DROP TABLE IF EXISTS historique_alimentation;
DROP TABLE IF EXISTS porcs;

CREATE TABLE reapprovisionnement_aliments (
    id_reappro SERIAL PRIMARY KEY,
    id_aliment INT REFERENCES aliments(id_aliment),
    quantite_kg DECIMAL(10, 2) NOT NULL,
    date_reappro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cout_total DECIMAL(10, 2) NOT NULL
);


-- 5. CLIENTS
CREATE TABLE bao_client (
    id_client SERIAL PRIMARY KEY,
    nom_client VARCHAR(50),
    type_profil VARCHAR(20) CHECK (type_profil IN ('particulier', 'entreprise')),
    adresse VARCHAR(100),
    contact_telephone VARCHAR(20),
    contact_email VARCHAR(50)
);

-- 6. EMPLOYES
CREATE TABLE bao_employe_poste (
    id_employe_poste SERIAL PRIMARY KEY,
    nom_poste VARCHAR(100),
    salaire_base NUMERIC(10,2)
);

CREATE TABLE bao_employe (
    id_employe SERIAL PRIMARY KEY,
    nom_employe VARCHAR(50),
    prenom_employe VARCHAR(50),
    id_employe_poste INTEGER,
    adresse VARCHAR(100),
    contact_telephone VARCHAR(20),
    date_recrutement DATE,
    date_retirer DATE,
    statut VARCHAR(20) CHECK (statut IN ('actif', 'retraiter', 'congedier')),
    FOREIGN KEY (id_employe_poste) REFERENCES bao_employe_poste(id_employe_poste)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

-- DONNEES
INSERT INTO bao_enclos_type (nom_enclos_type) VALUES ('Truie'), ('Portee'), ('Quarantaine');

INSERT INTO bao_enclos (enclos_type, stockage) VALUES
(1, 10), (2, 20), (3, 5);

INSERT INTO bao_truie (id_enclos, poids, date_entree) VALUES
(1, 150.500, '2025-06-01'),
(1, 145.750, '2025-06-05');

INSERT INTO bao_employe_poste (nom_poste, salaire_base) VALUES
('Technicien reproduction', 1200),
('Technicien alimentation', 1100);

INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut)
VALUES
('Rakoto', 'Jean', 1, 'Antananarivo', '0341234567', '2024-01-15', 'actif'),
('Ranaivo', 'Marie', 2, 'Toamasina', '0347654321', '2024-02-10', 'actif');

INSERT INTO bao_client (nom_client, type_profil, adresse, contact_telephone, contact_email) VALUES
('AgriCorp', 'entreprise', 'Tamatave', '0339876543', 'contact@agricorp.com'),
('Rabe', 'particulier', 'Fianarantsoa', '0341112233', 'rabe@email.com');
