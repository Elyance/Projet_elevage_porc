-- Disable foreign key checks and drop existing tables
SET session_replication_role = replica;

DROP TABLE IF EXISTS bao_cycle_reproduction CASCADE;
DROP TABLE IF EXISTS bao_insemination CASCADE;
DROP TABLE IF EXISTS bao_diagnostic CASCADE;
DROP TABLE IF EXISTS bao_maladie_symptome CASCADE;
DROP TABLE IF EXISTS bao_maladie CASCADE;
DROP TABLE IF EXISTS bao_symptome CASCADE;
DROP TABLE IF EXISTS bao_deces CASCADE;
DROP TABLE IF EXISTS bao_sante_calendrier CASCADE;
DROP TABLE IF EXISTS bao_sante_evenement CASCADE;
DROP TABLE IF EXISTS bao_sante_type_evenement CASCADE;
DROP TABLE IF EXISTS bao_tache_employe CASCADE;
DROP TABLE IF EXISTS bao_tache CASCADE;
DROP TABLE IF EXISTS bao_conge CASCADE;
DROP TABLE IF EXISTS bao_presence CASCADE;
DROP TABLE IF EXISTS bao_salaire CASCADE;
DROP TABLE IF EXISTS bao_employe CASCADE;
DROP TABLE IF EXISTS bao_employe_poste CASCADE;
DROP TABLE IF EXISTS bao_stockage_mouvement CASCADE;
DROP TABLE IF EXISTS bao_aliment_type CASCADE;
DROP TABLE IF EXISTS bao_commande CASCADE;
DROP TABLE IF EXISTS bao_client CASCADE;
DROP TABLE IF EXISTS bao_enclos_portee CASCADE;
DROP TABLE IF EXISTS bao_enclos CASCADE;
DROP TABLE IF EXISTS bao_enclos_type CASCADE;
DROP TABLE IF EXISTS bao_portee CASCADE;
DROP TABLE IF EXISTS bao_truie CASCADE;
DROP TABLE IF EXISTS bao_utilisateur CASCADE;
DROP TABLE IF EXISTS bao_utilisateur_role CASCADE;

----------- 1/ LOGIN ET USERS -----------
CREATE TABLE bao_utilisateur_role (
    id_utilisateur_role SERIAL PRIMARY KEY,
    nom_role VARCHAR(30)
);

INSERT INTO bao_utilisateur_role(nom_role)
VALUES ('admin'), ('emp');

CREATE TABLE bao_utilisateur (
    id_utilisateur SERIAL PRIMARY KEY,
    id_utilisateur_role INTEGER,
    nom_utilisateur VARCHAR(50) UNIQUE,
    mot_de_passe VARCHAR(100),
    FOREIGN KEY (id_utilisateur_role) REFERENCES bao_utilisateur_role(id_utilisateur_role)
);

INSERT INTO bao_utilisateur(nom_utilisateur, mot_de_passe, id_utilisateur_role)
VALUES ('admin', 'admin', 1),
       ('emp', 'emp', 2);

------------- 2/ ENCLOS-PORCS
CREATE TABLE bao_enclos_type (
    id_enclos_type SERIAL PRIMARY KEY,
    nom_enclos_type VARCHAR(50)
);

INSERT INTO bao_enclos_type(nom_enclos_type)
VALUES ('Truie'), ('Portee'), ('Quarantaine');

CREATE TABLE bao_enclos (
    id_enclos SERIAL PRIMARY KEY,
    enclos_type INTEGER,
    stockage INTEGER, -- nombre de porc contenu dans l'enclos
    FOREIGN KEY (enclos_type) REFERENCES bao_enclos_type(id_enclos_type)
);

CREATE TABLE bao_truie (
    id_truie SERIAL PRIMARY KEY,
    id_enclos INTEGER, -- enclos where the truie is located
    poids DECIMAL(10,6), -- poids de la truie (Kg)
    date_entree DATE,
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos)
);

CREATE TABLE bao_portee (
    id_portee SERIAL PRIMARY KEY,
    id_truie INTEGER, -- truie qui a donne naissance a la portee
    nombre_porcs INTEGER, -- nombre de porc dans la portee
    date_naissance DATE, -- date de naissance de la portee
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
);

-- pour gerer les deplacement/vente de portee (fusion/mix entre plusioeurs portees)
-- (sinon il sera dur de gerer les plusieurs portees dans diff enclos sans cette table)
CREATE TABLE bao_enclos_portee (
    id_enclos_portee SERIAL PRIMARY KEY,
    id_enclos INTEGER,
    id_portee INTEGER,
    quantite_portee INTEGER, -- quantite de porc de la portee dans cet enclos
    poids_estimation DECIMAL(10,6), -- estimation du poids/porc dans l'enclos (Kg)
    nombre_jour_ecoule INTEGER,
    statut_vente VARCHAR(20) CHECK (statut_vente IN ('possible', 'non possible')),
    FOREIGN KEY (id_enclos) REFERENCES bao_enclos(id_enclos),
    FOREIGN KEY (id_portee) REFERENCES bao_portee(id_portee)
);

