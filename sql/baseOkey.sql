-- Connexion à la base PostgreSQL
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

-- 3. TABLE INSEMINATION
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

CREATE TABLE bao_portee (
    id_portee SERIAL PRIMARY KEY,
    id_truie INTEGER,
    nombre_porcs INTEGER,
    date_naissance DATE,
    id_cycle_reproduction INTEGER,
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_cycle_reproduction) REFERENCES bao_cycle_reproduction(id_cycle_reproduction)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
);

CREATE TABLE bao_enclos_portee (
    id_enclos_portee SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    id_portee INTEGER,
    quantite_portee INTEGER,
    poids_estimation NUMERIC(10,6),
    nombre_jour_ecoule INTEGER,
    statut_vente VARCHAR(20) CHECK (statut_vente IN ('possible', 'non possible')),
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_portee) REFERENCES bao_portee(id_portee)
        ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED
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

-- 7. SALAIRES
CREATE TABLE bao_salaire (
    id_salaire SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_salaire DATE,
    montant NUMERIC(10,2),
    statut VARCHAR(20) CHECK (statut IN ('payé', 'non payé')),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
        ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED
);

-- 8. PRESENCES
CREATE TABLE bao_presence (
    id_presence SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_presence DATE,
    statut VARCHAR(20) CHECK (statut IN ('present', 'absent')),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
        ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED
);

-- 9. CONGES
CREATE TABLE bao_conge (
    id_conge SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_debut DATE,
    date_fin DATE,
    motif VARCHAR(100),
    statut VARCHAR(20) CHECK (statut IN ('demande', 'approuve', 'refuse')),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
        ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED
);

-- 10. TACHES
CREATE TABLE bao_tache (
    id_tache SERIAL PRIMARY KEY,
    id_employe_poste INTEGER,
    nom_tache VARCHAR(100),
    description TEXT,
    FOREIGN KEY (id_employe_poste) REFERENCES bao_employe_poste(id_employe_poste)
        ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED
);

CREATE TABLE bao_tache_employe (
    id_tache_employe SERIAL PRIMARY KEY,
    id_tache INTEGER,
    id_employe INTEGER,
    date_attribution DATE,
    statut VARCHAR(20) CHECK (statut IN ('non commencer', 'termine')),
    FOREIGN KEY (id_tache) REFERENCES bao_tache(id_tache)
        ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
        ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED
);

-- DONNEES DE TEST
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

INSERT INTO bao_salaire (id_employe, date_salaire, montant, statut) VALUES
(1, '2025-06-30', 1200.00, 'payé'),
(2, '2025-06-30', 1100.00, 'payé'),
(1, '2025-05-31', 1200.00, 'payé'),
(2, '2025-05-31', 1100.00, 'payé');

INSERT INTO bao_presence (id_employe, date_presence, statut) VALUES
(1, '2025-07-01', 'present'),
(2, '2025-07-01', 'absent'),
(1, '2025-07-02', 'present'),
(2, '2025-07-02', 'present');

INSERT INTO bao_conge (id_employe, date_debut, date_fin, motif, statut) VALUES
(2, '2025-07-10', '2025-07-15', 'Congé maladie', 'approuve'),
(1, '2025-08-01', '2025-08-10', 'Vacances annuelles', 'demande');

INSERT INTO bao_tache (id_employe_poste, nom_tache, description) VALUES
(1, 'Surveiller l-ovulation', 'Suivre les périodes d-ovulation des truies.'),
(2, 'Distribution aliment', 'Assurer la distribution quotidienne d-aliments.');

INSERT INTO bao_tache_employe (id_tache, id_employe, date_attribution, statut) VALUES
(1, 1, '2025-07-01', 'termine'),
(2, 2, '2025-07-01', 'non commencer');
