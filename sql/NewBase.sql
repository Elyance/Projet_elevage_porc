-- Connect to PostgreSQL and create/drop database
\c postgres;
DROP DATABASE IF EXISTS gestion_porc;
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

-- Insert user roles and users
INSERT INTO bao_utilisateur_role (nom_role) VALUES ('admin'), ('emp');
INSERT INTO bao_utilisateur (nom_utilisateur, mot_de_passe, id_utilisateur_role)
VALUES ('admin', 'admin', 1), ('emp', 'emp', 2);

-- 2. TABLES FOR PIG MANAGEMENT
-- Table for pig enclosure types
CREATE TABLE bao_type_porc (
    id_type_porc SERIAL PRIMARY KEY,
    nom_type VARCHAR(50),
    age_min INTEGER,
    age_max INTEGER,
    poids_min DECIMAL(10,2),
    poids_max DECIMAL(10,2),
    espace_requis DECIMAL(10,2)
);

-- Table for pig breeds
CREATE TABLE races_porcs (
    id_race SERIAL PRIMARY KEY,
    nom_race VARCHAR(50) NOT NULL,
    description TEXT,
    besoins_nutritionnels TEXT,
    duree_engraissement_jours INT
);
-- 2. TABLES ENCLOS ET TRUIES
CREATE TABLE bao_enclos_type (
    id_enclos_type SERIAL PRIMARY KEY,
    nom_enclos_type VARCHAR(50) NOT NULL
);

-- Table for enclosures
CREATE TABLE bao_enclos (
    id_enclos SERIAL PRIMARY KEY,
    enclos_type INTEGER,
    surface INTEGER, -- Renamed from stockage to reflect actual meaning (surface area)
    FOREIGN KEY (enclos_type) REFERENCES bao_type_porc(id_type_porc)
);

-- Table for sows
CREATE TABLE bao_truie (
    id_truie SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    id_race INTEGER, -- Added to track sow breed
    poids DECIMAL(10,6), -- Sow weight in kg
    date_entree DATE,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos),
    FOREIGN KEY (id_race) REFERENCES races_porcs(id_race)
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
    nombre_males INTEGER,
    nombre_femelles INTEGER,
    id_insemination INTEGER,
    etat VARCHAR(20) CHECK (etat IN ('en cours', 'termine')),
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_insemination) REFERENCES bao_insemination(id_insemination)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

-- Table for litters
CREATE TABLE bao_portee (
    id_portee SERIAL PRIMARY KEY,
    id_truie INTEGER, -- Sow that gave birth
    id_race INTEGER, -- Added to track litter breed
    nombre_males INTEGER, -- Number of males in the litter
    nombre_femelles INTEGER, -- Number of females in the litter
    date_naissance DATE, -- Birth date of the litter
    id_cycle_reproduction INTEGER,
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_cycle_reproduction) REFERENCES bao_cycle_reproduction(id_cycle_reproduction)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_race) REFERENCES races_porcs(id_race)
);

-- Table for managing litters in enclosures
CREATE TABLE bao_enclos_portee (
    id_enclos_portee SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    id_portee INTEGER,
    quantite_total INTEGER, -- Total number of pigs from the litter in this enclosure
    poids_estimation DECIMAL(10,6), -- Estimated average weight per pig in kg
    nombre_jour_ecoule INTEGER,
    statut_vente VARCHAR(20) CHECK (statut_vente IN ('possible', 'non possible')),
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos),
    FOREIGN KEY (id_portee) REFERENCES bao_portee(id_portee)
);


-- Table for sow weighing
CREATE TABLE bao_pesee_truie (
    id_pesee_truie SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_pesee DATE,
    poids DECIMAL(10,6), -- Weight of the sow in kg
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
);

-- Table for litter weighing in enclosures
CREATE TABLE bao_pesee_enclos_portee (
    id_pesee_enclos_portee SERIAL PRIMARY KEY,
    id_enclos_portee INTEGER,
    date_pesee DATE,
    poids_total DECIMAL(10,6), -- Total weight of the litter in the enclosure in kg
    FOREIGN KEY (id_enclos_portee) REFERENCES bao_enclos_portee(id_enclos_portee)
);

