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
CREATE TABLE bao_races_porcs (
    id_race SERIAL PRIMARY KEY,
    nom_race VARCHAR(50) NOT NULL,
    description TEXT,
    besoins_nutritionnels TEXT,
    duree_engraissement_jours INT
);

-- 2. TABLES ENCLOS-TRUIES-REPROD-PORTEES
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
    id_enclos INTEGER, -- where is that truie located
    id_race INTEGER, -- Added to track sow breed
    poids DECIMAL(10,6), -- Sow weight in kg
    date_entree DATE,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos),
    FOREIGN KEY (id_race) REFERENCES bao_races_porcs(id_race)
);

CREATE TABLE bao_insemination (
    id_insemination SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_insemination DATE,
    resultat VARCHAR(20) CHECK (resultat IN ('succes', 'echec', 'en cours')),
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

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
    id_cycle_reproduction INTEGER, -- generation of portee
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_cycle_reproduction) REFERENCES bao_cycle_reproduction(id_cycle_reproduction)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_race) REFERENCES bao_races_porcs(id_race)
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



-- 5. TABLES ALIMENTS
CREATE TABLE bao_aliments (
    id_aliment SERIAL PRIMARY KEY,
    nom_aliment VARCHAR(50) NOT NULL,
    prix_kg DECIMAL(10, 2) NOT NULL,
    stock_kg DECIMAL(10, 2) NOT NULL,
    apports_nutritionnels TEXT,
    contact_fournisseur VARCHAR(20),
    conso_journaliere_kg_par_porc DECIMAL(5, 2)
);

CREATE TABLE bao_alimentation_enclos (
    id_alimentation SERIAL PRIMARY KEY,
    id_enclos INT REFERENCES bao_enclos(id_enclos),
    date_alimentation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bao_details_alimentation (
    id_detail SERIAL PRIMARY KEY,
    id_alimentation INT REFERENCES bao_alimentation_enclos(id_alimentation),
    id_aliment INT REFERENCES bao_aliments(id_aliment),
    quantite_kg DECIMAL(5, 2) NOT NULL,
    id_enclos_portee INT REFERENCES bao_enclos_portee(id_enclos_portee)
);
ALTER TABLE bao_details_alimentation
ALTER COLUMN id_enclos_portee DROP NOT NULL,
ADD COLUMN id_enclos INT REFERENCES bao_enclos(id_enclos);

CREATE TABLE bao_reapprovisionnement_aliments (
    id_reappro SERIAL PRIMARY KEY,
    id_aliment INT REFERENCES bao_aliments(id_aliment),
    quantite_kg DECIMAL(10, 2) NOT NULL,
    date_reappro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cout_total DECIMAL(10, 2) NOT NULL
);


-- 6. CLIENTS
CREATE TABLE bao_client (
    id_client SERIAL PRIMARY KEY,
    nom_client VARCHAR(50),
    type_profil VARCHAR(20) CHECK (type_profil IN ('particulier', 'entreprise')),
    adresse VARCHAR(100),
    contact_telephone VARCHAR(20),
    contact_email VARCHAR(50)
);

-- 7. EMPLOYES
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
    id_utilisateur INTEGER UNIQUE, -- an emp is a user
    FOREIGN KEY (id_employe_poste) REFERENCES bao_employe_poste(id_employe_poste)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_utilisateur) REFERENCES bao_utilisateur(id_utilisateur)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);
