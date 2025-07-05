-- Tabe regle gestion temporaire
CREATE TABLE bao_regle_gestion (
    id SERIAL PRIMARY KEY,
    nom_regle VARCHAR(50) UNIQUE,
    valeur DECIMAL(10,2)
);


CREATE TABLE bao_regle_gestion_porc(
    id SERIAL PRIMARY KEY,
    idRace INTEGER,
    prix_unitaire DECIMAL(10,2)
);


INSERT INTO bao_regle_gestion(nom_regle,valeur) VALUES ('prix_vente_porc', 50000), ('prix_achat_aliment', 3000);

-- Table de recette prenant les valeurs venant de regle_gestion
CREATE OR REPLACE VIEW bao_view_recette AS
SELECT 
    c.id_commande,
    c.nomclient,
    -- cl.nom_client,
    c.date_livraison AS date_recette,
    c.quantite,
    (SELECT valeur FROM bao_regle_gestion WHERE nom_regle = 'prix_vente_porc') AS prix_unitaire,
    c.quantite * (SELECT valeur FROM bao_regle_gestion WHERE nom_regle = 'prix_vente_porc') AS prix_total
FROM 
    bao_commande c
-- JOIN 
    -- bao_client cl ON c.id_client = cl.id_client
WHERE 
    c.statut_livraison = 'livre';



SELECT SUM(prix_total) AS total_recette
FROM bao_view_recette
WHERE date_recette BETWEEN '2023-01-01' AND '2023-12-31';



CREATE OR REPLACE VIEW bao_view_depenses_totales AS
SELECT 
    'Achats' AS type_depense,
    sm.date_mouvement AS date_depense,
    sm.quantite * (SELECT valeur FROM bao_regle_gestion WHERE nom_regle = 'prix_achat_aliment') AS montant
FROM 
    bao_stockage_mouvement sm
WHERE 
    sm.type_mouvement = 'ajout'
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