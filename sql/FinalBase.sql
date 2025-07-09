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

-- ADDITIONAL TABLES THAT NEKENA ADDED
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

-- 12. Simulation Ioty + Raphael's budget
CREATE TABLE bao_commande (
    id_commande SERIAL PRIMARY KEY,
    id_client INTEGER,
    id_enclos_portee INTEGER, 
    quantite INTEGER, 
    date_commande DATE, -- date de la commande
    adresse_livraison VARCHAR(100),
    date_livraison DATE, -- peut être NULL au début
    statut_livraison VARCHAR(20) CHECK (statut_livraison IN ('en attente', 'en cours', 'livre', 'annule')), -- statut de livraison
    nomClient VARCHAR(60), -- nom du client (stocké en plus de l'id_client)
    id_race INTEGER, -- race des porcs commandés
    FOREIGN KEY (id_client) REFERENCES bao_client(id_client),
    FOREIGN KEY (id_enclos_portee) REFERENCES bao_enclos_portee(id_enclos_portee),
    FOREIGN KEY (id_race) REFERENCES bao_races_porcs(id_race)
);

CREATE TABLE bao_prix_vente_porc (
    id SERIAL PRIMARY KEY,
    id_race INTEGER,
    prix_unitaire DECIMAL(10,2),
    FOREIGN KEY (id_race) REFERENCES bao_races_porcs(id_race)
);

-- Views for budget management
CREATE OR REPLACE VIEW bao_view_recette AS
SELECT 
    c.id_commande,
    c.id_race,
    c.nomclient,
    c.date_livraison AS date_recette,
    c.quantite,
    pvp.prix_unitaire,
    c.quantite * pvp.prix_unitaire AS prix_total
FROM 
    bao_commande c
JOIN 
    bao_prix_vente_porc pvp ON c.id_race = pvp.id_race
WHERE 
    c.statut_livraison = 'livre';


CREATE OR REPLACE VIEW bao_view_depenses_totales AS
SELECT 
    'Achats' AS type_depense,
    ra.date_reappro::DATE AS date_depense,
    ra.cout_total AS montant
FROM 
    bao_reapprovisionnement_aliments ra
UNION
SELECT 
    'Salaire' AS type_depense,
    s.date_salaire AS date_depense,
    s.montant
FROM 
    bao_salaire s
WHERE 
    s.statut = 'paye'
UNION
SELECT 
    'Traitement' AS type_depense,
    d.date_diagnostic AS date_depense,
    d.prix_traitement AS montant
FROM 
    bao_diagnostic d
WHERE 
    d.prix_traitement IS NOT NULL;


CREATE OR REPLACE VIEW bao_view_budget AS
WITH Recettes AS (
    SELECT 
        EXTRACT(YEAR FROM date_recette) AS annee,
        EXTRACT(MONTH FROM date_recette) AS mois,
        SUM(prix_total) AS total_recette
    FROM bao_view_recette
    GROUP BY EXTRACT(YEAR FROM date_recette), EXTRACT(MONTH FROM date_recette)
),
Depenses AS (
    SELECT 
        EXTRACT(YEAR FROM date_depense) AS annee,
        EXTRACT(MONTH FROM date_depense) AS mois,
        SUM(montant) AS total_depense
    FROM bao_view_depenses_totales
    GROUP BY EXTRACT(YEAR FROM date_depense), EXTRACT(MONTH FROM date_depense)
)
SELECT 
    COALESCE(r.annee, d.annee) AS annee,
    COALESCE(r.mois, d.mois) AS mois,
    COALESCE(r.total_recette, 0) AS total_recette,
    COALESCE(d.total_depense, 0) AS total_depense,
    COALESCE(r.total_recette, 0) - COALESCE(d.total_depense, 0) AS budget
FROM Recettes r
FULL OUTER JOIN Depenses d
    ON r.annee = d.annee AND r.mois = d.mois
ORDER BY annee, mois;


CREATE OR REPLACE VIEW bao_view_budget_annuel AS
SELECT 
    annee,
    SUM(total_recette) AS total_recette,
    SUM(total_depense) AS total_depense,
    SUM(budget) AS budget
FROM bao_view_budget
GROUP BY annee
ORDER BY annee;