----------- 7a/ GESTION SALAIRE EMPLOYÉ
CREATE TABLE bao_salaire (
    id_salaire SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_salaire DATE, -- date de paiement du salaire
    montant DECIMAL(10,2), -- montant du salaire
    statut VARCHAR(20),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

----------- 7b/ GESTION PRESENCE EMPLOYÉ
CREATE TABLE bao_presence (
    id_presence SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_presence DATE,
    statut VARCHAR(20) CHECK (statut IN ('present', 'absent')),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

----------- 7c/ GESTION CONGES EMPLOYÉ
CREATE TABLE bao_conge (
    id_conge SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_debut DATE, -- date de debut du conge
    date_fin DATE, -- date de fin du conge
    motif VARCHAR(100), -- motif du conge
    statut VARCHAR(20), -- statut du conge
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

-- 8. TASK
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
    statut VARCHAR(20) CHECK (statut IN ('en cours', 'terminee')), -- statut de la tache
    precision TEXT, -- details sur la tache
    FOREIGN KEY (id_tache) REFERENCES bao_tache(id_tache),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

-- 9. TABLES HEALTH EVENTS
CREATE TABLE bao_sante_type_evenement (
    id_type_evenement SERIAL PRIMARY KEY,
    nom_type_evenement VARCHAR(50),
    prix DECIMAL(10,2)
);

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
    male_deces INTEGER, -- nombre de porc decedes dans l'enclos
    female_deces INTEGER, -- nombre de porc decedes dans l'enclos
    date_deces DATE,
    cause_deces TEXT,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
);

----------- 10/ GESTION MALADIE -----------
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
    id_maladie INTEGER, -- used to obtain the list of symptoms
    id_enclos_portee INTEGER, -- Reference to specific litter enclosure
    id_enclos_portee_original INTEGER, -- Original litter enclosure reference (e.g., before movement)
    nombre_males_infectes INTEGER, -- Number of infected males
    nombre_femelles_infectes INTEGER, -- Number of infected females
    date_apparition DATE,
    date_diagnostic DATE,
    desc_traitement TEXT, -- Description of the prescribed treatment for the disease
    statut VARCHAR(30) CHECK (statut IN ('signale', 'en quarantaine', 'en traitement', 'reussi', 'echec')), -- Status of the diagnostic
    prix_traitement DECIMAL(10,2),
    FOREIGN KEY (id_maladie) REFERENCES bao_maladie(id_maladie),
    FOREIGN KEY (id_enclos_portee) REFERENCES bao_enclos_portee(id_enclos_portee),
    FOREIGN KEY (id_enclos_portee_original) REFERENCES bao_enclos_portee(id_enclos_portee)
);


CREATE TABLE bao_commande (
    id_commande SERIAL PRIMARY KEY,
    id_client INTEGER,
    id_enclos_portee INTEGER, -- enclos d'origine des porcs
    quantite INTEGER, -- nombre de porcs commandés
    date_commande DATE, -- date de la commande
    adresse_livraison VARCHAR(100),
    date_livraison DATE, -- peut être NULL au début
    statut_livraison VARCHAR(20) CHECK (statut_livraison IN ('en attente', 'en cours', 'livre', 'annule')), -- statut de livraison
    nomClient VARCHAR(60), -- nom du client (stocké en plus de l'id_client)
    id_race INTEGER, -- race des porcs commandés

    -- Clés étrangères
    FOREIGN KEY (id_client) REFERENCES bao_client(id_client),
    FOREIGN KEY (id_enclos_portee) REFERENCES bao_enclos_portee(id_enclos_portee),
    FOREIGN KEY (id_race) REFERENCES races_porcs(id_race)
);



CREATE TABLE bao_prix_vente_porc (
    id SERIAL PRIMARY KEY,
    id_race INTEGER,
    prix_unitaire DECIMAL(10,2),

    -- Clé étrangère vers races_porcs
    FOREIGN KEY (id_race) REFERENCES races_porcs(id_race)
);

INSERT INTO bao_prix_vente_porc(id_race,prix_unitaire) VALUES (1,1050000), (2,1200000), (3,1300000);



-- DONNEES
-- Insert user roles and users
INSERT INTO bao_utilisateur_role (nom_role) VALUES ('admin'), ('emp');
INSERT INTO bao_utilisateur (nom_utilisateur, mot_de_passe, id_utilisateur_role)
VALUES ('admin', 'admin', 1), ('emp', 'emp', 2);

INSERT INTO bao_sante_type_evenement(nom_type_evenement, prix)
VALUES ('Vaccination', 50.00),
       ('Consultation vétérinaire', 100.00),
       ('Insemination', 75.00);

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
('Quarantaine', 0, 12, 0.50, 50.00, 5.00); 
('Porcelet', 0, 60, 1.5, 20.0, 0.5),
('Jeune', 61, 120, 20.1, 50.0, 1.0),
('Engraissement', 121, 180, 50.1, 100.0, 1.5),
('Adulte', 181, 240, 100.1, 150.0, 2.0),
('Reproducteur', 241, 365, 150.1, 250.0, 2.5);-- 1 enclosure type for quarantine (added as per your list)

-- Insert enclosures (1 Truie + 3 Portee)
INSERT INTO bao_enclos (enclos_type, surface)
VALUES 
(1, 20),  -- Enclos 1: Truie type
(2, 15),  -- Enclos 2: Portee type
(2, 15),  -- Enclos 3: Portee type
(2, 15),  -- Enclos 4: Portee type
(3, 15),  -- Enclos 4: Portee type
(3, 15);  -- Enclos 4: Portee type


-- Insertion des races de porcs
INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES
('Large White', 'Race blanche très répandue, croissance rapide', 'Besoin élevé en protéines (16-18%)', 180),
('Landrace', 'Race blanche allongée, bonne qualité de viande', 'Nécessite des acides aminés équilibrés', 190),
('Duroc', 'Race rouge, viande persillée de qualité', 'Alimentation riche en énergie', 210),
('Piétrain', 'Race musclée, rendement carcasse élevé', 'Attention au stress alimentaire', 170),
('Gascon', 'Race rustique locale', 'Adaptée au pâturage', 240);

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
(4, NULL, 0, 0.0, 'non possible',0), -- Enclos 4 initialized with no litter
(5, NULL, 0, 0.0, 'non possible',0), -- Enclos 3 initialized with no litter
(6, NULL, 0, 0.0, 'non possible',0); -- Enclos 4 initialized with no litter

-- Insertion des aliments
INSERT INTO aliments (nom_aliment, prix_kg, stock_kg, apports_nutritionnels, contact_fournisseur, conso_journaliere_kg_par_porc) VALUES
('Maïs grain', 0.35, 500.00, 'Energie: 3300 kcal/kg, Protéines: 8%', '0601020304', 0.8),
('Tourteau de soja', 0.55, 300.00, 'Protéines: 45%, Lysine: 2.8%', '0602030405', 0.3),
('Orge', 0.30, 400.00, 'Energie: 2800 kcal/kg, Fibres: 5%', '0603040506', 0.6),
('Son de blé', 0.25, 200.00, 'Fibres: 12%, Energie modérée', '0604050607', 0.4),
('Mélange complet', 0.60, 350.00, 'Equilibré: 16% protéines, vitamines', '0605060708', 1.0);
-- Insertion des réapprovisionnements
INSERT INTO reapprovisionnement_aliments (id_aliment, quantite_kg, date_reappro, cout_total) VALUES
(1, 200.00, '2023-09-15 14:00:00', 70.00),
(2, 150.00, '2023-09-20 11:30:00', 82.50),
(3, 100.00, '2023-09-25 10:00:00', 30.00),
(5, 80.00, '2023-09-28 16:45:00', 48.00);

-- Insert into bao_symptome
INSERT INTO bao_symptome (nom_symptome, description) VALUES
('Fièvre', 'Elévation anormale de la température corporelle'),
('Diarrhée', 'Selles fréquentes et liquides'),
('Toux', 'Rales ou toux persistante'),
('Perte d appétit', 'Réduction ou absence de prise alimentaire'),
('Léthargie', 'Faiblesse ou manque d énergie');

-- Insert into bao_maladie
INSERT INTO bao_maladie (nom_maladie, description, dangerosite) VALUES
('Grippe Porcine', 'Infection respiratoire virale chez les porcs', 'moderee'),
('Dysenterie Porcine', 'Infection bactérienne causant des diarrhées sévères', 'elevee'),
('Peste Porcine', 'Maladie virale hautement contagieuse et mortelle', 'elevee'),
('Anémie Infectieuse', 'Affection causant une anémie due à un parasite', 'faible');

-- Insert into bao_maladie_symptome
INSERT INTO bao_maladie_symptome (id_maladie, id_symptome) VALUES
(1, 1), -- Grippe Porcine -> Fièvre
(1, 3), -- Grippe Porcine -> Toux
(2, 2), -- Dysenterie Porcine -> Diarrhée
(2, 4), -- Dysenterie Porcine -> Perte d'appétit
(3, 1), -- Peste Porcine -> Fièvre
(3, 2), -- Peste Porcine -> Diarrhée
(3, 5), -- Peste Porcine -> Léthargie
(4, 4), -- Anémie Infectieuse -> Perte d'appétit
(4, 5); -- Anémie Infectieuse -> Léthargie

INSERT INTO bao_diagnostic (
    id_diagnostic,
    id_maladie,
    id_enclos_portee,
    id_enclos_portee_original,
    nombre_males_infectes,
    nombre_femelles_infectes,
    date_apparition,
    date_diagnostic,
    desc_traitement,
    statut,
    prix_traitement
) VALUES (
    1,
    1,
    3,
    3,
    2,
    2,
    '2025-07-07',
    '2025-07-08',
    'sida be',
    'signale',
    50.00
);


-- Insertion historique d'alimentation
INSERT INTO historique_alimentation (id_enclos, id_aliment, quantite_kg, id_enclos_portee) VALUES
(1, 1, 25.0, 1),
(1, 2, 10.0, 1),
(1, 3, 30.0, 2),
(2, 5, 28.0, 3),
(2, 1, 20.0, 4),
(5, 4, 15.0, 5);
