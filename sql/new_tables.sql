
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
    reapprovisionnement_aliments ra

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

