ALTER TABLE bao_commande
    ADD COLUMN nomClient VARCHAR(60);


ALTER TABLE bao_commande
ADD COLUMN id_race INTEGER;

ALTER TABLE bao_commande
ADD CONSTRAINT fk_commande_race
FOREIGN KEY (id_race)
REFERENCES races_porcs(id_race);

CREATE TABLE bao_prix_vente_porc(
    id SERIAL PRIMARY KEY,
    idRace INTEGER,
    prix_unitaire DECIMAL(10,2)
);

-- Renommer la colonne idRace en id_race
ALTER TABLE bao_prix_vente_porc
RENAME COLUMN idRace TO id_race;

-- Ajouter la clé étrangère vers races_porcs
ALTER TABLE bao_prix_vente_porc
ADD CONSTRAINT fk_prix_vente_race
FOREIGN KEY (id_race)
REFERENCES races_porcs(id_race);
