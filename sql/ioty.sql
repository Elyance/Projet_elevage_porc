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
INSERT INTO bao_commande (id_commande, id_client, id_enclos_portee, quantite, date_commande, adresse_livraison, date_livraison, statut_livraison) VALUES
(1, 1, 1, 4, '2025-07-10', 'Lot II A 45', NULL, 'en attente'),
(2, 2, 2, 2, '2025-07-12', 'Fianarantsoa', NULL, 'en attente'),
(11, 1, 1, 2, '2025-07-15', 'Lot II A 45', NULL, 'en attente'),
(12, 2, 2, 3, '2025-07-16', 'Fianarantsoa', NULL, 'en attente');