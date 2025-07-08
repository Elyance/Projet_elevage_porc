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
    FOREIGN KEY (id_truie) REFERENCES bao_truie(id_truie)
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
