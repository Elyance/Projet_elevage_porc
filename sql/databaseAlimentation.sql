CREATE TABLE races_porcs (
    id_race SERIAL PRIMARY KEY,
    nom_race VARCHAR(50) NOT NULL,
    description TEXT,
    besoins_nutritionnels TEXT,
    duree_engraissement_jours INT
);

CREATE TABLE aliments (
    id_aliment SERIAL PRIMARY KEY,
    nom_aliment VARCHAR(50) NOT NULL,
    prix_kg DECIMAL(10, 2) NOT NULL,
    stock_kg DECIMAL(10, 2) NOT NULL,
    apports_nutritionnels TEXT,
    contact_fournisseur VARCHAR(20),
    conso_journaliere_kg_par_porc DECIMAL(5, 2)  -- Consommation moyenne par porc/jour
);

CREATE TABLE porcs (
    id_porc SERIAL PRIMARY KEY,
    id_race INT REFERENCES races_porcs(id_race),
    date_naissance DATE,
    poids_actuel_kg DECIMAL(5, 2),
    date_mise_en_engraissement DATE,
    est_en_engraissement BOOLEAN DEFAULT TRUE
);

CREATE TABLE historique_alimentation (
    id_nourrissage SERIAL PRIMARY KEY,
    id_porc INT REFERENCES porcs(id_porc),
    id_aliment INT REFERENCES aliments(id_aliment),
    quantite_kg DECIMAL(5, 2) NOT NULL,
    date_nourrissage TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reapprovisionnement_aliments (
    id_reappro SERIAL PRIMARY KEY,
    id_aliment INT REFERENCES aliments(id_aliment),
    quantite_kg DECIMAL(10, 2) NOT NULL,
    date_reappro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cout_total DECIMAL(10, 2) NOT NULL
);