----------- 3/ ALIMENTATION -----------
CREATE TABLE bao_aliment_type (
    id_aliment_type SERIAL PRIMARY KEY,
    nom_aliment_type VARCHAR(50), -- type d'aliment, ex: aliment de croissance, aliment de finition, etc.
    prix DECIMAL(10,2) -- prix de l'aliment par Kg
);

-- a utiliser pour l'historique de stockage et le suivi du stockage
CREATE TABLE bao_stockage_mouvement (
    id_stockage SERIAL PRIMARY KEY,
    id_aliment_type INTEGER,
    quantite DECIMAL(10,2), -- quantite ajoutee/retiree en Kg
    date_mouvement DATE, -- date du mouvement de stockage
    type_mouvement VARCHAR(20) CHECK (type_mouvement IN ('ajout', 'retrait')), -- type de mouvement
    raison_mouvement VARCHAR(100), -- raison du mouvement, ex: achat, consommation truie/portee
    FOREIGN KEY (id_aliment_type) REFERENCES bao_aliment_type(id_aliment_type)
);

----------- 4/ COMMANDES CLIENTS -----------
CREATE TABLE bao_client (
    id_client SERIAL PRIMARY KEY,
    nom_client VARCHAR(50), -- pas besoin de prenom car le client peut etre une entreprise egalement
    type_profil VARCHAR(20) CHECK (type_profil IN ('particulier', 'entreprise')), -- type de profil du client
    adresse VARCHAR(100), -- adresse du client
    contact_telephone VARCHAR(20), -- contact telephone du client
    contact_email VARCHAR(50) -- contact email du client
);

CREATE TABLE bao_commande (
    id_commande SERIAL PRIMARY KEY,
    id_client INTEGER,
    id_enclos_portee INTEGER, -- enclos where on va prendre les porcs
    quantite INTEGER, -- nombre de porc commanded, egalement le nombre de porc to remove from l'enclos choisi
    date_commande DATE, -- date de la commande
    adresse_livraison VARCHAR(100),
    date_livraison DATE, -- date de la livraison, null au debut
    statut_livraison VARCHAR(20) CHECK (statut_livraison IN ('en attente', 'en cours', 'livré', 'annulé')), -- statut de la livraison
    FOREIGN KEY (id_client) REFERENCES bao_client(id_client),
    FOREIGN KEY (id_enclos_portee) REFERENCES bao_enclos_portee(id_enclos_portee)
);

----------- 5/ EMPLOYEE -----------
CREATE TABLE bao_employe_poste (
    id_employe_poste SERIAL PRIMARY KEY,
    nom_poste VARCHAR(100),
    salaire_base DECIMAL(10,2) -- salaire de base pour le poste/mois
);

INSERT INTO bao_employe_poste(nom_poste, salaire_base)
VALUES ('Technicien en reproduction', 1200), 
       ('Technicien en alimentation', 1100), 
       ('Technicien en santé animale', 1500),
       ('Agent entretien enclos', 1000),
       ('Agent clientèle', 1100),
       ('Agent administratif', 1300);

CREATE TABLE bao_employe(
    id_employe SERIAL PRIMARY KEY,
    nom_employe VARCHAR(50),
    prenom_employe VARCHAR(50),
    id_employe_poste INTEGER,
    adresse VARCHAR(100),
    contact_telephone VARCHAR(20),
    date_recrutement DATE, -- date lorsque l'emp est entree dans l'entreprise
    date_retirer DATE, -- date lorsque l'emp s'est fait congedier/retirer, null au tout debut
    statut VARCHAR(20) CHECK (statut IN ('actif', 'retraiter', 'congedier')),
    FOREIGN KEY (id_employe_poste) REFERENCES bao_employe_poste(id_employe_poste)
);

----------- 5a/ GESTION SALAIRE EMPLOYÉ
CREATE TABLE bao_salaire (
    id_salaire SERIAL PRIMARY KEY,
    id_employe INTEGER,
    date_salaire DATE, -- date de paiement du salaire
    montant DECIMAL(10,2), -- montant du salaire
    statut VARCHAR(20) CHECK (statut IN ('payé', 'non payé')),
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
    statut VARCHAR(20) CHECK (statut IN ('demande', 'approuve', 'refuse')), -- statut du conge
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
    statut VARCHAR(20) CHECK (statut IN ('non commencer', 'terminee')),
    FOREIGN KEY (id_tache) REFERENCES bao_tache(id_tache),
    FOREIGN KEY (id_employe) REFERENCES bao_employe(id_employe)
);

----------- 7/ SANTE ANIMALE -----------
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

------------- 9/ GESTION REPRODUCTION -----------
CREATE TABLE bao_insemination (
    id_insemination SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_insemination DATE,
    resultat VARCHAR(20) CHECK (resultat IN ('succes', 'echec')),
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
);

CREATE TABLE bao_cycle_reproduction (
    id_cycle_reproduction SERIAL PRIMARY KEY,
    id_truie INTEGER,
    date_debut_cycle DATE,
    date_fin_cycle DATE,
    nombre_portee INTEGER, -- pour prevision et cycles precedents
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
);

-- Re-enable foreign key checks
SET session_replication_role = DEFAULT;