-- Table for tracking movement of litters between enclosures
CREATE TABLE bao_mouvement_enclos_portee (
    id_mouvement_enclos_portee SERIAL PRIMARY KEY,
    id_enclos_portee_source INTEGER,
    id_enclos_portee_destination INTEGER,
    quantite_males_deplaces INTEGER,
    quantite_femelles_deplaces INTEGER,
    date_mouvement DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_enclos_portee_source) REFERENCES bao_enclos_portee(id_enclos_portee),
    FOREIGN KEY (id_enclos_portee_destination) REFERENCES bao_enclos_portee(id_enclos_portee)
);

-- Table for disease records affecting sows
CREATE TABLE bao_maladie_truie (
    id_maladie_truie SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_diagnostic DATE,
    description TEXT,
    traitement TEXT,
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
);

-- Table for disease records affecting enclosures (litters)
CREATE TABLE bao_maladie_enclos (
    id_maladie_enclos SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    date_diagnostic DATE,
    description TEXT,
    traitement TEXT,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
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
----------- 5a/ GESTION SALAIRE EMPLOYÉ
CREATE TABLE bao_salaire (
    id_salaire SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_salaire DATE, -- date de paiement du salaire
    montant DECIMAL(10,2), -- montant du salaire
    statut VARCHAR(20),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

----------- 5b/ GESTION PRESENCE EMPLOYÉ
CREATE TABLE bao_presence (
    id_presence SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_presence DATE,
    statut VARCHAR(20) CHECK (statut IN ('present', 'absent')),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

----------- 5c/ GESTION CONGES EMPLOYÉ
CREATE TABLE bao_conge (
    id_conge SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_debut DATE, -- date de debut du conge
    date_fin DATE, -- date de fin du conge
    motif VARCHAR(100), -- motif du conge
    statut VARCHAR(20), -- statut du conge
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

----------- 6/ GESTION TACHES EMPLOYÉ
CREATE TABLE bao_tache (
    id_tache SERIAL PRIMARY KEY,
    id_employe_poste INTEGER, -- les taches sont liees a un poste specifique
    nom_tache VARCHAR(100), -- titre de la tache
    description TEXT,
    FOREIGN KEY (id_employe_poste) REFERENCES bao_employe_poste(id_employe_poste)
);

CREATE TABLE bao_tache_employe (
    id_tache_employe SERIAL PRIMARY KEY,
    id_tache INTEGER,
    id_employe INTEGER,
    date_attribution DATE,
    date_echeance DATE,
    statut VARCHAR(20),
    FOREIGN KEY (id_tache) REFERENCES bao_tache(id_tache),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);
ALTER TABLE bao_tache_employe
ADD COLUMN precision TEXT;

CREATE TABLE bao_sante_type_evenement (
    id_type_evenement SERIAL PRIMARY KEY,
    nom_type_evenement VARCHAR(50),
    prix DECIMAL(10,2)
);

INSERT INTO bao_sante_type_evenement(nom_type_evenement, prix)
VALUES ('Vaccination', 50.00),
       ('Consultation vétérinaire', 100.00),
       ('Insemination', 75.00);

CREATE TABLE bao_sante_evenement (
    id_sante_evenement SERIAL PRIMARY KEY,
    id_type_evenement INTEGER,
    id_enclos INTEGER,
    date_evenement DATE,
    FOREIGN KEY (id_type_evenement) REFERENCES bao_sante_type_evenement(id_type_evenement),
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
);

CREATE TABLE bao_sante_calendrier (
    id_sante_calendrier SERIAL PRIMARY KEY,
    id_sante_evenement INTEGER,
    FOREIGN KEY (id_sante_evenement) REFERENCES bao_sante_evenement(id_sante_evenement)
);

CREATE TABLE bao_deces (
    id_deces SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    nombre_deces INTEGER, -- nombre de porc decedes dans l'enclos
    date_deces DATE,
    cause_deces TEXT,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
);

----------- 8/ GESTION MALADIE -----------
CREATE TABLE bao_symptome (
    id_symptome SERIAL PRIMARY KEY,
    nom_symptome VARCHAR(50),
    description TEXT
);

CREATE TABLE bao_maladie (
    id_maladie SERIAL PRIMARY KEY,
    nom_maladie VARCHAR(50),
    description TEXT,
    dangerosite VARCHAR(20) CHECK (dangerosite IN ('faible', 'moderee', 'elevee'))
);

CREATE TABLE bao_maladie_symptome (
    id_maladie INTEGER,
    id_symptome INTEGER,
    PRIMARY KEY (id_maladie, id_symptome),
    FOREIGN KEY (id_maladie) REFERENCES bao_maladie(id_maladie),
    FOREIGN KEY (id_symptome) REFERENCES bao_symptome(id_symptome)
);

CREATE TABLE bao_diagnostic (
    id_diagnostic SERIAL PRIMARY KEY,
    id_maladie INTEGER, -- sera utilise pour obtenir la liste des symptomes
    id_enclos INTEGER,
    nombre_infecte INTEGER, -- nombre de porc infecte dans l'enclos
    date_apparition DATE,
    date_diagnostic DATE,
    desc_traitement TEXT, -- description du traitement prescrit pour la maladie
    statut VARCHAR(30) CHECK (statut IN ('en quarantaine', 'en traitement', 'reussi', 'echec')), -- statut du diagnostic
    prix_traitement DECIMAL(10,2),
    FOREIGN KEY (id_maladie) REFERENCES bao_maladie(id_maladie),
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
);


-- DONNEES

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


-- Insert initial data

-- Insert enclosure types into bao_type_porc (replacing bao_enclos_type)
INSERT INTO bao_type_porc (nom_type, age_min, age_max, poids_min, poids_max, espace_requis)
VALUES 
('Truie', 12, 36, 100.00, 200.00, 10.00),  -- 1 enclosure type for sows
('Portee', 0, 12, 0.50, 50.00, 5.00),      -- 1 enclosure type for litters
('Quarantaine', 0, 12, 0.50, 50.00, 5.00); -- 1 enclosure type for quarantine (added as per your list)

-- Insert enclosures (1 Truie + 3 Portee)
INSERT INTO bao_enclos (enclos_type, surface)
VALUES 
(1, 20),  -- Enclos 1: Truie type
(2, 15),  -- Enclos 2: Portee type
(2, 15),  -- Enclos 3: Portee type
(2, 15);  -- Enclos 4: Portee type

-- Insert breeds
INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours)
VALUES ('Large White', 'Common pig breed', 'High protein', 180);

-- Insert sows
-- Insert enclos_portee (initialize all Portee enclosures and assign litters to Enclos 2)
INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, statut_vente,nombre_jour_ecoule)
VALUES 
(1, NULL, 1, 150.500, 'non possible',334),  -- Enclos 2 with Litter 1 (5 pigs)
(1, NULL, 1, 145.750, 'non possible',334);  -- Enclos 2 with Litter 2 (4 pigs)
INSERT INTO bao_truie (id_enclos, id_race, poids, date_entree)
VALUES 
(1, 1, 150.500, '2025-06-01'),  -- Truie 1
(1, 1, 145.750, '2025-06-05');  -- Truie 2

-- Insert reproduction cycles
INSERT INTO bao_cycle_reproduction (id_truie, date_debut_cycle, date_fin_cycle,nombre_males,nombre_femelles, etat)
VALUES 
(1, '2025-06-10', '2025-07-01',2,3, 'termine'),  -- Cycle for Truie 1
(2, '2025-06-12', '2025-07-03',2,2, 'termine'),  -- Cycle for Truie 2
(2, '2025-06-12', '2025-07-03',0,2, 'termine');  -- Cycle for Truie 2

-- Insert litters
INSERT INTO bao_portee (id_truie, id_race, nombre_males, nombre_femelles, date_naissance, id_cycle_reproduction)
VALUES 
(1, 1, 2, 3, '2025-07-01', 1),  -- Litter 1: 2 males, 3 females
(2, 1, 2, 2, '2025-07-03', 2),  -- Litter 2: 2 males, 2 females
(2, 1, 0, 2, '2025-07-03', 3);  -- Litter 2: 2 males, 2 females

-- Insert enclos_portee (initialize all Portee enclosures and assign litters to Enclos 2)
INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, statut_vente,nombre_jour_ecoule)
VALUES 
(2, 1, 5, 125.0, 'non possible',115),  -- Enclos 2 with Litter 1 (5 pigs)
(2, 2, 4, 125.0, 'non possible',336),  -- Enclos 2 with Litter 2 (4 pigs)
(2, 3, 2, 125.0, 'non possible',339),  -- Enclos 2 with Litter 2 (4 pigs)
(3, NULL, 0, 0.0, 'non possible',0), -- Enclos 3 initialized with no litter
(4, NULL, 0, 0.0, 'non possible',0); -- Enclos 4 initialized with no litter