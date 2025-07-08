drop DATABASE IF EXISTS gestion_porc;
create DATABASE gestion_porc;
\c gestion_porc;

CREATE TABLE truie (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    race VARCHAR(50)
);

INSERT INTO truie (nom, race) VALUES
('Rosie', 'Large White'),
('Bella', 'Landrace'),
('Luna', 'Duroc');

